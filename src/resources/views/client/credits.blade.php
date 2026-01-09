@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Мои кредиты</h1>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Список кредитов</h5>
        </div>
        <div class="card-body">
            @if($credits->isEmpty())
                <p class="text-center text-muted">У вас нет кредитов</p>
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
                                <th>Остаток</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($credits as $credit)
                                @php
                                    $totalPaid = $credit->payments->sum('amount');
                                    $remaining = $credit->amount - $totalPaid;
                                @endphp
                                <tr>
                                    <td>{{ $credit->creditType->name ?? 'Не указан' }}</td>
                                    <td>{{ number_format($credit->amount, 0, ',', ' ') }} ₽</td>
                                    <td>{{ $credit->rate }}%</td>
                                    <td>{{ $credit->term }} мес</td>
                                    <td>{{ $credit->start_date->format('d.m.Y') }}</td>
                                    <td>{{ $credit->end_date ? $credit->end_date->format('d.m.Y') : '-' }}</td>
                                    <td>{{ number_format($remaining, 0, ',', ' ') }} ₽</td>
                                    <td>
                                        @if($remaining <= 0)
                                            <span class="badge badge-success">Погашен</span>
                                        @elseif($credit->end_date && $credit->end_date < now())
                                            <span class="badge badge-danger">Просрочен</span>
                                        @elseif($credit->end_date && $credit->end_date > now())
                                            <span class="badge badge-primary">Активен</span>
                                        @else
                                            <span class="badge badge-secondary">Не определен</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('client.credits.show', $credit->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Подробнее
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
@endsection