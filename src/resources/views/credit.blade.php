@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Кредит: {{ $credit->creditType->name ?? 'Кредит #' . substr($credit->id, 0, 8) }}</h1>
        <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
            Назад
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Основная информация</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <small class="text-muted">Сумма кредита</small>
                            <p class="fs-5">{{ number_format($credit->amount, 2) }} ₽</p>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted">Процентная ставка</small>
                            <p class="fs-5">{{ $credit->rate }}%</p>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted">Срок кредита</small>
                            <p class="fs-5">{{ $credit->term }} мес.</p>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted">Дата начала</small>
                            <p class="fs-5">{{ $credit->start_date ? \Carbon\Carbon::parse($credit->start_date)->format('d.m.Y') : 'N/A' }}</p>
                        </div>
                        @if($credit->end_date)
                        <div class="col-6 mb-3">
                            <small class="text-muted">Дата окончания</small>
                            <p class="fs-5">{{ \Carbon\Carbon::parse($credit->end_date)->format('d.m.Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Финансовая информация</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <small class="text-muted">Остаток долга</small>
                            @php
                                $paid = $payments ? $payments->sum('amount') : 0;
                                $remaining = $credit->amount - $paid;
                            @endphp
                            <p class="fs-5 text-danger">{{ number_format($remaining, 2) }} ₽</p>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted">Ежемесячный платеж</small>
                            @php
                                // Простой расчет ежемесячного платежа
                                $monthlyPayment = $credit->amount * ($credit->rate / 100 / 12);
                            @endphp
                            <p class="fs-5">{{ number_format($monthlyPayment, 2) }} ₽</p>
                        </div>
                    </div>
                    @if($remaining > 0)
                    <div class="mt-3">
                        <a href="{{ route('credits.payments.create', $credit->id) }}" 
                           class="btn btn-primary w-100">
                            Внести платеж
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($payments && $payments->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">История платежей</h5>
                    <span class="badge bg-primary">{{ $payments->count() }} платежей</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Сумма</th>
                                    <th>Тип</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->datetime ? \Carbon\Carbon::parse($payment->datetime)->format('d.m.Y H:i') : 'N/A' }}</td>
                                    <td>{{ number_format($payment->amount, 2) }} ₽</td>
                                    <td><span class="badge bg-success">Платеж</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($fines && $fines->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Штрафы</h5>
                    <span class="badge bg-danger">{{ $fines->count() }} штрафов</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Причина</th>
                                    <th>Сумма</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fines as $fine)
                                <tr>
                                    <td>{{ $fine->datetime ? \Carbon\Carbon::parse($fine->datetime)->format('d.m.Y H:i') : 'N/A' }}</td>
                                    <td>{{ $fine->reason }}</td>
                                    <td>{{ number_format($fine->amount, 2) }} ₽</td>
                                    <td>
                                        @if($fine->payed_at)
                                            <span class="badge bg-success">Оплачен</span>
                                        @else
                                            <span class="badge bg-danger">Не оплачен</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$fine->payed_at)
                                        <form action="{{ route('credits.fines.update', ['creditId' => $credit->id, 'fineId' => $fine->id]) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                    onclick="return confirm('Подтвердите оплату штрафа')">
                                                Оплатить
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection