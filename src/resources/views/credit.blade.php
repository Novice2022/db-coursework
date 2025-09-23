{{-- 

$credit: {
    id
    name
    amount
    rate
    term
    start_date
}

$payments: [
    {
        amount
        datetime
    }
]

$fines: [
    {
        id
        amount
        reason
        datetime
        payed_at
    }
]

--}}

<x-app-layout>
    {{-- <h2>Debug</h2>
    <div class="debug">
        <span>{{ print_r($credit) }}</span>
        <span>{{ print_r($payments) }}</span>
        <span>{{ print_r($fines) }}</span>
    </div> --}}

    <div class="container">
        <div class="row">
            <div class="credit">
                <h2>{{ $credit['name'] }}</h2>
                <div class="info">
                    <h3>Начальная сумма {{ $credit['amount'] }}&nbsp;руб.</h3>
                    <h3>Под {{ $credit['rate'] }}% годовых на {{ $credit['term'] }} мес.</h3>
                    <h3>От {{ $credit['start_date'] }}</h3>
                    <hr>
                    <h3>Осталось {{ $remains['creditAmountRemains'] }}&nbsp;руб.</h3>
                </div>
            </div>
    
            @if ($fines)
                <div class="fines">
                    <h2>Штрафы</h2>
                    <div class="list">
                        @foreach ($fines as $fine)
                            <form
                                action="{{ route('fine.update', $fine['id']) }}"
                                method="post"
                                class="fine"
                                @class(['payed' => $fine['payed_at']])
                            >
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <span class="reason">{{ $fine['reason'] }}</span>
                                    <span class="amount">{{ $fine['amount'] }}</span>
                                </div>
                                <div class="row">
                                    <span class="datetime">{{ $fine['datetime'] }}</span>
                                    @if ($fine['payed_at'])
                                        <span class="status">Оплачен {{ $fine['payed_at'] }}</span>
                                    @else
                                        <button class="primary" type="submit">Оплатить</button>
                                    @endif
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    
        @if ($payments)
            @php
                $paymentsRemainsCount = $credit['term'] - count($payments);
                $paymentsRemainsSumma = 0;

                foreach ($payments as $payment) {
                    $paymentsRemainsSumma += $payment['amount'];
                }
            @endphp

            <div class="payments">
                <h2>Платежи</h2>

                <div class="remains">
                    <span class="payed">Выплачено: {{ $paymentsRemainsSumma }}</span>
                    <br>
                    <span class="count">Осталось платежей: {{ $paymentsRemainsCount }}</span>
                    <br>
                    <span class="perMonthAmount">Каждый по {{ $remains['monthlyPayment'] }}&nbsp;руб.</span>
                </div>
        
                <div class="toggle">
                    <button id="toggle-payments" class="default" type="button">Показать историю платежей</button>
                    <div id="payments-list" class="list">
                        @foreach ($payments as $payment)
                            <div class="payment">
                                <span class="amount">{{ $payment['amount'] }}&nbsp;руб.</span>
                                <span class="datetime">{{ $payment['datetime'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>

        const togglePayments = document.getElementById('toggle-payments');
        const paymentsList = document.getElementById('payments-list');

        togglePayments.addEventListener('click', () => {
            paymentsList.classList.toggle('expanded');
            
            togglePayments.innerText = paymentsList.classList.contains('expanded') ?
                'Свернуть' : 'Показать историю платежей';
        });

    </script>

    <style>

        .row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .container {
            margin-top: 50px;
            margin-bottom: 70px;
            display: flex;
            flex-direction: column;
            gap: 25px;

            h2 {
                margin: 10px 0;
            }

            .credit {
                .info {
                    h3 {
                        margin: 5px 0;
                    }
                }
            }

            .list {
                display: flex;
                flex-direction: column;
                gap: 5px;
                width: 100%;
            }

            .fine,
            .payment {
                padding: 10px;
                display: flex;
                border: solid 2px rgb(240, 240, 240);
                border-radius: 10px;
            }

            .fine {
                flex-direction: column;
                gap: 15px;

                &.payed {
                    border-color: rgb(0, 216, 144);
                }
            }

            .payment {
                justify-content: space-between;
            }

            .payments {
                .toggle {
                    display: flex;
                    flex-direction: column;
                    gap: 20px;

                    .list {
                        height: 0;
                        overflow: hidden;

                        &.expanded {
                            height: max-content;
                        }
                    }
                }

                .remains {
                    margin-bottom: 10px;
                }
            }
        }

    </style>
</x-app-layout>
