@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Финансовая аналитика</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Отчет по рискам</h5>
        </div>
        <div class="card-body">
            <p>Подробный анализ кредитных рисков содержит:</p>
            <ul>
                <li>Распределение кредитов по уровням риска</li>
                <li>Анализ просроченной задолженности</li>
                <li>Прогноз вероятности дефолта</li>
                <li>Рекомендации по снижению рисков</li>
            </ul>
            <a href="{{ route('analyst.reports.risk') }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-bar-graph me-2"></i> Сформировать отчет
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Прибыльность кредитного портфеля</h5>
                </div>
                <div class="card-body text-center">
                    <h2 class="text-success">24.5%</h2>
                    <p class="text-muted">Средняя доходность</p>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: 75%"></div>
                    </div>
                    <p class="small mt-2">Выше целевого показателя на 5.5%</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Коэффициент покрытия рисков</h5>
                </div>
                <div class="card-body text-center">
                    <h2 class="text-warning">1.8</h2>
                    <p class="text-muted">Текущий коэффициент</p>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-warning" style="width: 60%"></div>
                    </div>
                    <p class="small mt-2">Нормативное значение: 1.5</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Средний срок кредита</h5>
                </div>
                <div class="card-body text-center">
                    <h2 class="text-info">18 мес</h2>
                    <p class="text-muted">Средняя продолжительность</p>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-info" style="width: 45%"></div>
                    </div>
                    <p class="small mt-2">Увеличился на 2 месяца за год</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Тренды и прогнозы</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Тренды выдачи кредитов:</h6>
                    <ul>
                        <li>Рост выдачи кредитов юридическим лицам на 15%</li>
                        <li>Снижение процентных ставок на 0.5%</li>
                        <li>Увеличение среднего срока кредитования</li>
                        <li>Рост доли ипотечных кредитов</li>
                    </ul>
                </div>
                
                <div class="col-md-6">
                    <h6>Прогноз на следующий квартал:</h6>
                    <ul>
                        <li>Ожидаемый рост портфеля на 8-12%</li>
                        <li>Увеличение просроченной задолженности на 2-3%</li>
                        <li>Снижение средней ставки до 14.5%</li>
                        <li>Рост числа клиентов на 5-7%</li>
                    </ul>
                </div>
            </div>
            
            <div class="alert alert-success mt-3">
                <i class="bi bi-graph-up me-2"></i>
                <strong>Положительная динамика:</strong> Кредитный портфель показывает стабильный рост при сохранении качества
            </div>
        </div>
    </div>
</div>
@endsection