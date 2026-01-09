@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Отчеты</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Клиенты</h5>
                </div>
                <div class="card-body">
                    <p>Отчет по клиентам банка содержит:</p>
                    <ul>
                        <li>Список всех клиентов</li>
                        <li>Типы клиентов</li>
                        <li>Даты регистрации</li>
                        <li>Количество кредитов</li>
                        <li>Статус активности</li>
                    </ul>
                    <a href="{{ route('manager.reports.clients') }}" class="btn btn-primary">
                        <i class="bi bi-file-earmark-text me-2"></i> Сформировать отчет
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Финансовый отчет</h5>
                </div>
                <div class="card-body">
                    <p>Финансовый отчет содержит:</p>
                    <ul>
                        <li>Динамику выдачи кредитов</li>
                        <li>Общие суммы по месяцам</li>
                        <li>Средние процентные ставки</li>
                        <li>Распределение по типам кредитов</li>
                    </ul>
                    <a href="{{ route('manager.reports.financial') }}" class="btn btn-success">
                        <i class="bi bi-graph-up me-2"></i> Сформировать отчет
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Отчет по кредитам</h5>
                </div>
                <div class="card-body">
                    <p>Подробный отчет по всем кредитам:</p>
                    <ul>
                        <li>Активные кредиты</li>
                        <li>Просроченные платежи</li>
                        <li>Графики погашения</li>
                        <li>Статистика по менеджерам</li>
                    </ul>
                    <button class="btn btn-info" disabled>
                        <i class="bi bi-clock me-2"></i> В разработке
                    </button>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Аналитика эффективности</h5>
                </div>
                <div class="card-body">
                    <p>Отчет по эффективности работы:</p>
                    <ul>
                        <li>Конверсия клиентов</li>
                        <li>Средний чек по кредитам</li>
                        <li>Рентабельность операций</li>
                        <li>Прогнозы на следующий период</li>
                    </ul>
                    <button class="btn btn-warning" disabled>
                        <i class="bi bi-clock me-2"></i> В разработке
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection