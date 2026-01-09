<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Кредитная система') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
            position: fixed;
            width: 250px;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            text-decoration: none;
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background: white;
            border-bottom: 2px solid #f0f0f0;
            font-weight: 600;
            padding: 20px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .stat-card {
            text-align: center;
            padding: 25px 15px;
        }
        
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin: 10px 0;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .badge-primary { background-color: #667eea; }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-danger { background-color: #dc3545; }
        
        .user-profile {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        
        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2rem;
        }
        
        .logout-btn {
            color: white;
            background: rgba(255,255,255,0.1);
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            margin-top: 15px;
            width: 100%;
        }
        
        .logout-btn:hover {
            background: rgba(255,255,255,0.2);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="user-profile">
            <div class="user-avatar">
                <i class="bi bi-person-circle"></i>
            </div>
            <h5>{{ Auth::user()->name }}</h5>
            <p class="text-muted mb-2">{{ Auth::user()->getRoleName() }}</p>
            @if(Auth::user()->client)
                <p class="small mb-3">
                    @if(Auth::user()->client->entity_type_id == 1)
                        Физическое лицо
                    @else
                        Юридическое лицо
                    @endif
                </p>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Выйти
                </button>
            </form>
        </div>
        
        <nav class="nav flex-column">
            @if(Auth::user()->isClient())
                <a class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}" 
                   href="{{ route('client.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Панель клиента
                </a>
                <a class="nav-link {{ request()->routeIs('client.credits.*') ? 'active' : '' }}" 
                   href="{{ route('client.credits.index') }}">
                    <i class="bi bi-credit-card"></i> Мои кредиты
                </a>
                <a class="nav-link {{ request()->routeIs('client.payments.*') ? 'active' : '' }}" 
                   href="{{ route('client.payments.index') }}">
                    <i class="bi bi-cash-stack"></i> Платежи
                </a>
                <a class="nav-link {{ request()->routeIs('client.profile') ? 'active' : '' }}" 
                   href="{{ route('client.profile') }}">
                    <i class="bi bi-person"></i> Профиль
                </a>
            @endif
            
            @if(Auth::user()->isManager())
                <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}" 
                   href="{{ route('manager.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Панель менеджера
                </a>
                <a class="nav-link {{ request()->routeIs('manager.clients.*') ? 'active' : '' }}" 
                   href="{{ route('manager.clients.index') }}">
                    <i class="bi bi-people"></i> Клиенты
                </a>
                <a class="nav-link {{ request()->routeIs('manager.credits.*') ? 'active' : '' }}" 
                   href="{{ route('manager.credits.index') }}">
                    <i class="bi bi-credit-card"></i> Кредиты
                </a>
                <a class="nav-link {{ request()->routeIs('manager.reports.*') ? 'active' : '' }}" 
                   href="{{ route('manager.reports.index') }}">
                    <i class="bi bi-file-earmark-text"></i> Отчеты
                </a>
            @endif
            
            @if(Auth::user()->isAnalyst())
                <a class="nav-link {{ request()->routeIs('analyst.dashboard') ? 'active' : '' }}" 
                   href="{{ route('analyst.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Панель аналитика
                </a>
                <a class="nav-link {{ request()->routeIs('analyst.risk.*') ? 'active' : '' }}" 
                   href="{{ route('analyst.risk.index') }}">
                    <i class="bi bi-shield-exclamation"></i> Риск-анализ
                </a>
                <a class="nav-link {{ request()->routeIs('analyst.reports.*') ? 'active' : '' }}" 
                   href="{{ route('analyst.reports.index') }}">
                    <i class="bi bi-file-earmark-bar-graph"></i> Финансовая аналитика
                </a>
                <a class="nav-link {{ request()->routeIs('analyst.export') ? 'active' : '' }}" 
                   href="{{ route('analyst.export') }}">
                    <i class="bi bi-download"></i> Экспорт данных
                </a>
            @endif
            
            @if(Auth::user()->isAdmin())
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Панель администратора
                </a>
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                   href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people-fill"></i> Пользователи
                </a>
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" 
                   href="{{ route('admin.settings.index') }}">
                    <i class="bi bi-gear"></i> Настройки системы
                </a>
                <a class="nav-link {{ request()->routeIs('admin.audit.*') ? 'active' : '' }}" 
                   href="{{ route('admin.audit.index') }}">
                    <i class="bi bi-clock-history"></i> История действий
                </a>
            @endif
        </nav>
    </div>

    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>