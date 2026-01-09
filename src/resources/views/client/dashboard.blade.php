@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Панель клиента</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-primary">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="stat-value">{{ number_format($totalLoans, 0, ',', ' ') }} ₽</div>
                <div class="stat-label">Общая сумма кредитов</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-success">
                    <i class="bi bi-credit-card"></i>
                </div>
                <div class="stat-value">{{ $activeLoans }}</div>
                <div class="stat-label">Активных кредитов</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-value">{{ $credits->where('end_date', '<', now())->count() }}</div>
                <div class="stat-label">Завершенных кредитов</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="stat-icon text-info">
                    <i class="bi bi-person"></i>
                </div>
                <div class="stat-value">{{ $client->entity_type_id == 1 ? 'Физ. лицо' : 'Юр. лицо' }}</div>
                <div class="stat-label">Тип клиента</div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Мои кредиты</h5>
        </div>
        <div class="card-body">
            @if($credits->isEmpty())
                <p class="text-center text-muted">У вас нет активных кредитов</p>
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
                            @foreach($credits as $credit)
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
                                        <a href="{{ route('client.credits.show', $credit->id) }}" 
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
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Личная информация</h5>
                </div>
                <div class="card-body">
                    <p><strong>ФИО:</strong> {{ $client->fullname }}</p>
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
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Быстрые действия</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('client.credits.index') }}" class="btn btn-primary">
                            <i class="bi bi-credit-card me-2"></i> Мои кредиты
                        </a>
                        <a href="{{ route('client.payments.index') }}" class="btn btn-success">
                            <i class="bi bi-cash-stack me-2"></i> История платежей
                        </a>
                        <a href="{{ route('client.profile') }}" class="btn btn-warning">
                            <i class="bi bi-person me-2"></i> Мой профиль
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection