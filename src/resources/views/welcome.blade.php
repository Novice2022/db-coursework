<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Кредитная система</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            :root {
                --primary-color: #0d6efd;
                --primary-hover: #0b5ed7;
                --text-color: #1b1b18;
                --light-bg: #F8F9FA;
                --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            }
            
            body {
                background-color: var(--light-bg);
                color: var(--text-color);
                font-family: 'Instrument Sans', sans-serif;
            }
            
            .hero-section {
                padding: 80px 0;
            }
            
            .feature-card {
                border: none;
                border-radius: 16px;
                transition: transform 0.3s, box-shadow 0.3s;
                height: 100%;
            }
            
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: var(--card-shadow);
            }
            
            .feature-icon {
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                margin-bottom: 20px;
                color: white;
                font-size: 24px;
            }
            
            .btn-outline-primary {
                border-color: var(--primary-color);
                color: var(--primary-color);
            }
            
            .btn-outline-primary:hover {
                background-color: var(--primary-color);
                color: white;
            }
            
            .nav-link {
                color: var(--text-color);
                padding: 8px 16px;
                border-radius: 8px;
                transition: all 0.3s;
            }
            
            .nav-link:hover {
                background-color: rgba(13, 110, 253, 0.1);
            }
            
            .btn-primary {
                background-color: var(--primary-color);
                border: none;
                padding: 10px 24px;
                border-radius: 8px;
                font-weight: 500;
            }
            
            .btn-primary:hover {
                background-color: var(--primary-hover);
            }
        </style>
    </head>
    <body>
        <header class="py-4">
            <div class="container">
                <nav class="d-flex justify-content-between align-items-center">
                    <div class="brand-logo">
                        <h3 class="mb-0 fw-bold">Кредитная система</h3>
                    </div>
                    
                    @if (Route::has('login'))
                        <div class="d-flex gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary">
                                    Личный кабинет
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                    Вход
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-primary">
                                        Регистрация
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </nav>
            </div>
        </header>

        <main>
            <section class="hero-section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-5 mb-lg-0">
                            <h1 class="display-4 fw-bold mb-4">Удобная система кредитования</h1>
                            <p class="lead mb-4">Получайте кредиты быстро и просто. Управляйте финансами в одном месте.</p>
                            <div class="d-flex gap-3">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg px-4">
                                        Перейти в кабинет
                                    </a>
                                @else
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">
                                        Начать сейчас
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-5 my-5">
                <div class="container">
                    <h2 class="text-center mb-5">Наши преимущества</h2>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card feature-card p-4">
                                <div class="feature-icon bg-primary">
                                    <i class="bi bi-speedometer2"></i>
                                </div>
                                <h3>Быстро</h3>
                                <p>Оформление кредита занимает всего несколько минут</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card feature-card p-4">
                                <div class="feature-icon bg-success">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <h3>Надежно</h3>
                                <p>Ваши данные защищены современными технологиями</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card feature-card p-4">
                                <div class="feature-icon bg-info">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                                <h3>Выгодно</h3>
                                <p>Гибкие условия и низкие процентные ставки</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="py-5 bg-white mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Кредитная система</h5>
                        <p class="text-muted">© 2025 Все права защищены</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="#" class="text-decoration-none text-muted me-3">Политика конфиденциальности</a>
                        <a href="#" class="text-decoration-none text-muted">Условия использования</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    </body>
</html>
