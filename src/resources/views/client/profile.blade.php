@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Мой профиль</h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Личная информация</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="user-avatar mb-3" style="width: 100px; height: 100px; margin: 0 auto;">
                            <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
                        </div>
                        <h4>{{ $client->fullname }}</h4>
                        <p class="text-muted">
                            @if($client->entity_type_id == 1)
                                Физическое лицо
                            @else
                                Юридическое лицо
                            @endif
                        </p>
                    </div>
                    
                    <p><strong>ФИО:</strong> {{ $client->fullname }}</p>
                    @if($client->phone)
                        <p><strong>Телефон:</strong> {{ $client->phone }}</p>
                    @endif
                    @if($client->email)
                        <p><strong>Email:</strong> {{ $client->email }}</p>
                    @endif
                    @if($client->address)
                        <p><strong>Адрес:</strong> {{ $client->address }}</p>
                    @endif
                    <p><strong>Дата регистрации:</strong> {{ $client->registration_date }}</p>
                </div>
            </div>
            
            @if($client->individualEntity)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Информация о физическом лице</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Кредитная история:</strong> {{ $client->individualEntity->creditHistory->quality ?? 'Не указана' }}</p>
                        <p><strong>Ежемесячный доход:</strong> {{ number_format($client->individualEntity->income, 0, ',', ' ') }} ₽</p>
                    </div>
                </div>
            @endif
            
            @if($client->legalEntity)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Информация о юридическом лице</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Отрасль:</strong> {{ $client->legalEntity->industry->name ?? 'Не указана' }}</p>
                        <p><strong>Рентабельность:</strong> {{ $client->legalEntity->profitability->quality ?? 'Не указана' }}</p>
                        <p><strong>Сумма гарантии:</strong> {{ number_format($client->legalEntity->guarantee_amount, 0, ',', ' ') }} ₽</p>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Управление профилем</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-2"></i> Редактировать профиль
                        </a>
                        <a href="{{ route('client.credits.index') }}" class="btn btn-success">
                            <i class="bi bi-credit-card me-2"></i> Мои кредиты
                        </a>
                        <a href="{{ route('client.payments.index') }}" class="btn btn-warning">
                            <i class="bi bi-cash-stack me-2"></i> История платежей
                        </a>
                        <button class="btn btn-info">
                            <i class="bi bi-file-earmark-text me-2"></i> Скачать выписку
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Настройки аккаунта</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                            <i class="bi bi-person me-2"></i> Основные данные
                        </a>
                        <a href="#" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#passwordModal">
                            <i class="bi bi-key me-2"></i> Сменить пароль
                        </a>
                        <a href="#" class="btn btn-outline-info">
                            <i class="bi bi-bell me-2"></i> Настройки уведомлений
                        </a>
                        <a href="#" class="btn btn-outline-secondary">
                            <i class="bi bi-shield me-2"></i> Безопасность
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Статистика</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h3>{{ $client->credits->count() }}</h3>
                            <p class="text-muted">Всего кредитов</p>
                        </div>
                        <div class="col-md-3">
                            @php
                                $activeCredits = $client->credits->filter(function($credit) {
                                    return $credit->end_date && $credit->end_date > now();
                                });
                            @endphp
                            <h3 class="text-primary">{{ $activeCredits->count() }}</h3>
                            <p class="text-muted">Активных кредитов</p>
                        </div>
                        <div class="col-md-3">
                            @php
                                $totalAmount = $client->credits->sum('amount');
                            @endphp
                            <h3 class="text-success">{{ number_format($totalAmount, 0, ',', ' ') }} ₽</h3>
                            <p class="text-muted">Общая сумма кредитов</p>
                        </div>
                        <div class="col-md-3">
                            @php
                                $totalPaid = 0;
                                foreach($client->credits as $credit) {
                                    $totalPaid += $credit->payments->sum('amount');
                                }
                            @endphp
                            <h3 class="text-info">{{ number_format($totalPaid, 0, ',', ' ') }} ₽</h3>
                            <p class="text-muted">Всего оплачено</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для смены пароля -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Смена пароля</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Для смены пароля перейдите в <a href="{{ route('profile.edit') }}">настройки профиля</a>.</p>
                <p>Или воспользуйтесь формой ниже:</p>
                
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    
                    <div class="mb-3">
                        <label class="form-label">Текущий пароль</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Новый пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Подтверждение пароля</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Сменить пароль</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection