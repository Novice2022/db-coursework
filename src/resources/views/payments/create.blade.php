<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-6">Внесение платежа</h2>
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Информация о кредите</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Тип кредита:</p>
                            <p class="font-medium">{{ $credit->creditType->name ?? 'Не указано' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Сумма кредита:</p>
                            <p class="font-medium">{{ number_format($credit->amount, 2) }} ₽</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Ставка:</p>
                            <p class="font-medium">{{ $credit->rate }}%</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Осталось выплатить:</p>
                            <p class="font-medium">
                                @php
                                    $paid = $credit->payments->sum('amount');
                                    $remaining = $credit->amount - $paid;
                                @endphp
                                {{ number_format($remaining, 2) }} ₽
                            </p>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('credits.payments.store', $credit->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 mb-2">Сумма платежа (₽)</label>
                        <input type="number" 
                               name="amount" 
                               id="amount" 
                               class="w-full border rounded px-3 py-2"
                               min="0.01"
                               step="0.01"
                               max="{{ $remaining }}"
                               value="{{ min(10000, $remaining) }}"
                               required>
                        <p class="text-sm text-gray-500 mt-1">
                            Максимальная сумма: {{ number_format($remaining, 2) }} ₽
                        </p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="datetime" class="block text-gray-700 mb-2">Дата платежа</label>
                        <input type="datetime-local" 
                               name="datetime" 
                               id="datetime" 
                               class="w-full border rounded px-3 py-2"
                               value="{{ now()->format('Y-m-d\TH:i') }}"
                               required>
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('credits.show', $credit->id) }}" class="btn btn-secondary">
                            Отмена
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Внести платеж
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>