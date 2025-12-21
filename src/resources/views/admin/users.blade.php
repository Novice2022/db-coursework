<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Управление пользователями</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    Создать пользователя
                </button>
            </div>
            
            <!-- Фильтры -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <div class="flex flex-wrap gap-4">
                    <div>
                        <select id="roleFilter" class="form-select" onchange="filterUsers()">
                            <option value="">Все роли</option>
                            <option value="1">Клиенты</option>
                            <option value="2">Менеджеры</option>
                            <option value="3">Аналитики</option>
                            <option value="4">Администраторы</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <input type="text" id="searchInput" class="form-control" placeholder="Поиск по имени или email..." 
                               onkeyup="filterUsers()">
                    </div>
                </div>
            </div>
            
            <!-- Таблица пользователей -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Пользователь</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Роль</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата регистрации</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-600 font-medium">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                @if($user->client)
                                                    <div class="text-sm text-gray-500">{{ $user->client->phone }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-role-badge :roleId="$user->role_id" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $user->created_at->format('d.m.Y H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button type="button" class="text-blue-600 hover:text-blue-900 mr-3" 
                                                onclick="editUser({{ json_encode($user) }})">
                                            Редактировать
                                        </button>
                                        @if($user->id !== auth()->id())
                                            <button type="button" class="text-red-600 hover:text-red-900"
                                                    onclick="deleteUser({{ $user->id }})">
                                                Удалить
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Модальное окно создания пользователя -->
    <div class="modal fade" id="createUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Создание пользователя</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.users.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">ФИО</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="role_id" class="form-label">Роль</label>
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="1">Клиент</option>
                                <option value="2">Менеджер</option>
                                <option value="3">Аналитик</option>
                                <option value="4">Администратор</option>
                            </select>
                        </div>
                        <div id="clientFields" style="display: none;">
                            <div class="mb-3">
                                <label for="client_phone" class="form-label">Телефон</label>
                                <input type="text" class="form-control" id="client_phone" name="client_phone">
                            </div>
                            <div class="mb-3">
                                <label for="client_address" class="form-label">Адрес</label>
                                <input type="text" class="form-control" id="client_address" name="client_address">
                            </div>
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
    
    <!-- Модальное окно редактирования пользователя -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирование пользователя</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">ФИО</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">Новый пароль (оставьте пустым, если не меняете)</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="edit_role_id" class="form-label">Роль</label>
                            <select class="form-select" id="edit_role_id" name="role_id" required>
                                <option value="1">Клиент</option>
                                <option value="2">Менеджер</option>
                                <option value="3">Аналитик</option>
                                <option value="4">Администратор</option>
                            </select>
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
        function filterUsers() {
            const role = document.getElementById('roleFilter').value;
            const search = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const roleCell = row.querySelector('td:nth-child(2)');
                const nameCell = row.querySelector('td:nth-child(1)');
                const emailCell = row.querySelector('td:nth-child(3)');
                
                const roleText = roleCell.textContent;
                const nameText = nameCell.textContent.toLowerCase();
                const emailText = emailCell.textContent.toLowerCase();
                
                let show = true;
                
                if (role && !roleText.includes(role === '1' ? 'Клиент' : 
                                               role === '2' ? 'Менеджер' : 
                                               role === '3' ? 'Аналитик' : 'Администратор')) {
                    show = false;
                }
                
                if (search && !nameText.includes(search) && !emailText.includes(search)) {
                    show = false;
                }
                
                row.style.display = show ? '' : 'none';
            });
        }
        
        function editUser(user) {
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_role_id').value = user.role_id;
            document.getElementById('editUserForm').action = `/admin/users/${user.id}`;
            
            const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            modal.show();
        }
        
        function deleteUser(userId) {
            if (confirm('Вы уверены, что хотите удалить пользователя?')) {
                fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Ошибка при удалении пользователя');
                    }
                });
            }
        }
        
        // Показываем/скрываем поля клиента при выборе роли
        document.getElementById('role_id').addEventListener('change', function() {
            const clientFields = document.getElementById('clientFields');
            clientFields.style.display = this.value === '1' ? 'block' : 'none';
        });
    </script>
</x-app-layout>