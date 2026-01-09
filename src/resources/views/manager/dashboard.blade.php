@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Панель менеджера</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-primary">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-value">{{ $stats['totalClients'] }}</div>
                <div class="stat-label">Всего клиентов</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-success">
                    <i class="bi bi-credit-card"></i>
                </div>
                <div class="stat-value">{{ $stats['totalCredits'] }}</div>
                <div class="stat-label">Всего кредитов</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-warning">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="stat-value">{{ number_format($stats['totalAmount'], 0, ',', ' ') }} ₽</div>
                <div class="stat-label">Общая сумма кредитов</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-info">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-value">{{ $stats['activeCredits'] }}</div>
                <div class="stat-label">Активных кредитов</div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Последние кредиты</h5>
                    <a href="{{ route('manager.credits.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Новый кредит
                    </a>
                </div>
                <div class="card-body">
                    @if($recentCredits->isEmpty())
                        <p class="text-center text-muted">Нет данных о кредитах</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Клиент</th>
                                        <th>Сумма</th>
                                        <th>Ставка</th>
                                        <th>Срок</th>
                                        <th>Дата выдачи</th>
                                        <th>Статус</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentCredits as $credit)
                                        <tr>
                                            <td>{{ $credit->client->fullname }}</td>
                                            <td>{{ number_format($credit->amount, 0, ',', ' ') }} ₽</td>
                                            <td>{{ $credit->rate }}%</td>
                                            <td>{{ $credit->term }} мес</td>
                                            <td>{{ $credit->start_date->format('d.m.Y') }}</td>
                                            <td>
                                                @if($credit->end_date && $credit->end_date < now())
                                                    <span class="badge badge-success">Погашен</span>
                                                @elseif($credit->end_date && $credit->end_date > now())
                                                    <span class="badge badge-primary">Активен</span>
                                                @else
                                                    <span class="badge badge-secondary">Не определен</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('manager.credits.show', $credit->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
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
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Быстрые действия</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('manager.clients.index') }}" class="btn btn-primary">
                            <i class="bi bi-people me-2"></i> Управление клиентами
                        </a>
                        <a href="{{ route('manager.credits.index') }}" class="btn btn-success">
                            <i class="bi bi-credit-card me-2"></i> Все кредиты
                        </a>
                        <a href="{{ route('manager.credits.create') }}" class="btn btn-warning">
                            <i class="bi bi-plus-circle me-2"></i> Выдать кредит
                        </a>
                        <a href="{{ route('manager.reports.index') }}" class="btn btn-info">
                            <i class="bi bi-file-earmark-text me-2"></i> Отчеты
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection