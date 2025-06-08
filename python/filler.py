from typing import Union
from os import system
from datetime import datetime, timedelta
from time import sleep
from sys import platform
import threading

import psycopg2
from bcrypt import hashpw, gensalt

from constants import (
    DB_CONFIG,
    STATIC,
    generate_non_static_data,
    THREADS_STATES,
    stop_event,
    lock
)

# from table import Table


def clear_console() -> None:
    if platform == 'win32':
        return system('cls')

    system('clear')
    

def fill_table(
    table: str,
    entities: list[dict[str, Union[str, int]]],
    display_table: bool = True
) -> None:
    def generate_query(entity: dict[str, Union[str, int]]) -> str:
        attributes = ', '.join(entity.keys())
        values = ', '.join((f"'{value}'" for value in entity.values()))

        return f"INSERT INTO {table} ({attributes}) VALUES ({values});"


    if display_table:
        print(f"Table {table}")

    # headers = tuple(entities[0].keys())
    # rows = []

    conn = None

    try:
        conn = psycopg2.connect(**DB_CONFIG)
        cursor = conn.cursor()
        
        entities_amount = len(entities)

        for entity_index, entity in enumerate(entities, 1):
            print(f" < {table:<21} {round(101 - ((entities_amount / entity_index) % 100), 3):>7}%      \r", end='')

            # if display_table:
            #     rows.append(tuple(entity.values()))

            query = generate_query(entity)
            cursor.execute(query)

            if entity_index % 200 == 0:
                conn.commit()

        print(f" < {table:<21}  done   ")
        
        conn.commit()

        # if display_table:
        #     Table.display(headers, rows)
        
        print('\r                                             \r', end='')
        
    except Exception as e:
        print(f"Exception: {e}")
    finally:
        if conn:
            cursor.close()
            conn.close()


def main():
    clear_console()

    '''
    while True:
        move = input("Recreate tables?\n[Y/n] > ").lower()

        if move in ('y', 'n'):
            if move == 'y':
                conn = None

                try:
                    conn = psycopg2.connect(**DB_CONFIG)
                    cursor = conn.cursor()

                    """
DROP INDEX individual_idx;
DROP INDEX legal_idx;
DROP INDEX clients_login_idx;
DROP INDEX credits_idx;
DROP INDEX payments_idx;
DROP INDEX fines_idx;
                    """

                    cursor.execute("""
DROP TABLE fines;
DROP TABLE payments;
DROP TABLE credits;
DROP TABLE credit_type;
DROP TABLE individual_entities;
DROP TABLE credit_history;
DROP TABLE legal_entities;
DROP TABLE profitability;
DROP TABLE company_industry;
DROP TABLE clients;
DROP TABLE entity_type;

CREATE TABLE entity_type (
    id SERIAL PRIMARY KEY,
    name VARCHAR(16) NOT NULL
);

CREATE TABLE clients (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    entity_type_id SMALLINT REFERENCES entity_type(id)
        ON DELETE CASCADE,
    fullname VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL,
    login VARCHAR(30) NOT NULL UNIQUE,
    password VARCAR(60) NOT NULL,
    address VARCHAR(255) NOT NULL,
    registration_date DATE DEFAULT NOW()
);

CREATE TABLE company_industry (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    supplement DECIMAL(3, 1) NOT NULL
);

CREATE TABLE profitability (
    id SERIAL PRIMARY KEY,
    quality VARCHAR(25) NOT NULL,
    supplement DECIMAL(3, 1) NOT NULL
);

CREATE TABLE legal_entities (
    id SERIAL PRIMARY KEY,
    client_id UUID REFERENCES clients(id)
        ON DELETE CASCADE,
    industry_id SMALLINT REFERENCES company_industry(id)
        ON DELETE CASCADE,
    profitability_id SMALLINT REFERENCES profitability(id)
        ON DELETE CASCADE,
    guarantee_amount DECIMAL(13, 2) NOT NULL
);

CREATE TABLE credit_history (
    id SERIAL PRIMARY KEY,
    quality VARCHAR(11) NOT NULL,
    supplement DECIMAL(3, 1)
);


CREATE TABLE individual_entities (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    client_id UUID REFERENCES clients(id)
        ON DELETE CASCADE,
    credit_history_id SMALLINT REFERENCES credit_history(id)
        ON DELETE CASCADE,
    income DECIMAL(9, 2) NOT NULL
);

CREATE TABLE credit_type (
    id SERIAL PRIMARY KEY,
    entity_type_id SMALLINT REFERENCES entity_type(id)
        ON DELETE CASCADE,
    name VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE credits (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    client_id UUID REFERENCES clients(id)
        ON DELETE CASCADE,
    credit_type_id SMALLINT REFERENCES credit_type(id)
        ON DELETE CASCADE,
    amount DECIMAL(12, 2) NOT NULL,
    rate DECIMAL(5, 2) NOT NULL,
    term SMALLINT NOT NULL,
    start_date TIMESTAMP NOT NULL DEFAULT NOW(),
    end_date DATE
);

CREATE TABLE payments (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    credit_id UUID REFERENCES credits(id)
        ON DELETE CASCADE,
    amount DECIMAL(10, 2) NOT NULL,
    datetime TIMESTAMP DEFAULT NOW()
);

CREATE TABLE fines (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    credit_id UUID REFERENCES credits(id)
        ON DELETE CASCADE,
    amount DECIMAL(9, 2) NOT NULL,
    reason TEXT NOT NULL,
    datetime TIMESTAMP DEFAULT NOW(),
    payed_at TIMESTAMP DEFAULT NULL
);
""")
                    
                    conn.commit()
                except Exception as e:
                    raise e
                finally:
                    if conn:
                        cursor.close()
                        conn.close()
            break

    while True:
        move = input("Create indexes?\n[Y/n] > ").lower()

        if move in ('y', 'n'):
            if move == 'y':
                conn = None

                try:
                    conn = psycopg2.connect(**DB_CONFIG)
                    cursor = conn.cursor()
                    
                    cursor.execute("""
CREATE INDEX individual_idx ON individual_entities USING HASH (client_id);
CREATE INDEX legal_idx ON legal_entities USING HASH (client_id);
CREATE INDEX clients_login_idx ON clients USING HASH (login);
CREATE INDEX credits_idx ON credits USING HASH (client_id);
CREATE INDEX payments_idx ON payments USING HASH (credit_id);
CREATE INDEX fines_idx ON fines USING HASH (credit_id);
""")

                    conn.commit()
                except Exception as e:
                    raise e
                finally:
                    if conn:
                        cursor.close()
                        conn.close()
            break

    print()
    '''

    clients_amount = int(
        input("Clients amount:\n(int) > ")
            .replace('_', '')
    )
    threads_amount = int(
        input("Threads amount:\n(int) > ")
    )
    insert_static = True if input('Insert static data:\n(y/n) > ').lower() == 'y' else False

    clear_console()

    start_time = datetime.now()

    per_thread = int(clients_amount / threads_amount)

    threads = []

    try:
        for thread_id in range(threads_amount):
            thread_name = f'#{thread_id + 1}'

            thread = threading.Thread(
                name=thread_name,
                target=generate_non_static_data,
                args=(
                    per_thread,
                    thread_name
                )
            )
            threads.append(thread)
            thread.start()

        ready_counter_space = len(str(per_thread))
        start = datetime.now()

        processing = True

        while processing:
            with lock:
                clear_console()
                print(f'\nThreads ({timedelta(seconds=(datetime.now() - start).seconds)}):')

                for (name, ready) in THREADS_STATES.items():
                    print(f' > {name}\t{ready:>{ready_counter_space}}/{per_thread}' + (' - done' if ready == per_thread else ''))

            if not any([thread.is_alive() for thread in threads]):
                if processing:
                    processing = False
                    continue

                break

            sleep(1)
    except Exception as e:
        stop_event.set()
        [thread.join() for thread in threads]

        print(e.with_traceback())
        exit()

    print('\nFilling:\n')

    for table in filter(lambda table: (table['is_static'] and insert_static) or not table['is_static'], STATIC):
        fill_table(
            table['table'],
            table['entities'],
            display_table=False
        )

    print("\nSuccess!")
    print('Time left -', timedelta(seconds=(datetime.now() - start_time).seconds))


if __name__ == "__main__":
    main()
