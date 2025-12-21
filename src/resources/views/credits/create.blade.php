@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Оформление кредита</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.credits.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Тип кредита</label>
                                <select name="credit_type_id" class="form-select" required>
                                    <option value="">Выберите тип кредита</option>
                                    @foreach($creditTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Сумма кредита (руб.)</label>
                                <input type="number" name="amount" class="form-control" 
                                       min="1000" step="1000" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Срок кредита (месяцев)</label>
                                <input type="number" name="term" class="form-control" 
                                       min="1" max="360" required>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('client.dashboard') }}" class="btn btn-secondary">
                                Отмена
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Подать заявку
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection