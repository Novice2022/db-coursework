@extends('layouts.guest')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h3>Кредитная система</h3>
        <p>Подтверждение email</p>
    </div>
    
    <div class="auth-body">
        <div class="mb-4 text-center">
            <i class="bi bi-envelope-check" style="font-size: 3rem; color: #667eea;"></i>
        </div>
        
        <div class="mb-4">
            <p>Спасибо за регистрацию! Прежде чем начать, подтвердите свой адрес электронной почты, перейдя по ссылке в письме, которое мы только что отправили вам.</p>
            
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    На ваш email отправлена новая ссылка для подтверждения.
                </div>
            @endif
        </div>
        
        <div class="d-grid gap-2">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-auth w-100">
                    <i class="bi bi-envelope-arrow-up me-2"></i> Отправить ссылку повторно
                </button>
            </form>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-left me-2"></i> Выйти
                </button>
            </form>
        </div>
    </div>
</div>
@endsection