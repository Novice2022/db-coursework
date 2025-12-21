@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Управление пользователями</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            Создать пользователя
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ФИО</th>
                            <th>Email</th>
                            <th>Роль</th>
                            <th>Дата регистрации</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <x-role-badge :roleId="$user->role_id" />
                            </td>
                            <td>{{ $user->created_at ? $user->created_at->format('d.m.Y H:i') : 'N/A' }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" 
                                        onclick="editUser({{ $user->id }})">
                                    Редактировать
                                </button>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.delete', $user->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Вы уверены, что хотите удалить пользователя?')">
                                        Удалить
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($users, 'links'))
            <div class="mt-3">
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
                        <label class="form-label">ФИО</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Роль</label>
                        <select name="role_id" class="form-select" required>
                            <option value="1">Клиент</option>
                            <option value="2">Менеджер</option>
                            <option value="3">Аналитик</option>
                            <option value="4">Администратор</option>
                        </select>
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
@endsection