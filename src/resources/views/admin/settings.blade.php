<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6">Настройки системы</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Информация о системе -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Информация о системе</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Название приложения:</span>
                            <span class="font-medium">{{ $settings['app_name'] }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Окружение:</span>
                            <span class="font-medium">
                                <span class="px-2 py-1 text-xs rounded {{ $settings['app_env'] === 'production' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $settings['app_env'] }}
                                </span>
                            </span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Режим отладки:</span>
                            <span class="font-medium">
                                <span class="px-2 py-1 text-xs rounded {{ $settings['app_debug'] ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $settings['app_debug'] ? 'Включен' : 'Выключен' }}
                                </span>
                            </span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">База данных:</span>
                            <span class="font-medium">{{ $settings['db_connection'] }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Почтовый драйвер:</span>
                            <span class="font-medium">{{ $settings['mail_driver'] }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Кэш драйвер:</span>
                            <span class="font-medium">{{ $settings['cache_driver'] }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Быстрые действия -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Быстрые действия</h3>
                    <div class="space-y-3">
                        <a href="{{ route('cache.clear') }}" class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Очистить кэш</span>
                        </a>
                        <a href="{{ route('route.cache') }}" class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span>Кэшировать маршруты</span>
                        </a>
                        <a href="{{ route('view.cache') }}" class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Кэшировать представления</span>
                        </a>
                        <a href="{{ route('config.cache') }}" class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                            <span>Кэшировать конфигурацию</span>
                        </a>
                    </div>
                </div>
                
                <!-- Резервное копирование -->
                <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
                    <h3 class="text-lg font-semibold mb-4">Резервное копирование</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="font-medium">База данных</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Создать резервную копию базы данных</p>
                            <button type="button" class="btn btn-sm btn-primary">Создать бэкап</button>
                        </div>
                        
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span class="font-medium">Файлы</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Резервное копирование загруженных файлов</p>
                            <button type="button" class="btn btn-sm btn-success">Архивировать файлы</button>
                        </div>
                        
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                <span class="font-medium">Восстановление</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Восстановить из резервной копии</p>
                            <button type="button" class="btn btn-sm btn-purple">Восстановить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>