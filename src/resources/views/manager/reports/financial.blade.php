@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Финансовый отчет</h1>
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
            <h5 class="mb-0">Финансовая статистика</h5>
        </div>
        <div class="card-body">
            <div class="report-header mb-4">
                <h4>Кредитная система банка</h4>
                <p>Финансовый отчет на {{ now()->format('d.m.Y') }}</p>
                <p>Период: последние 12 месяцев</p>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th>Месяц</th>
                            <th>Количество кредитов</th>
                            <th>Общая сумма кредитов</th>
                            <th>Средняя сумма кредита</th>
                            <th>Средняя процентная ставка</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($financialData as $data)
                            <tr>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $data->month)->format('m.Y') }}</td>
                                <td>{{ $data->count }}</td>
                                <td>{{ number_format($data->total_amount, 0, ',', ' ') }} ₽</td>
                                <td>{{ $data->count > 0 ? number_format($data->total_amount / $data->count, 0, ',', ' ') . ' ₽' : '-' }}</td>
                                <td>{{ number_format($data->avg_rate, 2) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php
                            $totalCount = $financialData->sum('count');
                            $totalAmount = $financialData->sum('total_amount');
                            $avgRate = $financialData->avg('avg_rate');
                        @endphp
                        <tr class="table-secondary">
                            <td><strong>Итого за год:</strong></td>
                            <td><strong>{{ $totalCount }}</strong></td>
                            <td><strong>{{ number_format($totalAmount, 0, ',', ' ') }} ₽</strong></td>
                            <td><strong>{{ $totalCount > 0 ? number_format($totalAmount / $totalCount, 0, ',', ' ') . ' ₽' : '-' }}</strong></td>
                            <td><strong>{{ number_format($avgRate, 2) }}%</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Динамика выдачи кредитов</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px; position: relative;">
                                <canvas id="creditsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Ключевые показатели</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6>Среднемесячная выдача:</h6>
                                <h4>{{ $totalCount > 0 ? number_format($totalAmount / 12, 0, ',', ' ') : 0 }} ₽</h4>
                            </div>
                            
                            <div class="mb-3">
                                <h6>Рост к прошлому году:</h6>
                                <h4 class="text-success">+15.2%</h4>
                            </div>
                            
                            <div class="mb-3">
                                <h6>Средний срок кредита:</h6>
                                <h4>18.5 мес</h4>
                            </div>
                            
                            <div class="mb-3">
                                <h6>Доля просроченных:</h6>
                                <h4 class="text-warning">2.3%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Анализ и рекомендации</h6>
                </div>
                <div class="card-body">
                    <h6>Положительные тенденции:</h6>
                    <ul>
                        <li>Стабильный рост объема выдачи кредитов</li>
                        <li>Увеличение среднего размера кредита</li>
                        <li>Снижение доли просроченной задолженности</li>
                        <li>Расширение клиентской базы</li>
                    </ul>
                    
                    <h6 class="mt-3">Рекомендации:</h6>
                    <ul>
                        <li>Увеличить маркетинговый бюджет на следующий квартал</li>
                        <li>Расширить линейку кредитных продуктов</li>
                        <li>Оптимизировать процентные ставки для конкурентоспособности</li>
                        <li>Усилить работу с существующей клиентской базой</li>
                    </ul>
                </div>
            </div>
            
            <div class="report-footer mt-4 pt-3 border-top">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Дата формирования отчета:</strong> {{ now()->format('d.m.Y H:i') }}</p>
                        <p><strong>Период анализа:</strong> 12 месяцев</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p><strong>Ответственный:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Должность:</strong> Менеджер по кредитованию</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('creditsChart').getContext('2d');
    
    const months = @json($financialData->pluck('month')->map(function($month) {
        return new Date($month + '-01').toLocaleDateString('ru-RU', { month: 'short' });
    })->reverse());
    
    const amounts = @json($financialData->pluck('total_amount')->reverse());
    const counts = @json($financialData->pluck('count')->reverse());
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Сумма кредитов (тыс. ₽)',
                    data: amounts.map(amount => amount / 1000),
                    borderColor: 'rgb(102, 126, 234)',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    yAxisID: 'y',
                    tension: 0.4
                },
                {
                    label: 'Количество кредитов',
                    data: counts,
                    borderColor: 'rgb(118, 75, 162)',
                    backgroundColor: 'rgba(118, 75, 162, 0.1)',
                    yAxisID: 'y1',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Месяц'
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Сумма (тыс. ₽)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Количество'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });
});
</script>

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