<x-app-layout>
    <div class="container py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Мои кредиты</h2>
            <a href="{{ route('client.credits.create') }}" class="btn btn-primary">
                Оформить новый кредит
            </a>
        </div>
        
        @if($credits->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-500 mb-4">У вас пока нет кредитов</p>
                <a href="{{ route('client.credits.create') }}" class="btn btn-primary">
                    Оформить первый кредит
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Кредит</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Сумма</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ставка</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Срок</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата начала</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($credits as $credit)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $credit->creditType->name ?? 'Не указано' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ number_format($credit->amount, 2) }} ₽</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $credit->rate }}%</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $credit->term }} мес.</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $credit->start_date->format('d.m.Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($credit->end_date && $credit->end_date->isPast())
                                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">
                                                Завершен
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">
                                                Активен
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('credits.show', $credit->id) }}" class="text-blue-600 hover:text-blue-900">
                                            Подробнее
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($credits->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $credits->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>