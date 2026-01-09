@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Редактирование профиля</h1>
        <a href="{{ route('client.profile') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i> Назад к профилю
        </a>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Основные данные</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Имя</label>
                                <input id="name" name="name" type="text" class="form-control" 
                                       value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input id="email" name="email" type="email" class="form-control" 
                                       value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="alert alert-warning">
                                <p class="mb-0">
                                    Ваш email не подтвержден.
                                    <button form="send-verification" class="btn btn-link p-0">
                                        Нажмите здесь, чтобы отправить подтверждение повторно.
                                    </button>
                                </p>
                            </div>
                        @endif

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                            @if (session('status') === 'profile-updated')
                                <div class="text-success mt-2">
                                    <i class="bi bi-check-circle me-1"></i> Изменения сохранены
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Обновление пароля</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label class="form-label">Текущий пароль</label>
                            <input id="current_password" name="current_password" type="password" 
                                   class="form-control" autocomplete="current-password">
                            @error('current_password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Новый пароль</label>
                            <input id="password" name="password" type="password" 
                                   class="form-control" autocomplete="new-password">
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Подтверждение пароля</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" 
                                   class="form-control" autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">Сменить пароль</button>
                            @if (session('status') === 'password-updated')
                                <div class="text-success mt-2">
                                    <i class="bi bi-check-circle me-1"></i> Пароль обновлен
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            
            @if(Auth::user()->client)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Данные клиента</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('client.profile.update') }}">
                            @csrf
                            @method('patch')
                            
                            <div class="mb-3">
                                <label class="form-label">Телефон</label>
                                <input type="tel" name="phone" class="form-control" 
                                       value="{{ old('phone', Auth::user()->client->phone) }}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Адрес</label>
                                <input type="text" name="address" class="form-control" 
                                       value="{{ old('address', Auth::user()->client->address) }}">
                            </div>
                            
                            <button type="submit" class="btn btn-success">Обновить данные клиента</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Удаление аккаунта</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        После удаления аккаунта все ваши данные будут безвозвратно удалены. 
                        Пожалуйста, скачайте свои данные перед удалением аккаунта.
                    </p>
                    
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-2"></i> Удалить аккаунт
                    </button>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Сессии</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        При необходимости вы можете выйти из других сессий на всех своих устройствах.
                    </p>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100 mb-2">
                            <i class="bi bi-box-arrow-right me-2"></i> Выйти на всех устройствах
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно удаления аккаунта -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Удаление аккаунта</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Вы уверены, что хотите удалить свой аккаунт?</p>
                <p class="text-danger">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Это действие нельзя отменить. Все ваши данные будут удалены.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Удалить аккаунт</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection