@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Мой кабинет</h1>
        @if($client && $client->entity_type_id)
        <a href="{{ route('client.credits.create') }}" class="btn btn-primary">
            Оформить кредит
        </a>
        @endif
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded p-3">
                                <i class="bi bi-person fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Информация</h6>
                            <p class="card-text mb-0">{{ $client->fullname ?? auth()->user()->name }}</p>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success text-white rounded p-3">
                                <i class="bi bi-cash-coin fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Кредиты</h6>
                            @if($credits)
                                <p class="card-text fs-4 mb-0">{{ $credits->count() ?? 0 }} активных</p>
                                <small class="text-muted">
                                    {{ number_format($credits->sum('amount') ?? 0, 2) }} ₽ всего
                                </small>
                            @else
                                <p class="card-text fs-4 mb-0">0 активных</p>
                                <small class="text-muted">0 ₽ всего</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info text-white rounded p-3">
                                <i class="bi bi-telephone fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Контакты</h6>
                            <p class="card-text mb-0">{{ $client->phone ?? 'Не указан' }}</p>
                            <small class="text-muted">
                                {{ $client->entityType->name ?? 'Клиент' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($credits && $credits->count() > 0)
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Мои кредиты</h5>
            <a href="{{ route('client.credits') }}" class="btn btn-sm btn-outline-primary">
                Все кредиты
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Кредит</th>
                            <th>Сумма</th>
                            <th>Ставка</th>
                            <th>Срок</th>
                            <th>Дата начала</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($credits as $credit)
                            <tr>
                                <td>
                                    <strong>{{ $credit->creditType->name ?? 'Не указано' }}</strong>
                                </td>
                                <td>{{ number_format($credit->amount, 2) }} ₽</td>
                                <td>{{ $credit->rate }}%</td>
                                <td>{{ $credit->term }} мес.</td>
                                <td>{{ $credit->start_date ? \Carbon\Carbon::parse($credit->start_date)->format('d.m.Y') : 'N/A' }}</td>
                                <td>
                                    @if($credit->end_date && \Carbon\Carbon::parse($credit->end_date)->isPast())
                                        <span class="badge bg-secondary">Завершен</span>
                                    @else
                                        <span class="badge bg-success">Активен</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('credits.show', $credit->id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        Подробнее
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-body text-center py-5">
            <div class="mb-3">
                <i class="bi bi-cash fs-1 text-muted"></i>
            </div>
            <h5>У вас пока нет кредитов</h5>
            <p class="text-muted mb-4">Оформите свой первый кредит прямо сейчас</p>
            @if($client && $client->entity_type_id)
            <a href="{{ route('client.credits.create') }}" class="btn btn-primary">
                Оформить кредит
            </a>
            @else
            <p class="text-warning">Заполните информацию о себе, чтобы оформить кредит</p>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection