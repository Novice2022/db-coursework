<nav x-data="{ open: false }" class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <!-- Логотип -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <span class="fw-bold text-primary">Кредитная система</span>
        </a>

        <!-- Кнопка для мобильного меню -->
        <button 
            @click="open = !open"
            class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            aria-expanded="false" 
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Основное меню -->
        <div class="collapse navbar-collapse justify-content-end" :class="{'show': open}">
            <!-- Правая часть меню -->
            <div class="d-flex align-items-center">
                @auth
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="me-2 d-none d-sm-block">
                                <div class="fw-bold text-end">{{ Auth::user()->name }}</div>
                                <div class="small text-muted text-end">
                                    @if(auth()->user()->role_id == 1)
                                        Клиент
                                    @elseif(auth()->user()->role_id == 2)
                                        Аналитик
                                    @elseif(auth()->user()->role_id == 3)
                                        Менеджер
                                    @elseif(auth()->user()->role_id == 4)
                                        Администратор
                                    @endif
                                </div>
                            </div>
                            <div class="avatar avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i> Профиль
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i> Выйти
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Вход</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Регистрация</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    .navbar {
        padding: 0.75rem 1rem;
    }
    
    .nav-link {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        transition: all 0.2s;
    }
    
    .nav-link:hover, .nav-link.active {
        background-color: rgba(13, 110, 253, 0.1);
        color: var(--bs-primary);
    }
    
    .avatar {
        width: 36px;
        height: 36px;
        font-weight: 600;
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
        padding: 0.5rem;
    }
    
    .dropdown-item {
        border-radius: 0.375rem;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
    }
    
    .dropdown-item:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
