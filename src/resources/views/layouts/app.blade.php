<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Кредитная система') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            padding-top: 56px;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            height: calc(100vh - 56px);
            position: fixed;
            top: 56px;
            left: 0;
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .navbar-brand {
            font-weight: bold;
        }
        
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 10px 20px;
        }
        
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #495057;
        }
        
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #007bff;
        }
        
        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .stats-card {
            transition: transform 0.2s;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .badge {
            font-size: 0.8em;
            padding: 5px 10px;
        }
        
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Кредитная система</a>
            
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Профиль</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Выйти</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar d-none d-lg-block">
        <nav class="nav flex-column">
            @if(auth()->user()->isClient())
                <a class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}" 
                href="{{ route('client.dashboard') }}">Мой кабинет</a>
                <a class="nav-link {{ request()->routeIs('client.credits*') ? 'active' : '' }}" 
                href="{{ route('client.credits') }}">Мои кредиты</a>
                <a class="nav-link {{ request()->routeIs('client.credits.create') ? 'active' : '' }}" 
                href="{{ route('client.credits.create') }}">Оформить кредит</a>
            @endif
            
            @if(auth()->user()->isManager())
                <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}" 
                   href="{{ route('manager.dashboard') }}">Панель управления</a>
                <a class="nav-link {{ request()->routeIs('manager.clients') ? 'active' : '' }}" 
                   href="{{ route('manager.clients') }}">Клиенты</a>
                <a class="nav-link {{ request()->routeIs('manager.credits') ? 'active' : '' }}" 
                   href="{{ route('manager.credits') }}">Кредиты</a>
                <a class="nav-link {{ request()->routeIs('manager.analytics') ? 'active' : '' }}" 
                   href="{{ route('manager.analytics') }}">Аналитика</a>
            @endif
            
            @if(auth()->user()->isAnalyst())
                <a class="nav-link {{ request()->routeIs('analyst.dashboard') ? 'active' : '' }}" 
                   href="{{ route('analyst.dashboard') }}">Панель аналитика</a>
                <a class="nav-link {{ request()->routeIs('analyst.risk-assessment') ? 'active' : '' }}" 
                   href="{{ route('analyst.risk-assessment') }}">Оценка рисков</a>
                <a class="nav-link {{ request()->routeIs('analyst.overdue-credits') ? 'active' : '' }}" 
                   href="{{ route('analyst.overdue-credits') }}">Просрочки</a>
            @endif
            
            @if(auth()->user()->isAdmin())
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">Панель администратора</a>
                <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" 
                   href="{{ route('admin.users') }}">Пользователи</a>
                <a class="nav-link {{ request()->routeIs('admin.credit-types') ? 'active' : '' }}" 
                   href="{{ route('admin.credit-types') }}">Типы кредитов</a>
                <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" 
                   href="{{ route('admin.settings') }}">Настройки</a>
            @endif
            
            @if(auth()->user()->role_id > 1)
                <hr>
                <a class="nav-link {{ request()->routeIs('reports.generate') ? 'active' : '' }}" 
                   href="{{ route('reports.generate') }}">Отчеты</a>
            @endif
        </nav>
    </div>

    <main class="main-content">
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
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>