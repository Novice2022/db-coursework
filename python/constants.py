ENTITY_TYPE = [
    {
        'name': 'Физическое лицо',
    },
    {
        'name': 'Юридическое лицо'
    }
]

ROLE = [
    {
        'name': 'client',
    },
    {
        'name': 'manager',
    },
    {
        'name': 'analyst',
    },
    {
        'name': 'admin',
    }
]

COMPANY_INDUSTRY = [
    {
        'name': 'IT и разработка ПО',
        'supplement': 1.0
    },
    {
        'name': 'Финансовые услуги и банкинг',
        'supplement': 1.5
    },
    {
        'name': 'Телекоммуникации',
        'supplement': 2.0
    },
    {
        'name': 'Медицина и фармацевтика',
        'supplement': 2.0
    },
    {
        'name': 'Образование',
        'supplement': 2.5
    },
    {
        'name': 'Розничная торговля',
        'supplement': 2.5
    },
    {
        'name': 'Гостиницы и рестораны',
        'supplement': 3.0
    },
    {
        'name': 'Транспорт и логистика',
        'supplement': 3.0
    },
    {
        'name': 'Строительство',
        'supplement': 4.0
    },
    {
        'name': 'Производство (легкая промышленность)',
        'supplement': 3.5
    },
    {
        'name': 'Производство (тяжелая промышленность)',
        'supplement': 4.0
    },
    {
        'name': 'Сельское хозяйство',
        'supplement': 4.5
    },
    {
        'name': 'Добыча полезных ископаемых',
        'supplement': 5.0
    },
    {
        'name': 'Недвижимость',
        'supplement': 3.5
    },
    {
        'name': 'Энергетика',
        'supplement': 3.0
    },
    {
        'name': 'Маркетинг и реклама',
        'supplement': 2.5
    },
    {
        'name': 'Консалтинг',
        'supplement': 2.0
    },
    {
        'name': 'Творческие индустрии (дизайн, искусство)',
        'supplement': 3.5
    },
    {
        'name': 'Экология и переработка',
        'supplement': 2.5
    },
    {
        'name': 'Стартапы (неопределенная сфера)',
        'supplement': 5.0
    }
]

PROFITABILITY = [
    {
        'quality': 'Высокая (>20%)',
        'supplement': -3.0
    },
    {
        'quality': 'Выше среднего (15-20%)',
        'supplement': -1.5
    },
    {
        'quality': 'Средняя (10-15%)',
        'supplement': 0.0
    },
    {
        'quality': 'Ниже среднего (5-10%)',
        'supplement': 2.0
    },
    {
        'quality': 'Низкая (0-5%)',
        'supplement': 3.5
    },
    {
        'quality': 'Убыточная (<0%)',
        'supplement': 5.0
    },
    {
        'quality': 'Неизвестна',
        'supplement': 4.0
    }
]

CREDIT_HISTORY = [
    {
        'quality': 'Идеальная', 
        'supplement': -2.5
    },
    {
        'quality': 'Хорошая', 
        'supplement': -1.0
    },
    {
        'quality': 'Средняя',
        'supplement': 0.0
    },
    {
        'quality': 'Проблемная',
        'supplement': 2.0
    },
    {
        'quality': 'Плохая',
        'supplement': 4.0
    },
    {
        'quality': 'Нет истории',
        'supplement': 1.5
    }
]

CREDIT_TYPE = [
    {
        'entity_type_id': 1,
        'name': 'Потребительский',
        'description': 'Вариант нецелевого займа на любые нужды. Может быть с залогом или без. Деньги переводят на карту или выдают наличными.\nТакие кредиты банки выдают гражданам России. Остальные требования зависят от конкретной кредитной организации./nСрок кредитования обычно составляет не более пяти лет.'
    },
    {
        'entity_type_id': 1,
        'name': 'Автокредит',
        'description': 'Одна из разновидностей целевого кредита. Обычно машина остается в залоге у банка до момента полного погашения.\nСредства банк переводит или заемщику, или сразу продавцу — дилеру или автосалону. После оформления сделки клиент обязан предоставить кредитору подтверждение целевого использования денег. Обычно доказательством служит копия ПТС.\nКаждый банк ищет партнеров среди производителей или поставщиков машин, чтобы предложить заемщикам более выгодные условия, чем конкуренты. Также сейчас действуют государственные программы поддержки для покупки автомобилей.'
    },
    {
        'entity_type_id': 1,
        'name': 'Ипотечный',
        'description': 'Относится к целевым обеспеченным кредитным продуктам. Заемщик приобретает жилье, банк переводит средства за него продавцу. Квартира или дом остаются в залоге у банка до полного погашения задолженности.'
    },
    {
        'entity_type_id': 2,
        'name': 'Коммерческая ипотека',
        'description': 'Ипотечный заем нужен для покупки коммерческой недвижимости. В качестве залога обычно выступает само помещение. При этом компания может использовать его для производства или торговли.Имеет ли право заемщик сдавать площади в аренду, прописывают в договоре.'
    },
    {
        'entity_type_id': 2,
        'name': 'Кредит на текущую деятельность',
        'description': 'Кредитные организации предлагают три вида кредитования на текущую деятельность:\n<*> на обеспечение контрактных обязательств;<*> на расширение действующего бизнеса;<*> на решение финансовых затруднений — например, устранение кассовых разрывов (возобновляемая кредитная линия, овердрафт).\nТакие займы могут быть обеспеченными и необеспеченными.'
    },
    {
        'entity_type_id': 2,
        'name': 'Лизинг',
        'description': 'Лизинг — аренда оборудования с последующим выкупом или возвратом кредитору. Преимущества лизинга: отсутствие налогов на имущество и затрат на содержание.\nКогда срок действия договора подходит к концу, пользователь может приобрести технику по остаточной стоимости.'
    },
    {
        'entity_type_id': 2,
        'name': 'Универсальный',
        'description': 'Кредит для бизнеса, который выдают без привязки к какой-то конкретной цели. При заключении договора банк может учесть особенности работы компании, например сезонный пик продаж, и приурочить к нему выплаты.'
    },
    {
        'entity_type_id': 2,
        'name': 'Факторинг',
        'description': 'Заем для компаний, которые работают по системе отсрочки платежей. Банк (фактор) выполняет роль финансового посредника в сделке между продавцом и покупателем. Поставщик получает деньги от фактора сразу после выполнения своей части обязательств, а контрагент может рассчитаться позднее — в течение заранее оговоренного срока.\nПо степени информирования факторинг бывает двух видов:\n<*> Открытый — когда покупатель знает, что фактор оплатил товар за него. В этом случае он сам возвращает деньги банку.<*> Закрытый — когда продавец не сообщает контрагенту о факторинге. Тогда все расчеты ведутся через него: покупатель платит продавцу, а продавец — фактору.'
    },
    {
        'entity_type_id': 2,
        'name': 'Инвестиционный',

        'description': 'Инвестиционные займы берут на финансирование крупных проектов: строительство, капитальный ремонт помещений, обновление оборудования, покупку транспорта, открытие новых филиалов, расширение действующего производства.\nКакой кредит лучше? Зависит от индивидуальных задач заемщика. На покупку квартиры не обязательно брать ипотеку — если в ваших силах выплатить несколько миллионов рублей за пять лет, можно оформить нецелевой потребительский кредит. Но имейте в виду, что при оформлении договора на большую сумму, скорее всего, потребуется залог.\nСегодня на рынке банковских услуг есть кредитные продукты на любые цели. Среди такого разнообразия обязательно найдется вариант, который поможет воплотить ваши планы с минимальными затратами. Главное — трезво оценивать нагрузку на бюджет и внимательно читать условия договора.'
    }
]


USERS = []

CLIENTS = []

CREDITS = []

FINES = []

INDIVIDUAL_ENTITIES = []

LEGAL_ENTITIES = []

PAYMENTS = []


DB_CONFIG = {
    'host': 'db-coursework-pgsql-1',
    'port': '5432',
    'database': 'bank',
    'user': 'postgres',
    'password': 'postgres',
    'client_encoding': 'utf-8'
}


STATIC = [
    {
        'is_static': True,
        'table': 'entity_type',
        'entities': ENTITY_TYPE
    },
    {
        'is_static': True,
        'table': 'role',
        'entities': ROLE
    },
    {
        'is_static': True,
        'table': 'company_industry',
        'entities': COMPANY_INDUSTRY
    },
    {
        'is_static': True,
        'table': 'profitability',
        'entities': PROFITABILITY
    },
    {
        'is_static': True,
        'table': 'credit_history',
        'entities': CREDIT_HISTORY
    },
    {
        'is_static': True,
        'table': 'credit_type',
        'entities': CREDIT_TYPE
    },
    {
        'is_static': False,
        'table': 'clients',
        'entities': CLIENTS
    },
    {
        'is_static': False,
        'table': 'users',
        'entities': USERS
    },
    {
        'is_static': False,
        'table': 'individual_entities',
        'entities': INDIVIDUAL_ENTITIES
    },
    {
        'is_static': False,
        'table': 'legal_entities',
        'entities': LEGAL_ENTITIES
    },
    {
        'is_static': False,
        'table': 'credits',
        'entities': CREDITS
    },
    {
        'is_static': False,
        'table': 'payments',
        'entities': PAYMENTS
    },
    {
        'is_static': False,
        'table': 'fines',
        'entities': FINES
    },
]


import names
import uuid
import bcrypt
import threading
from random import randint
from time import time
from datetime import datetime


def create_generator(left: int, right: int):
    while True:
        yield randint(left, right)


CLIENTS_LEVELS = {
    'individuals': {
        'income': {
            1: create_generator(35_000, 150_000),
            2: create_generator(150_000, 500_000)
        },
        'credit_amount': {
            1: create_generator(50_000, 500_000),
            2: create_generator(400_000, 10_000_000)
        },
        'term': {
            1: create_generator(6, 60),
            2: create_generator(30, 180)
        }
    },
    'legals': {
        'guarantee_amount': {
            1: create_generator(500_000, 10_000_000),
            2: create_generator(10_000_000, 200_000_000),
            3: create_generator(200_000_000, 1_000_000_000)
        },
        'credit_amount': {
            1: create_generator(500_000, 100_000_000),
            2: create_generator(5_000_000, 250_000_000),
            3: create_generator(100_000_000, 1_000_000_000)
        },
        'term': {
            1: create_generator(24, 60),
            2: create_generator(32, 96),
            3: create_generator(60, 180)
        }
    }
}

TIMESTAMP = {
    'second': 1,
    'minute': 60,
    'hour': 60 * 60,
    'day': 60 * 60 * 24,
    'week': 60 * 60 * 24 * 7,
    'month': 60 * 60 * 24 * 30
}


THREADS_STATES = {}

lock = threading.Lock()
stop_event = threading.Event()

def generate_non_static_data(amount: int, thread_name: str) -> None:
    def generate_credit(
        credit_type_id: int,
        credit_amount: int,
        term: int
    ) -> None:
        if (randint(1, 100) > 10):
            credit_id = uuid.uuid4()

            monthly_rate = (interest_rate / 1_200)

            monthly_payment = round((credit_amount * monthly_rate * ((1 + monthly_rate) ** term)) / (((1 + monthly_rate) ** term) - 1), 2)
            payed_terms = randint(0, term)

            payment_datetime = int(time()) - randint(0, TIMESTAMP['month']) - TIMESTAMP['month'] * payed_terms
            fines_probabilities = (0 if randint(0, 100) > 1 else 1 for _term in range(payed_terms))

            current_time = time()

            for fine in fines_probabilities:
                if payment_datetime > current_time:
                    break

                if (fine):
                    FINES.append({
                        'id': uuid.uuid4(),
                        'credit_id': credit_id,
                        'amount': 1000,
                        'reason': 'Просрочка платежа',
                        'datetime': datetime.fromtimestamp(payment_datetime)
                    })
                else:
                    PAYMENTS.append({
                        'id': uuid.uuid4(),
                        'credit_id': credit_id,
                        'amount': monthly_payment,
                        'datetime': datetime.fromtimestamp(payment_datetime)
                    })

                payment_datetime += TIMESTAMP['month']

            CREDITS.append({
                'id': credit_id,
                'client_id': client_id,
                'credit_type_id': credit_type_id,
                'amount': credit_amount,
                'rate': interest_rate,
                'term': term
            })


    with lock:
        THREADS_STATES[thread_name] = 0

    for i in range(amount):
        if (stop_event.is_set()):
            break

        client_id = uuid.uuid4()

        first_name = names.get_first_name()
        last_name = names.get_last_name()

        name = f"{first_name}_{client_id.node}_login"
        password = f"{last_name}_password"

        USERS.append(
            {
                'client_id': client_id,
                'role_id': 1,
                'name': name,
                'email': f"{name}@mail.ru".lower(),
                'password': bcrypt.hashpw(password.encode('utf-8'), bcrypt.gensalt(rounds=12)).decode('utf-8').replace('$2b$', '$2y$'),
            }
        )

        client = {
            'id': client_id,
            'entity_type_id': randint(1, 2),
            'fullname': f"{first_name} {last_name}",
            'phone': '+7' + ''.join([str(randint(1, 9)) for _digit in range(10)]),
            'address': f"ул. Ленина {i}"
        }

        CLIENTS.append(client)

        credit_type_id = None
        credit_amount = None

        random_client_level = randint(1, 10)

        interest_rate = 21  # base rate, % - https://cbr.ru/hd_base/KeyRate/
        term = None

        credits_amount = 1
        _random = randint(0, 10)

        if _random > 5:
            credits_amount += 1
        if _random > 7:
            credits_amount += 1
        if _random > 9:
            credits_amount += 1

        if client['entity_type_id'] == 1:
            credit_history_id = randint(1, 6)
            client_level = 1 if random_client_level < 8 else 2

            INDIVIDUAL_ENTITIES.append({
                'id': uuid.uuid4(),
                'client_id': client_id,
                'credit_history_id': credit_history_id,
                'income': next(CLIENTS_LEVELS['individuals']['income'][client_level])
            })

            for _ in range(credits_amount):
                credit_type_id = randint(1, 3)
                credit_amount = next(CLIENTS_LEVELS['individuals']['credit_amount'][client_level])
                interest_rate += CREDIT_HISTORY[credit_history_id - 1]['supplement']
                term = next(CLIENTS_LEVELS['individuals']['term'][client_level])

                generate_credit(credit_type_id, credit_amount, term)
        else:
            industry_id = randint(1, 20)
            profitability_id = randint(1, 7)
            client_level = 1 if random_client_level < 7 else 2 if random_client_level > 7 else 3

            LEGAL_ENTITIES.append({
                'id': uuid.uuid4(),
                'client_id': client_id,
                'industry_id': industry_id,
                'profitability_id': profitability_id,
                'guarantee_amount': next(CLIENTS_LEVELS['legals']['guarantee_amount'][client_level])
            })

            for _ in range(credits_amount):
                credit_type_id = randint(4, 9)
                credit_amount = next(CLIENTS_LEVELS['legals']['credit_amount'][client_level])
                interest_rate += COMPANY_INDUSTRY[industry_id - 1]['supplement'] + PROFITABILITY[profitability_id - 1]['supplement']
                term = next(CLIENTS_LEVELS['legals']['term'][client_level])

                generate_credit(credit_type_id, credit_amount, term)

        with lock:
            THREADS_STATES[thread_name] += 1
