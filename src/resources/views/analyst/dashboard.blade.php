<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6">Панель аналитика</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Статистика -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Статистика рисков</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-gray-600">Клиентов с высоким риском:</p>
                            <p class="text-2xl font-bold text-red-600">{{ $stats['total_risky_clients'] ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Просроченных кредитов:</p>
                            <p class="text-2xl font-bold text-orange-600">{{ $stats['overdue_credits'] ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Средний риск:</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $stats['average_risk_score'] ?? 0 }}/100</p>
                        </div>
                    </div>
                </div>
                
                <!-- Быстрые ссылки -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Быстрые действия</h3>
                    <div class="space-y-3">
                        <a href="{{ route('analyst.risk-assessment') }}" class="block p-3 border rounded-lg hover:bg-gray-50">
                            Оценка рисков клиентов
                        </a>
                        <a href="{{ route('analyst.overdue-credits') }}" class="block p-3 border rounded-lg hover:bg-gray-50">
                            Просроченные кредиты
                        </a>
                        <a href="{{ route('analyst.reports') }}" class="block p-3 border rounded-lg hover:bg-gray-50">
                            Генерация отчетов
                        </a>
                    </div>
                </div>
                
                <!-- Последние отчеты -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Последние отчеты</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-gray-50 rounded">
                            <p class="font-medium">Отчет по рискам</p>
                            <p class="text-sm text-gray-500">Сегодня, 14:30</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded">
                            <p class="font-medium">Анализ просрочек</p>
                            <p class="text-sm text-gray-500">Вчера, 11:15</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>