@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Кредиты банка</h1>
        <a href="{{ route('manager.credits.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i> Выдать новый кредит
        </a>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Список всех кредитов</h5>
        </div>
        <div class="card-body">
            @if($credits->isEmpty())
                <p class="text-center text-muted">Нет кредитов</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Клиент</th>
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
                                    <td>{{ $credit->client->fullname }}</td>
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
                
                <div class="mt-3">
                    {{ $credits->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection