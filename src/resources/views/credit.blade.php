{{-- 

$credit: {
    info => {
        id
        name
        amount
        rate
        term
        start_date
    }
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
        <span>{{ print_r($credit['info']) }}</span>
        <span>{{ print_r($payments) }}</span>
        <span>{{ print_r($fines) }}</span>
    </div> --}}

    <div class="container">
        <div class="credit">
            <h2>{{ $credit['info']['name'] }}</h2>
            <div class="info">
                <h3>{{ $credit['info']['amount'] }}&nbsp;руб.</h3>
                <h3>Под {{ $credit['info']['rate'] }}% годовых.</h3>
                <h3>От {{ $credit['info']['start_date'] }}</h3>
                <h3>На {{ $credit['info']['term'] }} мес.</h3>
            </div>
        </div>

        <div class="fines">
            <h2>Штрафы</h2>

            @if ($fines)
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
            @else
                <h3>Пусто</h3>
            @endif
        </div>
    
        <div class="payments">
            <h2>Платежи</h2>
    
            @if ($payments)
                <div class="list">
                    @foreach ($payments as $payment)
                        <div class="payment">
                            <span class="amount">{{ $payment['amount'] }}&nbsp;руб.</span>
                            <span class="datetime">{{ $payment['datetime'] }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <h3>Пусто</h3>
            @endif
        </div>
    </div>

    <style>

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

                .row {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                &.payed {
                    border-color: rgb(0, 216, 144);
                }
            }

            .payment {
                justify-content: space-between;
            }
        }

    </style>
</x-app-layout>
