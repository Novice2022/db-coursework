<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Типы кредитов</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCreditTypeModal">
                    Создать тип кредита
                </button>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Тип организации</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Описание</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Базовая ставка</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($creditTypes as $type)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $type->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $type->entityType->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ Str::limit($type->description, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $type->base_rate ?? 'N/A' }}%</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button type="button" class="text-blue-600 hover:text-blue-900 mr-3" 
                                                onclick="editCreditType({{ json_encode($type) }})">
                                            Редактировать
                                        </button>
                                        <button type="button" class="text-red-600 hover:text-red-900"
                                                onclick="deleteCreditType({{ $type->id }})">
                                            Удалить
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Модальное окно создания типа кредита -->
    <div class="modal fade" id="createCreditTypeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Создание типа кредита</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.credit-types.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Название</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="entity_type_id" class="form-label">Тип организации</label>
                            <select class="form-select" id="entity_type_id" name="entity_type_id" required>
                                @foreach($entityTypes ?? [] as $entityType)
                                    <option value="{{ $entityType->id }}">{{ $entityType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="min_amount" class="form-label">Минимальная сумма</label>
                                <input type="number" class="form-control" id="min_amount" name="min_amount" step="0.01">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="max_amount" class="form-label">Максимальная сумма</label>
                                <input type="number" class="form-control" id="max_amount" name="max_amount" step="0.01">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="min_term" class="form-label">Минимальный срок (мес.)</label>
                                <input type="number" class="form-control" id="min_term" name="min_term">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="max_term" class="form-label">Максимальный срок (мес.)</label>
                                <input type="number" class="form-control" id="max_term" name="max_term">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="base_rate" class="form-label">Базовая ставка (%)</label>
                            <input type="number" class="form-control" id="base_rate" name="base_rate" step="0.01">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Модальное окно редактирования типа кредита -->
    <div class="modal fade" id="editCreditTypeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирование типа кредита</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editCreditTypeForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Название</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_entity_type_id" class="form-label">Тип организации</label>
                            <select class="form-select" id="edit_entity_type_id" name="entity_type_id" required>
                                @foreach($entityTypes ?? [] as $entityType)
                                    <option value="{{ $entityType->id }}">{{ $entityType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Описание</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_min_amount" class="form-label">Минимальная сумма</label>
                                <input type="number" class="form-control" id="edit_min_amount" name="min_amount" step="0.01">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_max_amount" class="form-label">Максимальная сумма</label>
                                <input type="number" class="form-control" id="edit_max_amount" name="max_amount" step="0.01">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_min_term" class="form-label">Минимальный срок (мес.)</label>
                                <input type="number" class="form-control" id="edit_min_term" name="min_term">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_max_term" class="form-label">Максимальный срок (мес.)</label>
                                <input type="number" class="form-control" id="edit_max_term" name="max_term">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_base_rate" class="form-label">Базовая ставка (%)</label>
                            <input type="number" class="form-control" id="edit_base_rate" name="base_rate" step="0.01">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function editCreditType(type) {
            document.getElementById('edit_name').value = type.name;
            document.getElementById('edit_entity_type_id').value = type.entity_type_id;
            document.getElementById('edit_description').value = type.description || '';
            document.getElementById('edit_min_amount').value = type.min_amount || '';
            document.getElementById('edit_max_amount').value = type.max_amount || '';
            document.getElementById('edit_min_term').value = type.min_term || '';
            document.getElementById('edit_max_term').value = type.max_term || '';
            document.getElementById('edit_base_rate').value = type.base_rate || '';
            document.getElementById('editCreditTypeForm').action = `/admin/credit-types/${type.id}`;
            
            const modal = new bootstrap.Modal(document.getElementById('editCreditTypeModal'));
            modal.show();
        }
        
        function deleteCreditType(typeId) {
            if (confirm('Вы уверены, что хотите удалить этот тип кредита?')) {
                fetch(`/admin/credit-types/${typeId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        response.json().then(data => {
                            alert(data.error || 'Ошибка при удалении типа кредита');
                        });
                    }
                });
            }
        }
    </script>
</x-app-layout>