@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Кредит №{{ substr($credit->id, 0, 8) }}...</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('manager.credits.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i> Назад
            </a>
            <button class="btn btn-primary">
                <i class="bi bi-printer me-2"></i> Печать
            </button>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Основная информация</h5>
                </div>
                <div class="card-body">
                    <p><strong>Клиент:</strong> {{ $credit->client->fullname }}</p>
                    <p><strong>Тип клиента:</strong> {{ $credit->client->entityType->name }}</p>
                    <p><strong>Тип кредита:</strong> {{ $credit->creditType->name ?? 'Не указан' }}</p>
                    <p><strong>Сумма кредита:</strong> {{ number_format($credit->amount, 0, ',', ' ') }} ₽</p>
                    <p><strong>Процентная ставка:</strong> {{ $credit->rate }}%</p>
                    <p><strong>Срок:</strong> {{ $credit->term }} месяцев</p>
                    <p><strong>Дата выдачи:</strong> {{ $credit->start_date->format('d.m.Y') }}</p>
                    <p><strong>Дата погашения:</strong> {{ $credit->end_date ? $credit->end_date->format('d.m.Y') : '-' }}</p>
                    
                    <hr>
                    
                    <p><strong>Статус:</strong>
                        @if($credit->end_date && $credit->end_date < now())
                            <span class="badge badge-success">Погашен</span>
                        @elseif($credit->end_date && $credit->end_date > now())
                            <span class="badge badge-primary">Активен</span>
                        @else
                            <span class="badge badge-secondary">Не определен</span>
                        @endif
                    </p>
                    
                    @php
                        $totalPaid = $credit->payments->sum('amount');
                        $remaining = $credit->amount - $totalPaid;
                    @endphp
                    <p><strong>Остаток долга:</strong> {{ number_format($remaining, 0, ',', ' ') }} ₽</p>
                    <p><strong>Оплачено:</strong> {{ number_format($totalPaid, 0, ',', ' ') }} ₽</p>
                </div>
            </div>
            
            @if($credit->fines->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Штрафы</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Сумма</th>
                                        <th>Причина</th>
                                        <th>Дата</th>
                                        <th>Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($credit->fines as $fine)
                                        <tr>
                                            <td>{{ number_format($fine->amount, 0, ',', ' ') }} ₽</td>
                                            <td>{{ $fine->reason }}</td>
                                            <td>{{ $fine->datetime }}</td>
                                            <td>
                                                @if($fine->payed_at)
                                                    <span class="badge badge-success">Оплачен</span>
                                                @else
                                                    <span class="badge badge-danger">Не оплачен</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">График платежей</h5>
                </div>
                <div class="card-body">
                    @if($credit->payments->isEmpty())
                        <p class="text-center text-muted">Платежей пока нет</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Дата платежа</th>
                                        <th>Сумма платежа</th>
                                        <th>Тип платежа</th>
                                        <th>Статус</th>
                                        <th>Комментарий</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($credit->payments as $payment)
                                        <tr>
                                            <td>{{ $payment->datetime }}</td>
                                            <td>{{ number_format($payment->amount, 0, ',', ' ') }} ₽</td>
                                            <td>
                                                @if($payment->is_fine)
                                                    <span class="badge badge-danger">Штраф</span>
                                                @else
                                                    <span class="badge badge-success">Платеж</span>
                                                @endif
                                            </td>
                                            <td><span class="badge badge-success">Оплачен</span></td>
                                            <td>{{ $payment->notes ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <h6>Прогресс погашения</h6>
                        <div class="progress" style="height: 20px;">
                            @php
                                $percentage = $totalPaid / $credit->amount * 100;
                                $percentage = min($percentage, 100);
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $percentage }}%" 
                                 aria-valuenow="{{ $percentage }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                {{ round($percentage, 1) }}%
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <small>0 ₽</small>
                            <small>{{ number_format($credit->amount, 0, ',', ' ') }} ₽</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Действия с кредитом</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <button class="btn btn-success w-100 mb-2">
                                <i class="bi bi-cash-stack me-2"></i> Добавить платеж
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-warning w-100 mb-2">
                                <i class="bi bi-clock-history me-2"></i> Продлить срок
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-danger w-100 mb-2">
                                <i class="bi bi-exclamation-triangle me-2"></i> Назначить штраф
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-info w-100 mb-2">
                                <i class="bi bi-file-earmark-text me-2"></i> Сформировать отчет
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-secondary w-100 mb-2">
                                <i class="bi bi-envelope me-2"></i> Отправить уведомление
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-danger w-100 mb-2">
                                <i class="bi bi-trash me-2"></i> Закрыть кредит
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection