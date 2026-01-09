@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Кредит №{{ substr($credit->id, 0, 8) }}...</h1>
        <a href="{{ route('client.credits.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i> Назад к списку
        </a>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Основная информация</h5>
                </div>
                <div class="card-body">
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
                        $percentage = $totalPaid / $credit->amount * 100;
                        $percentage = min($percentage, 100);
                    @endphp
                    
                    <p><strong>Остаток долга:</strong> {{ number_format($remaining, 0, ',', ' ') }} ₽</p>
                    <p><strong>Оплачено:</strong> {{ number_format($totalPaid, 0, ',', ' ') }} ₽</p>
                    
                    <div class="mt-3">
                        <h6>Прогресс погашения</h6>
                        <div class="progress" style="height: 20px;">
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
            
            @if($credit->fines->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Штрафы</h5>
                    </div>
                    <div class="card-body">
                        @foreach($credit->fines as $fine)
                            <div class="alert alert-danger">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ number_format($fine->amount, 0, ',', ' ') }} ₽</strong>
                                    <span>
                                        @if($fine->payed_at)
                                            <span class="badge badge-success">Оплачен</span>
                                        @else
                                            <span class="badge badge-danger">Не оплачен</span>
                                        @endif
                                    </span>
                                </div>
                                <p class="mb-0 mt-2">{{ $fine->reason }}</p>
                                <small class="text-muted">{{ $fine->datetime }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">История платежей</h5>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($credit->payments->sortByDesc('datetime') as $payment)
                                        <tr>
                                            <td>{{ $payment->datetime }}</td>
                                            <td>{{ number_format($payment->amount, 0, ',', ' ') }} ₽</td>
                                            <td>
                                                @if(isset($payment->is_fine) && $payment->is_fine)
                                                    <span class="badge badge-danger">Штраф</span>
                                                @else
                                                    <span class="badge badge-success">Платеж</span>
                                                @endif
                                            </td>
                                            <td><span class="badge badge-success">Оплачен</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="row text-center mt-4">
                            <div class="col-md-4">
                                <h4>{{ number_format($totalPaid, 0, ',', ' ') }} ₽</h4>
                                <p class="text-muted">Всего оплачено</p>
                            </div>
                            <div class="col-md-4">
                                <h4>{{ $credit->payments->count() }}</h4>
                                <p class="text-muted">Количество платежей</p>
                            </div>
                            <div class="col-md-4">
                                <h4>{{ number_format($remaining, 0, ',', ' ') }} ₽</h4>
                                <p class="text-muted">Остаток к оплате</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">График платежей</h5>
                </div>
                <div class="card-body">
                    @php
                        $startDate = $credit->start_date;
                        $monthlyRate = $credit->rate / 100 / 12;
                        $monthlyPayment = $credit->amount * $monthlyRate * pow(1 + $monthlyRate, $credit->term) / 
                                         (pow(1 + $monthlyRate, $credit->term) - 1);
                    @endphp
                    
                    <p>Ежемесячный платеж: <strong>{{ number_format($monthlyPayment, 2, ',', ' ') }} ₽</strong></p>
                    
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Дата платежа</th>
                                    <th>Сумма платежа</th>
                                    <th>Основной долг</th>
                                    <th>Проценты</th>
                                    <th>Остаток долга</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 1; $i <= min(12, $credit->term); $i++)
                                    @php
                                        $paymentDate = $startDate->copy()->addMonths($i);
                                        $interest = $remaining * $monthlyRate;
                                        $principal = $monthlyPayment - $interest;
                                        $remaining = max($remaining - $principal, 0);
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $paymentDate->format('d.m.Y') }}</td>
                                        <td>{{ number_format($monthlyPayment, 2, ',', ' ') }} ₽</td>
                                        <td>{{ number_format($principal, 2, ',', ' ') }} ₽</td>
                                        <td>{{ number_format($interest, 2, ',', ' ') }} ₽</td>
                                        <td>{{ number_format($remaining, 2, ',', ' ') }} ₽</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                    
                    @if($credit->term > 12)
                        <div class="text-center mt-2">
                            <p class="text-muted">Показано 12 из {{ $credit->term }} платежей</p>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download me-1"></i> Скачать полный график
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection