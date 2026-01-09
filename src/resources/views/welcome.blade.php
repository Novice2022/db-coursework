<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Кредитная система банка') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero-section {
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        
        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .hero-section p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto 30px;
        }
        
        .btn-hero {
            background: white;
            color: #667eea;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: transform 0.3s;
            margin: 10px;
        }
        
        .btn-hero:hover {
            transform: translateY(-5px);
            color: #667eea;
        }
        
        .features-section {
            background: white;
            padding: 80px 0;
            border-radius: 30px 30px 0 0;
            margin-top: -30px;
        }
        
        .feature-card {
            text-align: center;
            padding: 30px;
            border-radius: 15px;
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 20px;
        }
        
        footer {
            background: #1a1a2e;
            color: white;
            padding: 40px 0;
            text-align: center;
        }
        
        .role-cards {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin: 40px 0;
        }
        
        .role-card {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 30px;
            width: 250px;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        
        .role-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <h1>Кредитная система банка</h1>
            <p>Профессиональная платформа для управления кредитными операциями коммерческого банка</p>
            
            <div class="role-cards">
                <div class="role-card">
                    <div class="role-icon text-primary">
                        <i class="bi bi-person"></i>
                    </div>
                    <h5>Клиенты</h5>
                    <p>Физические и юридические лица</p>
                </div>
                
                <div class="role-card">
                    <div class="role-icon text-success">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <h5>Менеджеры</h5>
                    <p>Управление кредитами и клиентами</p>
                </div>
                
                <div class="role-card">
                    <div class="role-icon text-warning">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h5>Аналитики</h5>
                    <p>Риск-анализ и отчетность</p>
                </div>
                
                <div class="role-card">
                    <div class="role-icon text-danger">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5>Администраторы</h5>
                    <p>Управление системой</p>
                </div>
            </div>
            
            @if(Auth::check())
                <a href="{{ route('dashboard') }}" class="btn btn-hero">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Перейти в систему
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-hero">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Войти в систему
                </a>
                <a href="{{ route('register') }}" class="btn btn-hero" style="background: transparent; border: 2px solid white;">
                    <i class="bi bi-person-plus me-2"></i> Регистрация
                </a>
            @endif
        </div>
    </div>
    
    <div class="features-section">
        <div class="container">
            <h2 class="text-center mb-5">Возможности системы</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h4>Управление кредитами</h4>
                        <p>Полный цикл работы с кредитными операциями от оформления до погашения</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4>Безопасность</h4>
                        <p>Многоуровневая система защиты данных и разграничение прав доступа</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h4>Аналитика</h4>
                        <p>Детальная аналитика кредитного портфеля и риск-менеджмент</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Кредитная система банка. Все права защищены.</p>
            <p class="text-muted">Версия 1.0.0</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>