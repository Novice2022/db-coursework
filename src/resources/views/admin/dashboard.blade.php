@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Панель администратора</h1>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded p-3">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Всего пользователей</h6>
                            <p class="card-text fs-4 mb-0">{{ \App\Models\User::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success text-white rounded p-3">
                                <i class="bi bi-person-check fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Клиентов</h6>
                            <p class="card-text fs-4 mb-0">{{ \App\Models\User::where('role_id', 1)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info text-white rounded p-3">
                                <i class="bi bi-person-badge fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Менеджеров</h6>
                            <p class="card-text fs-4 mb-0">{{ \App\Models\User::where('role_id', 2)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger text-white rounded p-3">
                                <i class="bi bi-shield-check fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Администраторов</h6>
                            <p class="card-text fs-4 mb-0">{{ \App\Models\User::where('role_id', 4)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Управление системой</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.users') }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-people text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>Управление пользователями</strong>
                                    <p class="mb-0 small text-muted">Создание, редактирование, удаление пользователей</p>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('admin.credit-types') }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-cash-coin text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>Типы кредитов</strong>
                                    <p class="mb-0 small text-muted">Настройка типов кредитных продуктов</p>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('admin.entity-types') }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-building text-info"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>Типы организаций</strong>
                                    <p class="mb-0 small text-muted">Настройка типов клиентов</p>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('admin.settings') }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-gear text-warning"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>Настройки системы</strong>
                                    <p class="mb-0 small text-muted">Общие настройки приложения</p>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Отчеты</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.reports') }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-file-earmark-text text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>Финансовые отчеты</strong>
                                    <p class="mb-0 small text-muted">Отчеты по финансовой деятельности</p>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('reports.generate', ['type' => 'clients']) }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-people-fill text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>Отчет по клиентам</strong>
                                    <p class="mb-0 small text-muted">Статистика по клиентской базе</p>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('reports.generate', ['type' => 'credits']) }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-cash-stack text-info"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>Отчет по кредитам</strong>
                                    <p class="mb-0 small text-muted">Анализ кредитного портфеля</p>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection