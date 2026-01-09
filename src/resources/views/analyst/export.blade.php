@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Экспорт данных</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Доступные отчеты для экспорта</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <i class="bi bi-credit-card text-primary" style="font-size: 3rem;"></i>
                                    <h5 class="mt-3">Данные по кредитам</h5>
                                    <p class="text-muted">Полная информация по всем выданным кредитам</p>
                                    <a href="{{ route('analyst.export.credits') }}" class="btn btn-primary">
                                        <i class="bi bi-download me-2"></i> Скачать CSV
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <i class="bi bi-cash-stack text-success" style="font-size: 3rem;"></i>
                                    <h5 class="mt-3">История платежей</h5>
                                    <p class="text-muted">Все платежи по кредитам с детализацией</p>
                                    <a href="{{ route('analyst.export.payments') }}" class="btn btn-success">
                                        <i class="bi bi-download me-2"></i> Скачать CSV
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <i class="bi bi-people text-info" style="font-size: 3rem;"></i>
                                    <h5 class="mt-3">Данные клиентов</h5>
                                    <p class="text-muted">Информация о всех клиентах банка</p>
                                    <button class="btn btn-info" disabled>
                                        <i class="bi bi-download me-2"></i> В разработке
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                                    <h5 class="mt-3">Риск-анализ</h5>
                                    <p class="text-muted">Отчет по рискам кредитного портфеля</p>
                                    <button class="btn btn-warning" disabled>
                                        <i class="bi bi-download me-2"></i> В разработке
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Информация о экспорте</h5>
                </div>
                <div class="card-body">
                    <h6>Формат файлов:</h6>
                    <p>Все данные экспортируются в формате CSV (Comma Separated Values), который можно открыть в:</p>
                    <ul>
                        <li>Microsoft Excel</li>
                        <li>Google Sheets</li>
                        <li>LibreOffice Calc</li>
                        <li>Любом текстовом редакторе</li>
                    </ul>
                    
                    <h6 class="mt-4">Структура данных:</h6>
                    <p>Каждый файл содержит:</p>
                    <ul>
                        <li>Заголовки столбцов</li>
                        <li>Актуальные данные из базы</li>
                        <li>Дату генерации отчета</li>
                    </ul>
                    
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Важно:</strong> Файлы обновляются в реальном времени при каждой загрузке
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection