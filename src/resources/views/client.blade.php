{{-- 

Физ. лицо
[
    'entityType' => 'individual',
    'info' => [
        fullname => string,
        income => number,
        credit_history_quality => string,
        credit_history_supplement => number
    ],
    'credits' => Кредиты*
]

Юр. лицо
[
    'entityType' => 'legal',
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
    {{-- <h2>Debug</h2>
    <div class="debug">
        <span>{{ $credits }}</span>
    </div> --}}

    @if ($credits)
        <a href="#credits">
            <h2 id="credits">Ваши кредиты</h2>
        </a>
        <div class="credits">

            <div class="grid-table credits-table">
                <div class="head">
                    <span>Название</span>
                    <span>Сумма, руб.</span>
                    <span>Ставка, %</span>
                    <span>Срок, мес.</span>
                    <span>Дата оформления</span>
                </div>
                <div class="list">
                    @foreach ($credits as $credit)
                        <a class="row-link" href="{{ route('credit.index', $credit -> id) }}">
                            <span class="monospace">{{ $credit['name'] }}</span>
                            <span class="number-column monospace">{{ $credit['amount'] }}</span>
                            <span class="number-column monospace">{{ $credit['rate'] }}</span>
                            <span class="number-column monospace">{{ $credit['term'] }}</span>
                            <span class="monospace">{{ $credit['start_date'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('credit.history', $client_id) }}" class="link">История кредитования</a>
        </div>
    @endif
    
    <a href="#create-credit">
        <h2 id="create-credit">Оформите кредит!</h2>
    </a>
    <div class="create-credit">
        <form action="{{ route('credit.store') }}" method="post">
            @if ($entityType === 'individual')
                <div class="row">
                    <div class="input-section">
                        <h3>Какой кредит вам нужен?</h3>
                        <div class="input">
                            <label for="credit-type-select" class="with-addition">
                                <span>Тип кредита</span>
                                <a href="{{ route('about.credits') }}" class="link no-padding addition">подробнее</a>
                            </label>
                            <select name="credit-type-id" id="credit-type-select">
                                <option selected disabled value="">Выберите подходящий вариант</option>
                                @foreach ($creditTypes as $creditType)
                                    @if ($creditType -> entity_type_id === 1)
                                        <option value="{{ $creditType['id'] }}">{{ $creditType['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="input">
                            <label for="new-credit-amount">Сумма кредита, руб.</label>
                            <input
                                type="number"
                                name="amount"
                                id="new-credit-amount"
                                min="100000"
                                max="10000000"
                                placeholder="100000 - 10000000"
                                value="100000"
                            >
                        </div>
                        <div class="input">
                            <label for="new-credit-term">Срок кредитования, месяцев</label>
                            <input
                                type="number"
                                name="term"
                                id="new-credit-term"
                                min="12"
                                max="120"
                                placeholder="12 - 120"
                                value="36"
                            >
                        </div>
                    </div>
                    <div class="results-section">
                        <h3 class="align-right">Итого</h3>
                        <div class="grid-table key-value-grid-block new-credit-rate">
                            <h4>Расчёт ставки</h4>
                            <div class="rate-table">
                                <div class="head">
                                    <span>Показатель</span>
                                    <span>Значение, %</span>
                                </div>
                                <div class="list">
                                    <div class="list-row">
                                        <div class="key">
                                            <a href="https://cbr.ru/hd_base/KeyRate/" class="link key no-padding">Ставка ЦБ</a>
                                            <div class="empty"></div>
                                        </div>
                                        <span class="value number-column monospace">18</span>
                                    </div>
                                    <div class="list-row">
                                        <span class="key">
                                            Ваша кредитная история (<a href="{{ route('about.creditHistory') }}" class="link no-padding">{{
                                                $info['credit_history_quality']
                                            }}</a>)
                                        </span>
                                        <span class="value number-column monospace">{{ $info['credit_history_supplement'] }}</span>
                                    </div>
                                    <div class="resulting">
                                        <div class="list-row">
                                            <span class="key">Итого</span>
                                            <span class="value number-column monospace">...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('about.rates') }}" class="link">Как уменьшить ставку?</a>
                        </div>
                        <div class="grid-table key-value-grid-block new-credit-monthly-payment">
                            <h4>Ежемесячный платёж</h4>
                            <div class="monthly-payment">
                                <div class="list">
                                    <div class="list-row">
                                        <span class="key">Сумма платежа</span>
                                        <span class="value number-column monospace">...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            
            @endif

            <div class="actions">
                <button type="reset" class="secondary">Сбросить</button>
                <button type="submit" class="primary">Вперёд!</button>
            </div>
        </form>
    </div>

    <style>

        .credits,
        .create-credit {
            justify-self: center;
        }

        h2 {
            margin: 25px 0;
        }

        .grid-table {
            .head {
                display: grid;

                span {
                    text-align: center;
                    font-weight: 800;
                }
            }

            &.credits-table {
                border: var(--primary-border);
                border-radius: var(--block-border-radius);
                margin-bottom: 5px;

                .head,
                .list .row-link {
                    grid-template-columns: 1fr 1fr 1fr 1fr auto;
                    gap: 30px;
                }

                .head {
                    border-bottom: var(--primary-border);
                    padding: 10px;
                }
    
                .list .row-link {
                    padding: 5px 10px;
                    display: grid;
    
                    &:nth-child(2) {
                        background-color: rgb(240, 240, 240);
                    }
    
                    &:hover {
                        background-color: rgb(220, 220, 220);
                    }
    
                    &:last-child {
                        border-radius: 0 0 var(--block-border-radius) var(--block-border-radius);
                    }
                }
            }

            &.key-value-grid-block {
                display: grid;

                .head,
                .list .list-row {
                    grid-template-columns: 2fr 1fr;
                    gap: 15px;
                }
                
                .list {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;

                    .resulting {
                        margin: 0 -10px;
                        padding: 10px 10px 0;
                        border-top: 2px dashed var(--primary-color);
                    }
                }

                .list .list-row {
                    display: grid;
                }
            }

            &.new-credit-rate {
                .rate-table {
                    border: 2px solid var(--primary-color);
                    border-radius: 10px;

                    .head,
                    .list {
                        padding: 10px;
                    }

                    .head {
                        border-bottom: 2px solid var(--primary-color);
                    }
                }
            }

            .number-column {
                text-align: right;
            }
        }

        .create-credit {
            form {
                border: var(--primary-border);
                border-radius: var(--block-border-radius);
                display: flex;
                flex-direction: column;
                gap: 10px;
                padding: 5px;

                .row {
                    display: flex;
                    justify-content: space-between;
                }

                .input-section,
                .results-section {
                    padding: 15px;
                }

                .input-section {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;

                    .input {
                        display: flex;
                        flex-direction: column;

                        label {
                            padding: 0 0 2px 10px;
                            font-size: .85rem;

                            &.with-addition {
                                display: flex;
                                justify-content: space-between;

                                .addition {
                                    padding-right: 10px;
                                    font-size: .7rem;
                                    align-content: center;
                                }
                            }
                        }
                    }
                }

                .results-section {
                    padding-left: 0;
                    display: flex;
                    flex-direction: column;
                    gap: 10px;

                    .align-right {
                        text-align: right;
                    }

                    h4 {
                        margin-bottom: 10px;
                    }
                }

                .actions {
                    display: flex;
                    justify-content: space-between;
                    gap: 25px;
                }
            }
        }

    </style>
</x-app-layout>
