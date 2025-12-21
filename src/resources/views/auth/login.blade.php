@extends('layouts.guest')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h3>Кредитная система</h3>
        <p>Вход в систему</p>
    </div>
    
    <div class="auth-body">
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" 
                       value="{{ old('email') }}" required autofocus>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Запомнить меня</label>
            </div>
            
            <button type="submit" class="btn btn-auth mb-3">Войти</button>
            
            <div class="text-center">
                <a href="{{ route('password.request') }}" class="auth-link d-block mb-2">
                    Забыли пароль?
                </a>
                <a href="{{ route('register') }}" class="auth-link">
                    Регистрация
                </a>
            </div>
        </form>
    </div>
</div>
@endsection