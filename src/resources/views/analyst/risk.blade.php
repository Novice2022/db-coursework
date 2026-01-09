@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Анализ кредитных рисков</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Кредиты с высоким риском</h5>
        </div>
        <div class="card-body">
            @if($riskyCredits->isEmpty())
                <p class="text-center text-muted">Нет кредитов с высоким риском</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Клиент</th>
                                <th>Сумма кредита</th>
                                <th>Дата выдачи</th>
                                <th>Дата погашения</th>
                                <th>Дней до погашения</th>
                                <th>Оплачено</th>
                                <th>Остаток</th>
                                <th>Уровень риска</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riskyCredits as $credit)
                                @php
                                    $totalPaid = $credit->payments->sum('amount');
                                    $remaining = $credit->amount - $totalPaid;
                                    $daysLeft = $credit->end_date ? now()->diffInDays($credit->end_date, false) : null;
                                @endphp
                                <tr>
                                    <td>{{ $credit->client->fullname }}</td>
                                    <td>{{ number_format($credit->amount, 0, ',', ' ') }} ₽</td>
                                    <td>{{ $credit->start_date->format('d.m.Y') }}</td>
                                    <td>{{ $credit->end_date ? $credit->end_date->format('d.m.Y') : '-' }}</td>
                                    <td>
                                        @if($daysLeft !== null)
                                            @if($daysLeft < 0)
                                                <span class="text-danger">Просрочено {{ abs($daysLeft) }} дн.</span>
                                            @elseif($daysLeft < 30)
                                                <span class="text-warning">{{ $daysLeft }} дн.</span>
                                            @else
                                                <span class="text-success">{{ $daysLeft }} дн.</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalPaid, 0, ',', ' ') }} ₽</td>
                                    <td>{{ number_format($remaining, 0, ',', ' ') }} ₽</td>
                                    <td>
                                        @if(!$credit->end_date || $daysLeft === null)
                                            <span class="badge badge-secondary">Не определен</span>
                                        @elseif($daysLeft < 0)
                                            <span class="badge badge-danger">Просрочен</span>
                                        @elseif($daysLeft < 7)
                                            <span class="badge badge-danger">Критический</span>
                                        @elseif($daysLeft < 30)
                                            <span class="badge badge-warning">Высокий</span>
                                        @elseif($daysLeft < 90)
                                            <span class="badge badge-info">Средний</span>
                                        @else
                                            <span class="badge badge-success">Низкий</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-exclamation-triangle"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $riskyCredits->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Рекомендации по снижению рисков</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Усиление проверки клиентов</h6>
                                <span class="badge badge-primary">Высокий приоритет</span>
                            </div>
                            <p class="mb-1">Внедрение дополнительных проверок кредитной истории</p>
                        </div>
                        
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Корректировка условий кредитования</h6>
                                <span class="badge badge-warning">Средний приоритет</span>
                            </div>
                            <p class="mb-1">Пересмотр процентных ставок для рискованных категорий</p>
                        </div>
                        
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Увеличение резервов</h6>
                                <span class="badge badge-danger">Критический приоритет</span>
                            </div>
                            <p class="mb-1">Создание дополнительных резервов на возможные потери</p>
                        </div>
                        
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Обучение менеджеров</h6>
                                <span class="badge badge-info">Низкий приоритет</span>
                            </div>
                            <p class="mb-1">Повышение квалификации по риск-менеджменту</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Статистика рисков</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-danger">{{ $riskyCredits->where('end_date', '<', now())->count() }}</h3>
                                <p class="text-muted">Просроченных кредитов</p>
                            </div>
                            <div class="col-6">
                                @php
                                    $highRisk = $riskyCredits->filter(function($credit) {
                                        $daysLeft = $credit->end_date ? now()->diffInDays($credit->end_date, false) : null;
                                        return $daysLeft !== null && $daysLeft >= 0 && $daysLeft < 30;
                                    })->count();
                                @endphp
                                <h3 class="text-warning">{{ $highRisk }}</h3>
                                <p class="text-muted">Высокий риск</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6>Распределение по типам клиентов:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <div class="d-flex justify-content-between">
                                <span>Физические лица</span>
                                <span class="badge badge-primary">65%</span>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-primary" style="width: 65%"></div>
                            </div>
                        </li>
                        <li class="mb-2">
                            <div class="d-flex justify-content-between">
                                <span>Юридические лица</span>
                                <span class="badge badge-success">35%</span>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-success" style="width: 35%"></div>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Риск-портфель:</strong> 78% кредитов имеют низкий или средний риск
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection