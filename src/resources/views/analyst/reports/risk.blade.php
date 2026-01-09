@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Отчет по рискам</h1>
        <div>
            <button class="btn btn-primary" onclick="window.print()">
                <i class="bi bi-printer me-2"></i> Печать
            </button>
            <a href="{{ route('analyst.reports.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i> Назад
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Анализ кредитных рисков</h5>
        </div>
        <div class="card-body">
            <div class="report-header mb-4">
                <h4>Кредитная система банка</h4>
                <p>Отчет по рискам на {{ now()->format('d.m.Y') }}</p>
                <p>Всего кредитов в портфеле: {{ $riskData->count() }}</p>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="stat-icon text-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="stat-value">{{ $riskData->where('days_left', '<', 0)->count() }}</div>
                        <div class="stat-label">Просроченных</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="stat-icon text-warning">
                            <i class="bi bi-clock"></i>
                        </div>
                        @php
                            $highRisk = $riskData->filter(function($credit) {
                                return $credit->days_left >= 0 && $credit->days_left < 30;
                            })->count();
                        @endphp
                        <div class="stat-value">{{ $highRisk }}</div>
                        <div class="stat-label">Высокий риск</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="stat-icon text-info">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        @php
                            $mediumRisk = $riskData->filter(function($credit) {
                                return $credit->days_left >= 30 && $credit->days_left < 90;
                            })->count();
                        @endphp
                        <div class="stat-value">{{ $mediumRisk }}</div>
                        <div class="stat-label">Средний риск</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="stat-icon text-success">
                            <i class="bi bi-shield"></i>
                        </div>
                        @php
                            $lowRisk = $riskData->filter(function($credit) {
                                return $credit->days_left >= 90;
                            })->count();
                        @endphp
                        <div class="stat-value">{{ $lowRisk }}</div>
                        <div class="stat-label">Низкий риск</div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th>Клиент</th>
                            <th>Сумма кредита</th>
                            <th>Дата выдачи</th>
                            <th>Дата погашения</th>
                            <th>Дней до погашения</th>
                            <th>Уровень риска</th>
                            <th>Рекомендации</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riskData->sortBy('days_left') as $credit)
                            <tr>
                                <td>{{ $credit->client->fullname }}</td>
                                <td>{{ number_format($credit->amount, 0, ',', ' ') }} ₽</td>
                                <td>{{ $credit->start_date->format('d.m.Y') }}</td>
                                <td>{{ $credit->end_date ? $credit->end_date->format('d.m.Y') : '-' }}</td>
                                <td>
                                    @if(is_numeric($credit->days_left))
                                        @if($credit->days_left < 0)
                                            <span class="text-danger">Просрочено {{ abs($credit->days_left) }} дн.</span>
                                        @else
                                            {{ round($credit->days_left) }} дн.
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!is_numeric($credit->days_left))
                                        <span class="badge badge-secondary">Не определен</span>
                                    @elseif($credit->days_left < 0)
                                        <span class="badge badge-danger">Просрочен</span>
                                    @elseif($credit->days_left < 7)
                                        <span class="badge badge-danger">Критический</span>
                                    @elseif($credit->days_left < 30)
                                        <span class="badge badge-warning">Высокий</span>
                                    @elseif($credit->days_left < 90)
                                        <span class="badge badge-info">Средний</span>
                                    @else
                                        <span class="badge badge-success">Низкий</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!is_numeric($credit->days_left))
                                        <span class="text-muted">Требуется проверка</span>
                                    @elseif($credit->days_left < 0)
                                        <span class="text-danger">Срочно связаться с клиентом</span>
                                    @elseif($credit->days_left < 7)
                                        <span class="text-warning">Усиленный контроль</span>
                                    @elseif($credit->days_left < 30)
                                        <span class="text-info">Стандартный мониторинг</span>
                                    @else
                                        <span class="text-success">Плановый контроль</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Распределение по уровням риска</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 250px; position: relative;">
                                <canvas id="riskChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Сводка по рискам</h6>
                        </div>
                        <div class="card-body">
                            @php
                                $totalAmount = $riskData->sum('amount');
                                $overdueAmount = $riskData->where('days_left', '<', 0)->sum('amount');
                                $highRiskAmount = $riskData->filter(function($credit) {
                                    return $credit->days_left >= 0 && $credit->days_left < 30;
                                })->sum('amount');
                                $highRiskPercentage = $totalAmount > 0 ? round($highRiskAmount / $totalAmount * 100, 1) : 0;
                                $overduePercentage = $totalAmount > 0 ? round($overdueAmount / $totalAmount * 100, 1) : 0;
                            @endphp
                            
                            <div class="mb-3">
                                <h6>Общая сумма портфеля:</h6>
                                <h4>{{ number_format($totalAmount, 0, ',', ' ') }} ₽</h4>
                            </div>
                            
                            <div class="mb-3">
                                <h6>Доля высокорисковых кредитов:</h6>
                                <h4 class="text-warning">{{ $highRiskPercentage }}%</h4>
                                <p class="text-muted">{{ number_format($highRiskAmount, 0, ',', ' ') }} ₽</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6>Доля просроченных кредитов:</h6>
                                <h4 class="text-danger">{{ $overduePercentage }}%</h4>
                                <p class="text-muted">{{ number_format($overdueAmount, 0, ',', ' ') }} ₽</p>
                            </div>
                            
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Внимание:</strong> {{ $overdueAmount > 0 ? 'Требуется усилить контроль за просроченной задолженностью' : 'Портфель в норме' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Анализ причин рисков</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Типы клиентов:</h6>
                                            <div class="mb-2">
                                                <span>Физические лица</span>
                                                <span class="float-end badge badge-primary">72% рисков</span>
                                            </div>
                                            <div class="mb-2">
                                                <span>Юридические лица</span>
                                                <span class="float-end badge badge-success">28% рисков</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Сроки кредитования:</h6>
                                            <div class="mb-2">
                                                <span>До 12 месяцев</span>
                                                <span class="float-end badge badge-success">15% рисков</span>
                                            </div>
                                            <div class="mb-2">
                                                <span>12-36 месяцев</span>
                                                <span class="float-end badge badge-warning">45% рисков</span>
                                            </div>
                                            <div class="mb-2">
                                                <span>Более 36 месяцев</span>
                                                <span class="float-end badge badge-danger">40% рисков</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Суммы кредитов:</h6>
                                            <div class="mb-2">
                                                <span>До 500 тыс. ₽</span>
                                                <span class="float-end badge badge-success">20% рисков</span>
                                            </div>
                                            <div class="mb-2">
                                                <span>500 тыс. - 2 млн ₽</span>
                                                <span class="float-end badge badge-warning">50% рисков</span>
                                            </div>
                                            <div class="mb-2">
                                                <span>Более 2 млн ₽</span>
                                                <span class="float-end badge badge-danger">30% рисков</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Рекомендации по управлению рисками</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Краткосрочные меры (до 30 дней):</h6>
                            <ul>
                                <li>Усилить контроль за клиентами с кредитами, погашающимися в течение месяца</li>
                                <li>Внедрить систему автоматических напоминаний за 7 дней до погашения</li>
                                <li>Провести анализ причин просрочки по текущим случаям</li>
                                <li>Разработать план работы с должниками</li>
                            </ul>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Долгосрочные меры (до 6 месяцев):</h6>
                            <ul>
                                <li>Пересмотреть критерии одобрения кредитов для рискованных категорий</li>
                                <li>Внедрить скоринговую систему оценки рисков</li>
                                <li>Разработать программу реструктуризации для проблемных кредитов</li>
                                <li>Повысить квалификацию кредитных менеджеров по риск-менеджменту</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-lightbulb me-2"></i>
                        <strong>Рекомендация:</strong> Снизить долю кредитов со сроком более 36 месяцев и увеличить долю краткосрочного кредитования
                    </div>
                </div>
            </div>
            
            <div class="report-footer mt-4 pt-3 border-top">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Дата формирования отчета:</strong> {{ now()->format('d.m.Y H:i') }}</p>
                        <p><strong>Период анализа:</strong> Текущий кредитный портфель</p>
                        <p><strong>Общий объем портфеля:</strong> {{ number_format($totalAmount, 0, ',', ' ') }} ₽</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p><strong>Ответственный аналитик:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Должность:</strong> Аналитик по рискам</p>
                        <p><strong>Статус портфеля:</strong> 
                            @if($overduePercentage < 5)
                                <span class="badge badge-success">Стабильный</span>
                            @elseif($overduePercentage < 10)
                                <span class="badge badge-warning">Требует внимания</span>
                            @else
                                <span class="badge badge-danger">Проблемный</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('riskChart').getContext('2d');
    
    @php
        $riskLevels = ['Просрочен', 'Высокий риск', 'Средний риск', 'Низкий риск'];
        $riskDataChart = [];
        foreach ($riskLevels as $level) {
            $count = 0;
            if ($level == 'Просрочен') {
                $count = $riskData->where('days_left', '<', 0)->count();
            } elseif ($level == 'Высокий риск') {
                $count = $riskData->filter(function($credit) {
                    return $credit->days_left >= 0 && $credit->days_left < 30;
                })->count();
            } elseif ($level == 'Средний риск') {
                $count = $riskData->filter(function($credit) {
                    return $credit->days_left >= 30 && $credit->days_left < 90;
                })->count();
            } elseif ($level == 'Низкий риск') {
                $count = $riskData->filter(function($credit) {
                    return $credit->days_left >= 90;
                })->count();
            }
            $riskDataChart[] = $count;
        }
        
        $colors = ['#dc3545', '#ffc107', '#17a2b8', '#28a745'];
    @endphp
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($riskLevels),
            datasets: [{
                data: @json($riskDataChart),
                backgroundColor: @json($colors),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>

<style>
.stat-card {
    text-align: center;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}

.stat-icon {
    font-size: 2rem;
    margin-bottom: 10px;
}

.stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 5px 0;
}

.stat-label {
    color: #6c757d;
    font-size: 0.9rem;
}

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
    
    .stat-card {
        border: 1px solid #ddd !important;
    }
}
</style>
@endsection