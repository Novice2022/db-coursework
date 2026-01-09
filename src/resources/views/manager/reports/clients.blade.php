@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Отчет по клиентам</h1>
        <div>
            <button class="btn btn-primary" onclick="window.print()">
                <i class="bi bi-printer me-2"></i> Печать
            </button>
            <a href="{{ route('manager.reports.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i> Назад
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Список клиентов</h5>
        </div>
        <div class="card-body">
            <div class="report-header mb-4">
                <h4>Кредитная система банка</h4>
                <p>Отчет по клиентам на {{ now()->format('d.m.Y') }}</p>
                <p>Всего клиентов: {{ $clients->count() }}</p>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th>№</th>
                            <th>ФИО</th>
                            <th>Тип клиента</th>
                            <th>Телефон</th>
                            <th>Дата регистрации</th>
                            <th>Количество кредитов</th>
                            <th>Общая сумма кредитов</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $index => $client)
                            @php
                                $totalAmount = $client->credits->sum('amount');
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $client->fullname }}</td>
                                <td>{{ $client->entityType->name }}</td>
                                <td>{{ $client->phone ?? '-' }}</td>
                                <td>{{ $client->registration_date }}</td>
                                <td>{{ $client->credits->count() }}</td>
                                <td>{{ number_format($totalAmount, 0, ',', ' ') }} ₽</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary">
                            <td colspan="5" class="text-end"><strong>Итого:</strong></td>
                            <td><strong>{{ $clients->sum(function($client) { return $client->credits->count(); }) }}</strong></td>
                            <td><strong>{{ number_format($clients->sum(function($client) { return $client->credits->sum('amount'); }), 0, ',', ' ') }} ₽</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Статистика по типам клиентов</h6>
                        </div>
                        <div class="card-body">
                            @php
                                $individualCount = $clients->where('entity_type_id', 1)->count();
                                $legalCount = $clients->where('entity_type_id', 2)->count();
                                $individualPercentage = $clients->count() > 0 ? ($individualCount / $clients->count() * 100) : 0;
                                $legalPercentage = $clients->count() > 0 ? ($legalCount / $clients->count() * 100) : 0;
                            @endphp
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Физические лица</span>
                                    <span>{{ $individualCount }} ({{ round($individualPercentage, 1) }}%)</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-primary" style="width: {{ $individualPercentage }}%"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Юридические лица</span>
                                    <span>{{ $legalCount }} ({{ round($legalPercentage, 1) }}%)</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-success" style="width: {{ $legalPercentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Общая статистика</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <h4>{{ $clients->count() }}</h4>
                                    <p class="text-muted">Всего клиентов</p>
                                </div>
                                <div class="col-6 mb-3">
                                    @php
                                        $clientsWithCredits = $clients->filter(function($client) {
                                            return $client->credits && $client->credits->count() > 0;
                                        })->count();
                                    @endphp
                                    <h4>{{ $clientsWithCredits }}</h4>
                                    <p class="text-muted">Клиентов с кредитами</p>
                                </div>
                                <div class="col-6">
                                    @php
                                        $newClients = $clients->filter(function($client) {
                                            if (!$client->registration_date) {
                                                return false;
                                            }
                                            
                                            try {
                                                $registrationDate = is_string($client->registration_date) 
                                                    ? \Carbon\Carbon::parse($client->registration_date)
                                                    : $client->registration_date;
                                                    
                                                return $registrationDate->diffInDays(now()) <= 30;
                                            } catch (\Exception $e) {
                                                return false;
                                            }
                                        })->count();
                                    @endphp
                                    <h4>{{ $newClients }}</h4>
                                    <p class="text-muted">Новых за месяц</p>
                                </div>
                                <div class="col-6">
                                    @php
                                        $activeClients = $clients->filter(function($client) {
                                            if (!$client->credits || $client->credits->isEmpty()) {
                                                return false;
                                            }
                                            
                                            foreach ($client->credits as $credit) {
                                                if ($credit->end_date && $credit->end_date > now()) {
                                                    return true;
                                                }
                                            }
                                            return false;
                                        })->count();
                                    @endphp
                                    <h4>{{ $activeClients }}</h4>
                                    <p class="text-muted">Активных клиентов</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="report-footer mt-4 pt-3 border-top">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Дата формирования отчета:</strong> {{ now()->format('d.m.Y H:i') }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p><strong>Ответственный:</strong> {{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .btn, .report-footer {
        display: none !important;
    }
    
    .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .card-header {
        background: white !important;
        color: black !important;
        border-bottom: 2px solid #000 !important;
    }
}
</style>
@endsection