@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Настройки системы</h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Основные настройки</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Название банка</label>
                            <input type="text" class="form-control" value="Кредитная система банка">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Валюта системы</label>
                            <select class="form-select">
                                <option selected>Российский рубль (₽)</option>
                                <option>Доллар США ($)</option>
                                <option>Евро (€)</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Язык интерфейса</label>
                            <select class="form-select">
                                <option selected>Русский</option>
                                <option>Английский</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Часовой пояс</label>
                            <select class="form-select">
                                <option selected>Москва (UTC+3)</option>
                                <option>Калининград (UTC+2)</option>
                                <option>Екатеринбург (UTC+5)</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Настройки безопасности</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="twoFactor" checked>
                            <label class="form-check-label" for="twoFactor">Двухфакторная аутентификация</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="passwordHistory" checked>
                            <label class="form-check-label" for="passwordHistory">Запрет повторного использования паролей</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="sessionTimeout" checked>
                            <label class="form-check-label" for="sessionTimeout">Автоматический выход через 30 минут</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Минимальная длина пароля</label>
                        <input type="number" class="form-control" value="8" min="6" max="20">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Максимальное количество попыток входа</label>
                        <input type="number" class="form-control" value="5" min="1" max="10">
                    </div>
                    
                    <button type="button" class="btn btn-success">Применить настройки</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Настройки уведомлений</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                            <label class="form-check-label" for="emailNotifications">Email уведомления</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="smsNotifications">
                            <label class="form-check-label" for="smsNotifications">SMS уведомления</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="creditExpiry" checked>
                            <label class="form-check-label" for="creditExpiry">Уведомления о сроке погашения</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="newClient" checked>
                            <label class="form-check-label" for="newClient">Уведомления о новых клиентах</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="overdueCredits" checked>
                            <label class="form-check-label" for="overdueCredits">Уведомления о просрочках</label>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6>Получатели отчетов:</h6>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Email для ежедневных отчетов">
                    </div>
                    
                    <div class="mb-3">
                        <select class="form-select">
                            <option selected>Ежедневно</option>
                            <option>Еженедельно</option>
                            <option>Ежемесячно</option>
                        </select>
                    </div>
                    
                    <button type="button" class="btn btn-info">Сохранить настройки</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Системные операции</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-database me-2"></i> Создать резервную копию
                    </button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-success w-100 mb-2">
                        <i class="bi bi-arrow-clockwise me-2"></i> Очистить кеш
                    </button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-warning w-100 mb-2">
                        <i class="bi bi-file-earmark-text me-2"></i> Логи системы
                    </button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-danger w-100 mb-2">
                        <i class="bi bi-exclamation-triangle me-2"></i> Экстренная остановка
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection