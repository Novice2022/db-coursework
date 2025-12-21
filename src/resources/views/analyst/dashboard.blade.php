@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Панель аналитика</h1>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger text-white rounded p-3">
                                <i class="bi bi-exclamation-triangle fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Клиентов с высоким риском</h6>
                            <p class="card-text fs-4 mb-0">{{ $stats['total_risky_clients'] ?? 0 }}</p>
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
                            <div class="bg-warning text-white rounded p-3">
                                <i class="bi bi-clock-history fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Просроченных кредитов</h6>
                            <p class="card-text fs-4 mb-0">{{ $stats['overdue_credits'] ?? 0 }}</p>
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
                            <div class="bg-primary text-white rounded p-3">
                                <i class="bi bi-cash-stack fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Всего кредитов</h6>
                            <p class="card-text fs-4 mb-0">{{ $stats['total_credits'] ?? 0 }}</p>
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
                                <i class="bi bi-currency-dollar fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Сумма штрафов</h6>
                            <p class="card-text fs-4 mb-0">{{ number_format($stats['total_fines'] ?? 0, 0) }} ₽</p>
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
                    <h5 class="mb-0">Быстрые действия</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('analyst.risk-assessment') }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-shield-check text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>Оценка рисков клиентов</strong>
                                    <p class="mb-0 small text-muted">Анализ кредитоспособности клиентов</p>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('analyst.overdue-credits') }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-exclamation-triangle text-warning"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>Просроченные кредиты</strong>
                                    <p class="mb-0 small text-muted">Мониторинг просроченных платежей</p>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('analyst.reports') }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-file-earmark-text text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>Генерация отчетов</strong>
                                    <p class="mb-0 small text-muted">Создание аналитических отчетов</p>
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
                    <h5 class="mb-0">Рекомендации</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="bi bi-lightbulb fs-4"></i>
                            </div>
                            <div>
                                <h6>Рекомендации по снижению рисков</h6>
                                <p class="mb-0 small">Проверьте клиентов с высокой кредитной нагрузкой</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="bi bi-graph-up fs-4"></i>
                            </div>
                            <div>
                                <h6>Тенденции кредитования</h6>
                                <p class="mb-0 small">Наблюдается рост выдачи кредитов на 15%</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-success">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="bi bi-check-circle fs-4"></i>
                            </div>
                            <div>
                                <h6>Уровень просрочек</h6>
                                <p class="mb-0 small">Уровень просроченных кредитов снизился на 3%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection