@php

$interestRate = 17;

@endphp

<x-app-layout>
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
                                        <span class="value number-column monospace">{{ $interestRate }}</span>
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
                                            <span class="value number-column monospace">{{ $interestRate + $info['credit_history_supplement'] }}</span>
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
</x-app-layout>
