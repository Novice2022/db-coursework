@php
    use App\Models\User;
    use App\Models\ClientsModel;
    use App\Models\CreditsModel;
    
    $stats = [
        'total_users' => User::count(),
        'active_clients' => User::clients()->count(),
        'managers' => User::managers()->count(),
        'admins' => User::admins()->count(),
    ];
    
    $systemInfo = [
        'laravel_version' => app()->version(),
        'php_version' => phpversion(),
        'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Неизвестно',
        'db_connection' => config('database.default'),
    ];
@endphp

<div>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Административная панель</h2>
    
    <!-- Статистика пользователей -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-dashboard-card 
            title="Все пользователи" 
            :value="$stats['total_users']"
            icon="users"
            color="blue"
        />
        
        <x-dashboard-card 
            title="Клиенты" 
            :value="$stats['active_clients']"
            icon="user-group"
            color="green"
        />
        
        <x-dashboard-card 
            title="Менеджеры" 
            :value="$stats['managers']"
            icon="briefcase"
            color="purple"
        />
        
        <x-dashboard-card 
            title="Администраторы" 
            :value="$stats['admins']"
            icon="shield-check"
            color="red"
        />
    </div>
    
    <!-- Информация о системе -->
    <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Информация о системе</h3>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Версия Laravel</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['laravel_version'] }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Версия PHP</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['php_version'] }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Сервер</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['server'] }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">База данных</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['db_connection'] }}</dd>
                </div>
            </dl>
        </div>
    </div>
    
    <!-- Управление -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Управление пользователями</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.users') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 8.75v-1.5a.75.75 0 00-.75-.75h-1.5a.75.75 0 00-.75.75v1.5a.75.75 0 00.75.75h1.5a.75.75 0 00.75-.75z"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Все пользователи</span>
                </a>
                
                <a href="{{ route('admin.users') }}?role=1" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Клиенты</span>
                </a>
            </div>
        </div>
        
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Настройки системы</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.credit-types') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="bg-purple-100 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Типы кредитов</span>
                </a>
                
                <a href="{{ route('admin.settings') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Настройки</span>
                </a>
            </div>
        </div>
        
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Отчеты</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.reports') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="bg-red-100 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Финансовые отчеты</span>
                </a>
                
                <a href="{{ route('admin.reports') }}?type=audit" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="bg-gray-100 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Аудит системы</span>
                </a>
            </div>
        </div>
    </div>
</div>