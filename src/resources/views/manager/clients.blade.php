@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Клиенты</h1>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('manager.clients') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Поиск по ФИО или телефону" 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="entity_type" class="form-select">
                        <option value="">Все типы</option>
                        <option value="1" {{ request('entity_type') == '1' ? 'selected' : '' }}>Физические лица</option>
                        <option value="2" {{ request('entity_type') == '2' ? 'selected' : '' }}>Юридические лица</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Поиск</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('manager.clients') }}" class="btn btn-secondary w-100">Сбросить</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ФИО</th>
                            <th>Телефон</th>
                            <th>Тип</th>
                            <th>Дата регистрации</th>
                            <th>Кол-во кредитов</th>
                            <th>Общая сумма</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>
                                    <strong>{{ $client->fullname }}</strong>
                                </td>
                                <td>{{ $client->phone }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $client->entity_type_id == 1 ? 'bg-primary' : 'bg-success' }}">
                                        {{ $client->entityType->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($client->registration_date)->format('d.m.Y') }}</td>
                                <td>{{ $client->credits->count() }}</td>
                                <td>{{ number_format($client->credits->sum('amount'), 0) }} ₽</td>
                                <td>
                                    <a href="{{ route('manager.clients.show', $client->id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        Подробнее
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</div>
@endsection