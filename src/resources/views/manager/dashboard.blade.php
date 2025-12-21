@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Панель управления менеджера</h1>
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
                            <h6 class="card-title mb-1">Клиентов</h6>
                            <p class="card-text fs-4 mb-0">{{ \App\Models\ClientsModel::count() }}</p>
                            <small class="text-muted">
                                @php
                                    $newClientsToday = \App\Models\ClientsModel::whereDate('registration_date', today())->count();
                                @endphp
                                {{ $newClientsToday }} новых сегодня
                            </small>
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
                                <i class="bi bi-cash-coin fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Активных кредитов</h6>
                            @php
                                $activeCredits = \App\Models\CreditsModel::where(function($query) {
                                    $query->whereNull('end_date')
                                        ->orWhere('end_date', '>', now());
                                })->count();
                                $totalAmount = \App\Models\CreditsModel::sum('amount');
                            @endphp
                            <p class="card-text fs-4 mb-0">{{ $activeCredits }}</p>
                            <small class="text-muted">Общая сумма: {{ number_format($totalAmount, 0) }} ₽</small>
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
                                <i class="bi bi-percent fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Средняя ставка</h6>
                            @php
                                $avgRate = \App\Models\CreditsModel::avg('rate');
                            @endphp
                            <p class="card-text fs-4 mb-0">{{ number_format($avgRate ?? 0, 2) }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Последние клиенты</h5>
                    <a href="{{ route('manager.clients') }}" class="btn btn-sm btn-outline-primary">
                        Все клиенты
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $recentClients = \App\Models\ClientsModel::with('entityType')
                            ->orderBy('registration_date', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    
                    @if($recentClients->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentClients as $client)
                                <a href="{{ route('manager.clients.show', $client->id) }}" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $client->fullname }}</strong>
                                            <div class="text-muted small">{{ $client->phone }}</div>
                                        </div>
                                        <span class="badge bg-primary">
                                            {{ $client->entityType->name ?? 'N/A' }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <p class="text-muted mb-0">Нет клиентов</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Последние кредиты</h5>
                    <a href="{{ route('manager.credits') }}" class="btn btn-sm btn-outline-primary">
                        Все кредиты
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $recentCredits = \App\Models\CreditsModel::with(['client', 'creditType'])
                            ->orderBy('start_date', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    
                    @if($recentCredits->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentCredits as $credit)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $credit->creditType->name ?? 'N/A' }}</strong>
                                            <div class="text-muted small">
                                                {{ $credit->client->fullname ?? 'N/A' }}
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div>{{ number_format($credit->amount, 0) }} ₽</div>
                                            <div class="text-muted small">{{ $credit->rate }}%</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <p class="text-muted mb-0">Нет кредитов</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection