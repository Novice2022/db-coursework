@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Панель администратора</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-primary">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-value">{{ $stats['totalUsers'] }}</div>
                <div class="stat-label">Всего пользователей</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-value">{{ $stats['activeUsers'] }}</div>
                <div class="stat-label">Активных пользователей</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-warning">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div class="stat-value">{{ $stats['totalClients'] }}</div>
                <div class="stat-label">Клиентов в системе</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-info">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="stat-value">{{ count($stats['roles']) }}</div>
                <div class="stat-label">Ролей в системе</div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Статистика по ролям</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Роль</th>
                                    <th>Количество пользователей</th>
                                    <th>Описание</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['roles'] as $role)
                                    <tr>
                                        <td>
                                            @if($role->id == 1)
                                                <span class="badge badge-primary">Клиент</span>
                                            @elseif($role->id == 2)
                                                <span class="badge badge-success">Менеджер</span>
                                            @elseif($role->id == 3)
                                                <span class="badge badge-warning">Аналитик</span>
                                            @elseif($role->id == 4)
                                                <span class="badge badge-danger">Администратор</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $role->name }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $roleCounts[$role->id] ?? 0 }}</td>
                                        <td>
                                            @if($role->id == 1)
                                                Физические и юридические лица, получающие кредиты
                                            @elseif($role->id == 2)
                                                Сотрудники банка, управляющие кредитами и клиентами
                                            @elseif($role->id == 3)
                                                Специалисты по анализу рисков и финансовой отчетности
                                            @elseif($role->id == 4)
                                                Администраторы системы с полными правами доступа
                                            @else
                                                {{ $role->name }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Последние зарегистрированные пользователи</h5>
                </div>
                <div class="card-body">
                    @if($recentUsers->isEmpty())
                        <p class="text-center text-muted">Нет пользователей</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Имя</th>
                                        <th>Email</th>
                                        <th>Роль</th>
                                        <th>Дата регистрации</th>
                                        <th>Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentUsers as $user)
                                        <tr>
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
                                            <td>{{ $user->created_at }}</td>
                                            <td>
                                                @if($user->email_verified_at)
                                                    <span class="badge badge-success">Подтвержден</span>
                                                @else
                                                    <span class="badge badge-warning">Не подтвержден</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Быстрые действия</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                            <i class="bi bi-people-fill me-2"></i> Управление пользователями
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-success">
                            <i class="bi bi-gear me-2"></i> Настройки системы
                        </a>
                        <a href="{{ route('admin.audit.index') }}" class="btn btn-warning">
                            <i class="bi bi-clock-history me-2"></i> История действий
                        </a>
                        <button class="btn btn-info">
                            <i class="bi bi-database me-2"></i> Резервное копирование
                        </button>
                        <button class="btn btn-danger">
                            <i class="bi bi-shield-lock me-2"></i> Безопасность
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Системная информация</h5>
                </div>
                <div class="card-body">
                    <p><strong>Версия системы:</strong> 1.0.0</p>
                    <p><strong>Последнее обновление:</strong> {{ now()->format('d.m.Y') }}</p>
                    <p><strong>Всего таблиц в БД:</strong> 14</p>
                    <p><strong>Размер базы данных:</strong> ~15 MB</p>
                    
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Статус системы:</strong> Работает стабильно
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection