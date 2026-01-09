@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Клиенты банка</h1>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Список клиентов</h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-sm" style="width: 250px;" placeholder="Поиск по имени...">
                <button class="btn btn-primary btn-sm">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @if($clients->isEmpty())
                <p class="text-center text-muted">Нет клиентов</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ФИО</th>
                                <th>Тип клиента</th>
                                <th>Телефон</th>
                                <th>Адрес</th>
                                <th>Дата регистрации</th>
                                <th>Кредитов</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>{{ $client->fullname }}</td>
                                    <td>
                                        @if($client->entity_type_id == 1)
                                            <span class="badge badge-primary">Физическое лицо</span>
                                        @else
                                            <span class="badge badge-success">Юридическое лицо</span>
                                        @endif
                                    </td>
                                    <td>{{ $client->phone ?? '-' }}</td>
                                    <td>{{ $client->address ?? '-' }}</td>
                                    <td>{{ $client->registration_date }}</td>
                                    <td>{{ $client->credits_count ?? $client->credits->count() }}</td>
                                    <td>
                                        <a href="{{ route('manager.clients.show', $client->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-telephone"></i>
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
            @endif
        </div>
    </div>
</div>
@endsection