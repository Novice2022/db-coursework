{{-- 

Физ. лицо
[
    'info' => [
        fullname => string,
        income => number,
        quality => number,
        supplement => number
    ],
    'credits' => Кредиты*
]

Юр. лицо
[
    'info' => [
        fullname: string,
        guarantee_amount: number,
        industry: string,
        industry_supplement: number,
        profitability: string,
        profitability_supplement: number
    ],
    'credits' => Кредиты*
]

Кредиты
[
    [
        id: string,
        name: string,
        amount: number,
        rate: number,
        term: number,
        start_date: date
    ],
    [
        ...
    ]
]

--}}

<x-app-layout>
    <h2>Debug</h2>
    <span class="debug">{{ $info }}</span>

    <div class="credits">
        <h2>Ваши кредиты</h2>

        <div class="grid">
            <div class="head">
                <span>Название</span>
                <span>Сумма, руб.</span>
                <span>Ставка, %</span>
                <span>Срок, мес.</span>
                <span>Дата оформления</span>
            </div>
            <div class="list">
                @foreach ($credits as $credit)
                    <a class="row-link" href="{{ route('credit', $credit -> id) }}">
                        <span>{{ $credit['name'] }}</span>
                        <span class="number-column">{{ $credit['amount'] }}</span>
                        <span class="number-column">{{ $credit['rate'] }}</span>
                        <span class="number-column">{{ $credit['term'] }}</span>
                        <span>{{ $credit['start_date'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    
    <style>

        .debug {
            background-color: rgb(221, 221, 221);
            border-radius: 5px;
            padding: 3px;
            font-family: 'Courier New', Courier, monospace;
            font-size: .65rem;
        }

        .grid {
            width: 100%;
            border: 1px solid rgb(180, 180, 180);
            border-radius: 10px;
        }

        .grid .head {
            display: grid;
            gap: 30px;
            grid-template-columns: 1fr 1fr 1fr 1fr auto;
            border-bottom: 1px solid rgb(180, 180, 180);
            padding: 10px;
        }

        .grid .head span {
            text-align: center;
            font-weight: 800;
        }

        .grid .list .row-link {
            display: grid;
            gap: 30px;
            grid-template-columns: 1fr 1fr 1fr 1fr auto;
            padding: 5px 10px;
        }

        .grid .list .row-link:nth-child(2) {
            background-color: rgb(240, 240, 240);
        }

        .grid .list .row-link:hover {
            background-color: rgb(220, 220, 220);
        }

        .grid .number-column {
            text-align: right;
        }

    </style>
</x-app-layout>
