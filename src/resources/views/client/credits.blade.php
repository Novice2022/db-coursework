@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Мои кредиты</h1>
        @if($client && $client->entity_type_id)
        <a href="{{ route('client.credits.create') }}" class="btn btn-primary">
            Оформить новый кредит
        </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            @if($credits && $credits->count() > 0)
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
                            @foreach($credits as $credit)
                                <tr>
                                    <td>
                                        <strong>{{ $credit->creditType->name ?? 'Не указано' }}</strong>
                                    </td>
                                    <td>{{ number_format($credit->amount, 2) }} ₽</td>
                                    <td>{{ $credit->rate }}%</td>
                                    <td>{{ $credit->term }} мес.</td>
                                    <td>{{ $credit->start_date ? \Carbon\Carbon::parse($credit->start_date)->format('d.m.Y') : 'N/A' }}</td>
                                    <td>
                                        @if($credit->end_date)
                                            {{ \Carbon\Carbon::parse($credit->end_date)->format('d.m.Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
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
                
                @if(method_exists($credits, 'links'))
                <div class="mt-3">
                    {{ $credits->links() }}
                </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-cash fs-1 text-muted"></i>
                    </div>
                    <h5>У вас пока нет кредитов</h5>
                    <p class="text-muted mb-4">Оформите свой первый кредит прямо сейчас</p>
                    @if($client && $client->entity_type_id)
                    <a href="{{ route('client.credits.create') }}" class="btn btn-primary">
                        Оформить первый кредит
                    </a>
                    @else
                    <p class="text-warning">Заполните информацию о себе, чтобы оформить кредит</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection