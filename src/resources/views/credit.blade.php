<x-app-layout>
    <div class="container py-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-4">{{ $credit['name'] }}</h2>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div>
                        <p class="text-gray-600 mb-1">Начальная сумма</p>
                        <p class="text-xl font-bold">{{ number_format($credit['amount'], 2) }} ₽</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Ставка</p>
                        <p class="text-xl font-bold">{{ $credit['rate'] }}%</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Срок</p>
                        <p class="text-xl font-bold">{{ $credit['term'] }} мес.</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Дата начала</p>
                        <p class="text-xl font-bold">{{ \Carbon\Carbon::parse($credit['start_date'])->format('d.m.Y') }}</p>
                    </div>
                </div>
                
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold mb-4">Остаток по кредиту</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-600 mb-1">Осталось выплатить</p>
                            <p class="text-2xl font-bold text-blue-600">{{ number_format($remains['creditAmountRemains'], 2) }} ₽</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Ежемесячный платеж</p>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($remains['monthlyPayment'], 2) }} ₽</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @if ($fines && $fines->count() > 0)
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Штрафы</h3>
                </div>
                
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Причина</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Сумма</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($fines as $fine)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $fine['reason'] }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ number_format($fine['amount'], 2) }} ₽</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($fine['datetime'])->format('d.m.Y H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($fine['payed_at'])
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                    Оплачен
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                                    Не оплачен
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if (!$fine['payed_at'])
                                                <form action="{{ route('credits.fines.update', ['creditId' => $credit['id'], 'fineId' => $fine['id']]) }}" 
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-900">
                                                        Оплатить
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        
        @if ($payments && $payments->count() > 0)
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Платежи</h3>
                    <a href="{{ route('credits.payments.create', $credit['id']) }}" class="btn btn-primary">
                        Внести платеж
                    </a>
                </div>
                
                @php
                    $paymentsRemainsCount = $credit['term'] - count($payments);
                    $paymentsRemainsSumma = $payments->sum('amount');
                    $totalPaidPercentage = ($paymentsRemainsSumma / $credit['amount']) * 100;
                @endphp
                
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-gray-600 mb-1">Выплачено</p>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($paymentsRemainsSumma, 2) }} ₽</p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ min($totalPaidPercentage, 100) }}%"></div>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ round($totalPaidPercentage, 1) }}% от общей суммы</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Осталось платежей</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $paymentsRemainsCount }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Ежемесячный платеж</p>
                            <p class="text-2xl font-bold text-purple-600">{{ number_format($remains['monthlyPayment'], 2) }} ₽</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h4 class="text-lg font-medium">История платежей</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Сумма</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($payment['datetime'])->format('d.m.Y H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ number_format($payment['amount'], 2) }} ₽</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500 mb-4">По этому кредиту еще не было платежей</p>
                <a href="{{ route('credits.payments.create', $credit['id']) }}" class="btn btn-primary">
                    Внести первый платеж
                </a>
            </div>
        @endif
        
        <div class="mt-6">
            <a href="{{ route('client.dashboard') }}" class="btn btn-secondary">
                Назад к списку кредитов
            </a>
        </div>
    </div>
</x-app-layout>