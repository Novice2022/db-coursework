<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6">Отчеты системы</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Отчет по пользователям -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 8.75v-1.5a.75.75 0 00-.75-.75h-1.5a.75.75 0 00-.75.75v1.5a.75.75 0 00.75.75h1.5a.75.75 0 00.75-.75z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Отчет по пользователям</h3>
                            <p class="text-sm text-gray-600">Статистика по всем пользователям системы</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('reports.generate', ['type' => 'clients', 'format' => 'pdf']) }}" 
                           class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                            <span>PDF версия</span>
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('reports.generate', ['type' => 'clients', 'format' => 'excel']) }}" 
                           class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                            <span>Excel версия</span>
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Отчет по кредитам -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Отчет по кредитам</h3>
                            <p class="text-sm text-gray-600">Информация о всех кредитах в системе</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('reports.generate', ['type' => 'credits', 'format' => 'pdf']) }}" 
                           class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                            <span>PDF версия</span>
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('reports.generate', ['type' => 'credits', 'format' => 'excel']) }}" 
                           class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                            <span>Excel версия</span>
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Финансовый отчет -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-purple-100 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Финансовый отчет</h3>
                            <p class="text-sm text-gray-600">Финансовая статистика за текущий год</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('reports.generate', ['type' => 'financial', 'format' => 'pdf']) }}" 
                           class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                            <span>PDF версия</span>
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('reports.generate', ['type' => 'financial', 'format' => 'excel']) }}" 
                           class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                            <span>Excel версия</span>
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Отчет по штрафам -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-100 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Отчет по штрафам</h3>
                            <p class="text-sm text-gray-600">Информация о всех штрафах в системе</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('reports.generate', ['type' => 'fines', 'format' => 'pdf']) }}" 
                           class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                            <span>PDF версия</span>
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Отчет по рискам -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-yellow-100 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Отчет по рискам</h3>
                            <p class="text-sm text-gray-600">Анализ рисков по клиентам</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('analyst.generateReport', ['type' => 'risk', 'format' => 'pdf']) }}" 
                           class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                            <span>PDF версия</span>
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Аудит системы -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-gray-100 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Аудит системы</h3>
                            <p class="text-sm text-gray-600">Логи действий пользователей</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <button type="button" class="w-full flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                            <span>Сгенерировать отчет</span>
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Статистика -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Статистика отчетов</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-gray-600 mb-1">Всего сгенерировано отчетов</p>
                        <p class="text-2xl font-bold">--</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Отчетов за месяц</p>
                        <p class="text-2xl font-bold">--</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Средний размер отчета</p>
                        <p class="text-2xl font-bold">-- MB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>