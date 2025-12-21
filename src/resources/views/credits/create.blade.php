<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Оформление кредита</h2>
            
            <form action="{{ route('client.credits.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="credit_type_id" class="block text-gray-700 mb-2">Тип кредита</label>
                    <select name="credit_type_id" id="credit_type_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">Выберите тип кредита</option>
                        @foreach($creditTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 mb-2">Сумма кредита (руб.)</label>
                    <input type="number" name="amount" id="amount" 
                           class="w-full border rounded px-3 py-2" 
                           min="1000" step="1000" required>
                </div>
                
                <div class="mb-4">
                    <label for="term" class="block text-gray-700 mb-2">Срок кредита (месяцев)</label>
                    <input type="number" name="term" id="term" 
                           class="w-full border rounded px-3 py-2" 
                           min="1" max="360" required>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('client.dashboard') }}" class="btn btn-secondary">
                        Отмена
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Подать заявку
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>