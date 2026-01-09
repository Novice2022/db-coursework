@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">История действий</h1>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Логи системы</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Дата и время</th>
                            <th>Пользователь</th>
                            <th>Действие</th>
                            <th>Объект</th>
                            <th>IP адрес</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ now()->format('d.m.Y H:i') }}</td>
                            <td>{{ Auth::user()->name }}</td>
                            <td>Просмотр истории действий</td>
                            <td>Система аудита</td>
                            <td>127.0.0.1</td>
                            <td><span class="badge badge-success">Успешно</span></td>
                        </tr>
                        <tr>
                            <td>{{ now()->subMinutes(30)->format('d.m.Y H:i') }}</td>
                            <td>Менеджер Иванов</td>
                            <td>Создание нового кредита</td>
                            <td>Кредит #789456</td>
                            <td>192.168.1.100</td>
                            <td><span class="badge badge-success">Успешно</span></td>
                        </tr>
                        <tr>
                            <td>{{ now()->subHours(2)->format('d.m.Y H:i') }}</td>
                            <td>Клиент Петров</td>
                            <td>Оплата по кредиту</td>
                            <td>Платеж #123456</td>
                            <td>10.0.0.15</td>
                            <td><span class="badge badge-success">Успешно</span></td>
                        </tr>
                        <tr>
                            <td>{{ now()->subHours(5)->format('d.m.Y H:i') }}</td>
                            <td>Аналитик Сидоров</td>
                            <td>Экспорт отчета</td>
                            <td>Отчет по рискам</td>
                            <td>192.168.1.50</td>
                            <td><span class="badge badge-success">Успешно</span></td>
                        </tr>
                        <tr>
                            <td>{{ now()->subDays(1)->format('d.m.Y H:i') }}</td>
                            <td>Менеджер Иванов</td>
                            <td>Попытка доступа к запрещенному разделу</td>
                            <td>Панель аналитика</td>
                            <td>192.168.1.100</td>
                            <td><span class="badge badge-danger">Отказано</span></td>
                        </tr>
                        <tr>
                            <td>{{ now()->subDays(2)->format('d.m.Y H:i') }}</td>
                            <td>Администратор</td>
                            <td>Изменение настроек системы</td>
                            <td>Настройки безопасности</td>
                            <td>127.0.0.1</td>
                            <td><span class="badge badge-success">Успешно</span></td>
                        </tr>
                        <tr>
                            <td>{{ now()->subDays(3)->format('d.m.Y H:i') }}</td>
                            <td>Новый клиент</td>
                            <td>Регистрация в системе</td>
                            <td>Клиент #987654</td>
                            <td>10.0.0.25</td>
                            <td><span class="badge badge-success">Успешно</span></td>
                        </tr>
                        <tr>
                            <td>{{ now()->subDays(5)->format('d.m.Y H:i') }}</td>
                            <td>Крон-задача</td>
                            <td>Автоматическое резервное копирование</td>
                            <td>База данных</td>
                            <td>Система</td>
                            <td><span class="badge badge-success">Успешно</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Статистика действий</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <h4>156</h4>
                                    <p class="text-muted">За сегодня</p>
                                </div>
                                <div class="col-4">
                                    <h4>1,245</h4>
                                    <p class="text-muted">За неделю</p>
                                </div>
                                <div class="col-4">
                                    <h4>5,678</h4>
                                    <p class="text-muted">За месяц</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Фильтры и поиск</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Период</label>
                                <select class="form-select">
                                    <option selected>За последние 7 дней</option>
                                    <option>За сегодня</option>
                                    <option>За последний месяц</option>
                                    <option>За последний год</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Тип действия</label>
                                <select class="form-select">
                                    <option selected>Все действия</option>
                                    <option>Авторизация</option>
                                    <option>Операции с кредитами</option>
                                    <option>Работа с клиентами</option>
                                    <option>Системные операции</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Статус</label>
                                <select class="form-select">
                                    <option selected>Все статусы</option>
                                    <option>Успешно</option>
                                    <option>Ошибка</option>
                                    <option>Отказано</option>
                                </select>
                            </div>
                            
                            <button class="btn btn-primary w-100">
                                <i class="bi bi-filter me-2"></i> Применить фильтры
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection