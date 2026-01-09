@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Панель аналитика</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stat-value">{{ number_format($stats['totalDebt'], 0, ',', ' ') }} ₽</div>
                <div class="stat-label">Общая задолженность</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-warning">
                    <i class="bi bi-clock"></i>
                </div>
                <div class="stat-value">{{ $stats['overdueCredits'] }}</div>
                <div class="stat-label">Просроченных кредитов</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-primary">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div class="stat-value">{{ number_format($stats['totalFines'], 0, ',', ' ') }} ₽</div>
                <div class="stat-label">Неоплаченные штрафы</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-success">
                    <i class="bi bi-percent"></i>
                </div>
                <div class="stat-value">{{ number_format($stats['avgRate'], 2) }}%</div>
                <div class="stat-label">Средняя ставка</div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Распределение по уровню риска</h5>
                </div>
                <div class="card-body">
                    @if($riskDistribution->isEmpty())
                        <p class="text-center text-muted">Нет данных для анализа</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Уровень риска</th>
                                        <th>Количество кредитов</th>
                                        <th>Общая сумма</th>
                                        <th>Доля в портфеле</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalCount = $riskDistribution->sum('count');
                                    @endphp
                                    @foreach($riskDistribution as $risk)
                                        <tr>
                                            <td>
                                                @if($risk->risk_level == 'Просрочен')
                                                    <span class="badge badge-danger">{{ $risk->risk_level }}</span>
                                                @elseif($risk->risk_level == 'Высокий риск')
                                                    <span class="badge badge-warning">{{ $risk->risk_level }}</span>
                                                @elseif($risk->risk_level == 'Средний риск')
                                                    <span class="badge badge-info">{{ $risk->risk_level }}</span>
                                                @else
                                                    <span class="badge badge-success">{{ $risk->risk_level }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $risk->count }}</td>
                                            <td>{{ number_format($risk->total_amount, 0, ',', ' ') }} ₽</td>
                                            <td>
                                                @php
                                                    $percentage = $totalCount > 0 ? ($risk->count / $totalCount * 100) : 0;
                                                @endphp
                                                {{ number_format($percentage, 1) }}%
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
                    <h5 class="mb-0">Инструменты аналитика</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('analyst.risk.index') }}" class="btn btn-danger">
                            <i class="bi bi-shield-exclamation me-2"></i> Анализ рисков
                        </a>
                        <a href="{{ route('analyst.reports.index') }}" class="btn btn-success">
                            <i class="bi bi-file-earmark-bar-graph me-2"></i> Финансовая аналитика
                        </a>
                        <a href="{{ route('analyst.export') }}" class="btn btn-primary">
                            <i class="bi bi-download me-2"></i> Экспорт данных
                        </a>
                        <a href="{{ route('analyst.export.credits') }}" class="btn btn-outline-primary">
                            <i class="bi bi-file-earmark-arrow-down me-2"></i> Скачать кредиты (CSV)
                        </a>
                        <a href="{{ route('analyst.export.payments') }}" class="btn btn-outline-success">
                            <i class="bi bi-file-earmark-arrow-down me-2"></i> Скачать платежи (CSV)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection