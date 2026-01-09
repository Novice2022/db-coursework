@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Клиент: {{ $client->fullname }}</h1>
        <a href="{{ route('manager.clients.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i> Назад
        </a>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Информация о клиенте</h5>
                </div>
                <div class="card-body">
                    <p><strong>ФИО:</strong> {{ $client->fullname }}</p>
                    <p><strong>Тип клиента:</strong> {{ $client->entityType->name }}</p>
                    @if($client->phone)
                        <p><strong>Телефон:</strong> {{ $client->phone }}</p>
                    @endif
                    @if($client->email)
                        <p><strong>Email:</strong> {{ $client->email }}</p>
                    @endif
                    @if($client->address)
                        <p><strong>Адрес:</strong> {{ $client->address }}</p>
                    @endif
                    <p><strong>Дата регистрации:</strong> {{ $client->registration_date }}</p>
                    
                    @if($client->legalEntity)
                        <hr>
                        <h6>Информация о юридическом лице:</h6>
                        <p><strong>Отрасль:</strong> {{ $client->legalEntity->industry->name ?? '-' }}</p>
                        <p><strong>Рентабельность:</strong> {{ $client->legalEntity->profitability->quality ?? '-' }}</p>
                        <p><strong>Сумма гарантии:</strong> {{ number_format($client->legalEntity->guarantee_amount, 0, ',', ' ') }} ₽</p>
                    @endif
                    
                    @if($client->individualEntity)
                        <hr>
                        <h6>Информация о физическом лице:</h6>
                        <p><strong>Кредитная история:</strong> {{ $client->individualEntity->creditHistory->quality ?? '-' }}</p>
                        <p><strong>Доход:</strong> {{ number_format($client->individualEntity->income, 0, ',', ' ') }} ₽</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Кредиты клиента</h5>
                    <a href="{{ route('manager.credits.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Выдать кредит
                    </a>
                </div>
                <div class="card-body">
                    @if($client->credits->isEmpty())
                        <p class="text-center text-muted">У клиента нет кредитов</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Тип кредита</th>
                                        <th>Сумма</th>
                                        <th>Ставка</th>
                                        <th>Срок</th>
                                        <th>Дата выдачи</th>
                                        <th>Дата погашения</th>
                                        <th>Статус</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client->credits as $credit)
                                        <tr>
                                            <td>{{ $credit->creditType->name ?? 'Не указан' }}</td>
                                            <td>{{ number_format($credit->amount, 0, ',', ' ') }} ₽</td>
                                            <td>{{ $credit->rate }}%</td>
                                            <td>{{ $credit->term }} мес</td>
                                            <td>{{ $credit->start_date->format('d.m.Y') }}</td>
                                            <td>{{ $credit->end_date ? $credit->end_date->format('d.m.Y') : '-' }}</td>
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
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Статистика по клиенту</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h3>{{ $client->credits->count() }}</h3>
                            <p class="text-muted">Всего кредитов</p>
                        </div>
                        <div class="col-md-3">
                            <h3>{{ number_format($client->credits->sum('amount'), 0, ',', ' ') }} ₽</h3>
                            <p class="text-muted">Общая сумма</p>
                        </div>
                        <div class="col-md-3">
                            @php
                                $activeCredits = $client->credits->filter(function($credit) {
                                    return $credit->end_date && $credit->end_date > now();
                                });
                            @endphp
                            <h3>{{ $activeCredits->count() }}</h3>
                            <p class="text-muted">Активных кредитов</p>
                        </div>
                        <div class="col-md-3">
                            @php
                                $overdueCredits = $client->credits->filter(function($credit) {
                                    return $credit->end_date && $credit->end_date < now();
                                });
                            @endphp
                            <h3>{{ $overdueCredits->count() }}</h3>
                            <p class="text-muted">Просроченных</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection