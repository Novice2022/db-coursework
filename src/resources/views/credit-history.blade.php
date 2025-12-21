<x-app-layout>
    <div class="container">
        <h2>История кредитования</h2>
        
        @if($credits && $credits->count() > 0)
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
                        <a class="row-link" href="{{ route('credits.show', $credit['id']) }}">
                            <span class="monospace">{{ $credit['name'] }}</span>
                            <span class="number-column monospace">{{ number_format($credit['amount'], 2) }}</span>
                            <span class="number-column monospace">{{ $credit['rate'] }}</span>
                            <span class="number-column monospace">{{ $credit['term'] }}</span>
                            <span class="monospace">{{ $credit['start_date'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <div class="alert alert-info">
                У вас пока нет кредитов.
            </div>
        @endif
    </div>
</x-app-layout>