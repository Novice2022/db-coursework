@php
    $client = auth()->user()->client;
    $credits = $client->credits()->with(['creditType', 'payments'])->latest()->take(5)->get();
    $activeCredits = $credits->where('end_date', '>', now())->count();
@endphp

<div>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Мои кредиты</h2>
        
        @if($credits->isEmpty())
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                <svg class="w-12 h-12 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-blue-800 mb-2">У вас пока нет кредитов</h3>
                <p class="text-blue-600 mb-4">Оформите первый кредит, чтобы начать</p>
                <a href="{{ route('client.credits.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Оформить кредит
                </a>
            </div>
        @else
            <!-- Статистика -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <x-dashboard-card 
                    title="Активные кредиты" 
                    :value="$activeCredits"
                    icon="credit"
                    color="blue"
                />
                
                <x-dashboard-card 
                    title="Общая сумма" 
                    :value="number_format($credits->sum('amount'), 0, '.', ' ') . ' ₽'"
                    icon="money"
                    color="green"
                />
                
                <x-dashboard-card 
                    title="Ближайший платеж" 
                    value="15 500 ₽"
                    icon="calendar"
                    color="purple"
                />
            </div>

            <!-- Таблица кредитов -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Кредит</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Сумма</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ставка</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Срок</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($credits as $credit)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $credit->creditType->name }}</div>
                                    <div class="text-sm text-gray-500">от {{ $credit->start_date->format('d.m.Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($credit->amount, 0, '.', ' ') }} ₽</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $credit->rate }}%</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $credit->term }} мес.</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($credit->end_date && $credit->end_date->isPast())
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Завершен
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Активен
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('credit.index', $credit->id) }}" class="text-blue-600 hover:text-blue-900">Подробнее</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($client->credits()->count() > 5)
                <div class="mt-4 text-center">
                    <a href="{{ route('client.credits') }}" class="text-blue-600 hover:text-blue-900 font-medium">
                        Показать все кредиты →
                    </a>
                </div>
            @endif
        @endif
    </div>
</div>