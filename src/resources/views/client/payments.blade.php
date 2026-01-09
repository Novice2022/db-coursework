@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">История платежей</h1>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Все платежи</h5>
        </div>
        <div class="card-body">
            @if($payments->isEmpty())
                <p class="text-center text-muted">Нет платежей</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Номер кредита</th>
                                <th>Сумма платежа</th>
                                <th>Тип платежа</th>
                                <th>Статус</th>
                                <th>Примечание</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->datetime }}</td>
                                    <td>
                                        <a href="{{ route('client.credits.show', $payment->credit_id) }}">
                                            {{ substr($payment->credit_id, 0, 8) }}...
                                        </a>
                                    </td>
                                    <td>{{ number_format($payment->amount, 0, ',', ' ') }} ₽</td>
                                    <td>
                                        @if(isset($payment->is_fine) && $payment->is_fine)
                                            <span class="badge badge-danger">Штраф</span>
                                        @else
                                            <span class="badge badge-success">Платеж</span>
                                        @endif
                                    </td>
                                    <td><span class="badge badge-success">Оплачен</span></td>
                                    <td>{{ $payment->notes ?? 'Оплата по кредиту' }}</td>
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
                    <h5 class="mb-0">Статистика платежей</h5>
                </div>
                <div class="card-body">
                    @php
                        $totalPayments = $payments->sum('amount');
                        $regularPayments = $payments->where('is_fine', false)->sum('amount');
                        $fines = $payments->where('is_fine', true)->sum('amount');
                        $avgPayment = $payments->count() > 0 ? $payments->avg('amount') : 0;
                    @endphp
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <h3>{{ number_format($totalPayments, 0, ',', ' ') }} ₽</h3>
                            <p class="text-muted">Всего оплачено</p>
                        </div>
                        <div class="col-6">
                            <h3>{{ $payments->count() }}</h3>
                            <p class="text-muted">Количество платежей</p>
                        </div>
                        <div class="col-6">
                            <h3>{{ number_format($regularPayments, 0, ',', ' ') }} ₽</h3>
                            <p class="text-muted">Основные платежи</p>
                        </div>
                        <div class="col-6">
                            <h3>{{ number_format($fines, 0, ',', ' ') }} ₽</h3>
                            <p class="text-muted">Штрафы</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ближайшие платежи</h5>
                </div>
                <div class="card-body">
                    <p class="text-center text-muted">Информация о ближайших платежах</p>
                    <div class="text-center">
                        <i class="bi bi-calendar-check" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="mt-2">График платежей формируется автоматически</p>
                        <button class="btn btn-primary mt-2">
                            <i class="bi bi-download me-2"></i> Скачать график
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection