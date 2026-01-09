@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Управление пользователями</h1>
        <button class="btn btn-primary">
            <i class="bi bi-person-plus me-2"></i> Добавить пользователя
        </button>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Список пользователей</h5>
        </div>
        <div class="card-body">
            @if($users->isEmpty())
                <p class="text-center text-muted">Нет пользователей</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Роль</th>
                                <th>Клиент</th>
                                <th>Дата регистрации</th>
                                <th>Статус</th>
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
                                        @if($user->role_id == 1)
                                            <span class="badge badge-primary">Клиент</span>
                                        @elseif($user->role_id == 2)
                                            <span class="badge badge-success">Менеджер</span>
                                        @elseif($user->role_id == 3)
                                            <span class="badge badge-warning">Аналитик</span>
                                        @elseif($user->role_id == 4)
                                            <span class="badge badge-danger">Администратор</span>
                                        @else
                                            <span class="badge badge-secondary">Неизвестно</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->client)
                                            {{ $user->client->fullname }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge badge-success">Активен</span>
                                        @else
                                            <span class="badge badge-warning">Не подтвержден</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection