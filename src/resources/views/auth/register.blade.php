@extends('layouts.guest')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h3>Кредитная система</h3>
        <p>Регистрация</p>
    </div>
    
    <div class="auth-body">
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">ФИО</label>
                <input type="text" name="name" class="form-control" 
                       value="{{ old('name') }}" required autofocus>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" 
                       value="{{ old('email') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Роль</label>
                <select name="role" id="roleSelect" class="form-select" required>
                    <option value="">Выберите роль</option>
                    <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Клиент</option>
                    <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Менеджер</option>
                    <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>Аналитик</option>
                    <option value="4" {{ old('role') == '4' ? 'selected' : '' }}>Администратор</option>
                </select>
            </div>
            
            <!-- Поля для клиентов -->
            <div id="clientFields" style="display: none;">
                <div class="mb-3">
                    <label class="form-label">Тип клиента</label>
                    <select name="entity_type" class="form-select">
                        <option value="">Выберите тип</option>
                        <option value="individual" {{ old('entity_type') == 'individual' ? 'selected' : '' }}>Физическое лицо</option>
                        <option value="legal" {{ old('entity_type') == 'legal' ? 'selected' : '' }}>Юридическое лицо</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Телефон</label>
                    <input type="tel" name="phone" class="form-control" 
                           value="{{ old('phone') }}" placeholder="+7 (999) 999-99-99">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Адрес</label>
                    <input type="text" name="address" class="form-control" 
                           value="{{ old('address') }}" placeholder="Город, улица, дом, квартира">
                </div>
            </div>
            
            <button type="submit" class="btn btn-auth mb-3">Зарегистрироваться</button>
            
            <div class="text-center">
                <a href="{{ route('login') }}" class="auth-link">
                    Уже есть аккаунт? Войти
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('roleSelect');
    const clientFields = document.getElementById('clientFields');
    
    function toggleClientFields() {
        if (roleSelect.value === '1') {
            clientFields.style.display = 'block';
        } else {
            clientFields.style.display = 'none';
        }
    }
    
    roleSelect.addEventListener('change', toggleClientFields);
    
    // Инициализация при загрузке
    toggleClientFields();
});
</script>
@endsection