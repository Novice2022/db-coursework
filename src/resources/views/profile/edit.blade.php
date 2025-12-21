@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Профиль пользователя</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Информация профиля</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label class="form-label">ФИО</label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" 
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="alert alert-warning">
                                <p class="mb-1">Ваш email не подтвержден.</p>
                                <form method="post" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 text-decoration-underline">
                                        Нажмите для отправки подтверждения
                                    </button>
                                </form>
                                @if (session('status') === 'verification-link-sent')
                                    <p class="text-success small mt-2">
                                        Новая ссылка отправлена на ваш email
                                    </p>
                                @endif
                            </div>
                        @endif

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                Сохранить изменения
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Смена пароля</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label class="form-label">Текущий пароль</label>
                            <input type="password" name="current_password" class="form-control" required>
                            @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Новый пароль</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Подтвердите новый пароль</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success">
                                Пароль успешно изменен
                            </div>
                        @endif

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                Изменить пароль
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Удаление аккаунта</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <p class="mb-3">
                            После удаления аккаунта все ваши данные будут безвозвратно удалены. 
                            Пожалуйста, сохраните важную информацию перед удалением.
                        </p>
                        
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            Удалить аккаунт
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно удаления аккаунта -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Подтвердите удаление аккаунта</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="modal-body">
                    <p>Для подтверждения удаления аккаунта введите ваш пароль.</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-danger">Удалить аккаунт</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
        modal.show();
    });
</script>
@endif
@endsection