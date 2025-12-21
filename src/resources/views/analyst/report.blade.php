<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">{{ $data['title'] }}</h2>
                    <div class="space-x-2">
                        <a href="{{ route('analyst.generateReport', ['type' => $type, 'format' => 'pdf']) }}" 
                           class="btn btn-danger">
                            PDF
                        </a>
                        <a href="{{ route('dashboard') }}" 
                           class="btn btn-secondary">
                            Назад
                        </a>
                    </div>
                </div>
                
                <div class="mb-6">
                    <p class="text-gray-600">Дата формирования: {{ $data['date'] ?? now()->format('d.m.Y H:i:s') }}</p>
                </div>
                
                @if(isset($data['statistics']))
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Статистика</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($data['statistics'] as $key => $value)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 mb-1">{{ $key }}</p>
                                    <p class="text-lg font-bold">{{ $value }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                @if($type === 'risk' && isset($data['clients']))
                    <h3 class="text-lg font-semibold mb-4">Клиенты</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Клиент</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Тип</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Кредитов</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Уровень риска</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Оценка</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($data['clients'] as $client)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $client->fullname }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs rounded 
                                                {{ $client->entity_type_id == 1 ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $client->entityType->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $client->credits->count() }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $bgColor = match($client->risk_level) {
                                                    'Низкий' => 'bg-green-100 text-green-800',
                                                    'Средний' => 'bg-yellow-100 text-yellow-800',
                                                    'Высокий' => 'bg-orange-100 text-orange-800',
                                                    default => 'bg-red-100 text-red-800',
                                                };
                                            @endphp
                                            <span class="px-2 py-1 text-xs rounded {{ $bgColor }}">
                                                {{ $client->risk_level }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $client->risk_score }}/100</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                
                @if($type === 'overdue' && isset($data['credits']))
                    <h3 class="text-lg font-semibold mb-4">Просроченные кредиты</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Клиент</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Кредит</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Сумма</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата окончания</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($data['credits'] as $credit)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $credit->client->fullname ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $credit->creditType->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ number_format($credit->amount, 2) }} ₽</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $credit->end_date->format('d.m.Y') }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>