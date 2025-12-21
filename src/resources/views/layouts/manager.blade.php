@php
    use App\Models\ClientsModel;
    use App\Models\CreditsModel;
    
    $stats = [
        'total_clients' => ClientsModel::count(),
        'active_credits' => CreditsModel::count(),
        'total_amount' => CreditsModel::sum('amount'),
        'avg_rate' => CreditsModel::avg('rate'),
    ];
    
    $recentClients = ClientsModel::with(['entityType'])
        ->orderBy('registration_date', 'desc')
        ->take(5)
        ->get();
@endphp

<div>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Панель управления</h2>
    
    <!-- Статистика -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-dashboard-card 
            title="Всего клиентов" 
            :value="$stats['total_clients']"
            icon="users"
            color="blue"
            :trend="['direction' => 'up', 'value' => 12]"
        />
        
        <x-dashboard-card 
            title="Активные кредиты" 
            :value="$stats['active_credits']"
            icon="credit"
            color="green"
        />
        
        <x-dashboard-card 
            title="Общая сумма" 
            :value="number_format($stats['total_amount'], 0, '.', ' ') . ' ₽'"
            icon="money"
            color="purple"
            :trend="['direction' => 'up', 'value' => 8]"
        />
        
        <x-dashboard-card 
            title="Средняя ставка" 
            :value="number_format($stats['avg_rate'], 2) . '%'"
            icon="percent"
            color="yellow"
        />
    </div>
    
    <!-- Последние клиенты -->
    <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Последние клиенты</h3>
                <a href="{{ route('manager.clients') }}" class="text-sm text-blue-600 hover:text-blue-900">
                    Все клиенты →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Клиент</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Тип</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата регистрации</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Кредиты</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentClients as $client)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-600 font-medium">{{ substr($client->fullname, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $client->fullname }}</div>
                                        <div class="text-sm text-gray-500">{{ $client->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $client->entity_type_id == 1 ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $client->entityType->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $client->registration_date->format('d.m.Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $client->credits->count() }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('manager.clients.show', $client->id) }}" class="text-blue-600 hover:text-blue-900">Подробнее</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Быстрые действия -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Быстрые действия</h3>
            <div class="space-y-3">
                <a href="{{ route('manager.applications') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Рассмотреть заявки</span>
                </a>
                
                <a href="{{ route('manager.credits') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Все кредиты</span>
                </a>
            </div>
        </div>
        
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Статистика сегодня</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Одобренные заявки</span>
                        <span class="text-sm font-medium text-gray-700">85%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Новые клиенты</span>
                        <span class="text-sm font-medium text-gray-700">12</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>