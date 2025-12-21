@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Клиент: {{ $client->fullname }}</h1>
        <a href="{{ route('manager.clients') }}" class="btn btn-outline-secondary">
            Назад к списку
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Основная информация</h5>
                </div>
                <div class="card-body">
                    <p><strong>ФИО:</strong> {{ $client->fullname }}</p>
                    <p><strong>Телефон:</strong> {{ $client->phone }}</p>
                    <p><strong>Email:</strong> {{ $client->email ?? 'Не указан' }}</p>
                    <p><strong>Адрес:</strong> {{ $client->address ?? 'Не указан' }}</p>
                    <p><strong>Тип клиента:</strong> {{ $client->entityType->name ?? 'N/A' }}</p>
                    <p><strong>Дата регистрации:</strong> {{ \Carbon\Carbon::parse($client->registration_date)->format('d.m.Y') }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Дополнительная информация</h5>
                </div>
                <div class="card-body">
                    @if($client->entity_type_id == 1 && $client->individualEntity)
                        <p><strong>Тип:</strong> Физическое лицо</p>
                        <p><strong>Доход:</strong> {{ $client->individualEntity->income ? number_format($client->individualEntity->income, 0) . ' ₽' : 'Не указан' }}</p>
                        <p><strong>Кредитная история:</strong> {{ $client->individualEntity->creditHistory->quality ?? 'N/A' }}</p>
                    @elseif($client->entity_type_id == 2 && $client->legalEntity)
                        <p><strong>Тип:</strong> Юридическое лицо</p>
                        <p><strong>Отрасль:</strong> {{ $client->legalEntity->industry->name ?? 'N/A' }}</p>
                        <p><strong>Прибыльность:</strong> {{ $client->legalEntity->profitability->quality ?? 'N/A' }}</p>
                        <p><strong>Сумма гарантии:</strong> {{ $client->legalEntity->guarantee_amount ? number_format($client->legalEntity->guarantee_amount, 0) . ' ₽' : 'Не указана' }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Статистика</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <small class="text-muted">Всего кредитов</small>
                            <p class="fs-5">{{ $stats['total_credits'] }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted">Активных кредитов</small>
                            <p class="fs-5">{{ $stats['active_credits'] }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted">Общая сумма</small>
                            <p class="fs-5">{{ number_format($stats['total_borrowed'], 0) }} ₽</p>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted">Выплачено</small>
                            <p class="fs-5">{{ number_format($stats['total_paid'], 0) }} ₽</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Кредиты клиента</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCreditModal">
                Добавить кредит
            </button>
        </div>
        <div class="card-body">
            @if($client->credits->isEmpty())
                <div class="text-center py-3">
                    <p class="text-muted mb-0">У клиента нет кредитов</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Тип кредита</th>
                                <th>Сумма</th>
                                <th>Ставка</th>
                                <th>Срок</th>
                                <th>Дата начала</th>
                                <th>Дата окончания</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($client->credits as $credit)
                                <tr>
                                    <td>{{ $credit->creditType->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($credit->amount, 0) }} ₽</td>
                                    <td>{{ $credit->rate }}%</td>
                                    <td>{{ $credit->term }} мес.</td>
                                    <td>{{ \Carbon\Carbon::parse($credit->start_date)->format('d.m.Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($credit->end_date)->format('d.m.Y') }}</td>
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
            @endif
        </div>
    </div>
</div>

<!-- Модальное окно создания кредита -->
<div class="modal fade" id="createCreditModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление кредита</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('manager.clients.credits.create', $client->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Тип кредита</label>
                        <select name="credit_type_id" class="form-select" required>
                            <option value="">Выберите тип кредита</option>
                            @foreach($creditTypes ?? [] as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Сумма (₽)</label>
                        <input type="number" name="amount" class="form-control" 
                               min="1000" step="1000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Процентная ставка (%)</label>
                        <input type="number" name="rate" class="form-control" 
                               min="1" max="50" step="0.1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Срок (месяцев)</label>
                        <input type="number" name="term" class="form-control" 
                               min="1" max="360" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Дата начала</label>
                        <input type="date" name="start_date" class="form-control" 
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Создать кредит</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection