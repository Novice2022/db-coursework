@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Внесение платежа</h4>
                </div>
                <div class="card-body">
                    @php
                        $paid = $credit->payments->sum('amount');
                        $remaining = $credit->amount - $paid;
                    @endphp
                    
                    <div class="alert alert-info mb-4">
                        <h5 class="alert-heading">Информация о кредите</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Тип кредита:</strong> {{ $credit->creditType->name ?? 'Не указано' }}</p>
                                <p class="mb-1"><strong>Сумма кредита:</strong> {{ number_format($credit->amount, 2) }} ₽</p>
                                <p class="mb-1"><strong>Ставка:</strong> {{ $credit->rate }}%</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Уже выплачено:</strong> {{ number_format($paid, 2) }} ₽</p>
                                <p class="mb-1"><strong>Остаток:</strong> {{ number_format($remaining, 2) }} ₽</p>
                                <p class="mb-1"><strong>Срок:</strong> {{ $credit->term }} мес.</p>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('credits.payments.store', $credit->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Сумма платежа (₽)</label>
                            <input type="number" 
                                   name="amount" 
                                   class="form-control" 
                                   min="1"
                                   step="0.01"
                                   max="{{ $remaining }}"
                                   value="{{ min(10000, $remaining) }}"
                                   required>
                            <div class="form-text">
                                Максимальная сумма: {{ number_format($remaining, 2) }} ₽
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Дата платежа</label>
                            <input type="datetime-local" 
                                   name="datetime" 
                                   class="form-control"
                                   value="{{ now()->format('Y-m-d\TH:i') }}"
                                   required>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('credits.show', $credit->id) }}" class="btn btn-secondary">
                                Отмена
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Внести платеж
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection