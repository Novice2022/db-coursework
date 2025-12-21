<div class="client-dashboard">
    <h2 class="text-2xl font-bold mb-6">Мой кабинет</h2>
    
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Информация о клиенте -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Информация о клиенте</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600">ФИО:</p>
                <p class="font-medium">{{ $client->fullname ?? auth()->user()->name }}</p>
            </div>
            <div>
                <p class="text-gray-600">Телефон:</p>
                <p class="font-medium">{{ $client->phone ?? 'Не указан' }}</p>
            </div>
            <div>
                <p class="text-gray-600">Email:</p>
                <p class="font-medium">{{ auth()->user()->email }}</p>
            </div>
            <div>
                <p class="text-gray-600">Тип клиента:</p>
                <p class="font-medium">{{ $client->entityType->name ?? 'Не указан' }}</p>
            </div>
        </div>
    </div>
    
    <!-- Мои кредиты -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Мои кредиты</h3>
            <a href="{{ route('client.credits.create') }}" class="btn btn-primary">
                Оформить кредит
            </a>
        </div>
        
        @if($credits->isEmpty())
            <div class="text-center py-8 text-gray-500">
                <p>У вас пока нет кредитов</p>
                <a href="{{ route('client.credits.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                    Оформить первый кредит
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Название</th>
                            <th class="text-left py-2">Сумма</th>
                            <th class="text-left py-2">Ставка</th>
                            <th class="text-left py-2">Срок</th>
                            <th class="text-left py-2">Дата начала</th>
                            <th class="text-left py-2">Статус</th>
                            <th class="text-left py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($credits as $credit)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3">{{ $credit->creditType->name ?? 'Не указано' }}</td>
                                <td class="py-3">{{ number_format($credit->amount, 2) }} ₽</td>
                                <td class="py-3">{{ $credit->rate }}%</td>
                                <td class="py-3">{{ $credit->term }} мес.</td>
                                <td class="py-3">
                                    @if($credit->start_date instanceof \Carbon\Carbon)
                                        {{ $credit->start_date->format('d.m.Y') }}
                                    @else
                                        {{ \Illuminate\Support\Carbon::parse($credit->start_date)->format('d.m.Y') }}
                                    @endif
                                </td>
                                <td class="py-3">
                                    @php
                                        $endDate = $credit->end_date;
                                        if (!($endDate instanceof \Carbon\Carbon) && $endDate) {
                                            $endDate = \Illuminate\Support\Carbon::parse($endDate);
                                        }
                                    @endphp
                                    
                                    @if($endDate && $endDate->isPast())
                                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">
                                            Завершен
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">
                                            Активен
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <a href="{{ route('client.credits.show', $credit->id) }}" class="text-blue-600 hover:underline">
                                        Подробнее
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>