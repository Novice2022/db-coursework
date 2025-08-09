@php

$user = auth()->user();
$roleId = $user -> role_id;

$role = '';
$contentViewName = '';

if ($roleId === 1) {
    $role = 'Клиент';
    $contentViewName = 'client';
} else if ($roleId === 2) {
    $role = 'Аналитик';
    $contentViewName = 'manager';
} else if ($roleId === 3) {
    $role = 'Менеджер';
    $contentViewName = 'analyst';
} else {
    $role = 'Администратор';
    $contentViewName = 'admin';
}

$client = $user -> client;

@endphp

<nav x-data="{ open: false }">
    <a
        class="company-name"
        href="{{ route($contentViewName, $user -> id) }}"
    >
        На доброе дело
    </a>
    <div class="right">
        @auth
            <button 
                @click="open = !open"
                class="navbar-toggler" 
                type="button" 
            >
                {{ $client -> fullname }}
            </button>
            <div class="dropdown" :class="{'show': open}">
                <a class="profile" href="{{ route('profile.edit') }}">
                    <button type="button">Профиль</button>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">Выйти</button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}">Вход</a>
            <a href="{{ route('register') }}">Регистрация</a>
        @endauth
    </div>
</nav>

<style>

    nav {
        padding: 0 10%;
        display: flex;
        justify-content: space-between;
        /* background-color: var(--primary-color); */
        background-color: rgb(0, 100, 255);
    }

    .company-name {
        padding: 20px;
        margin: -20px;
        align-self: center;
        font-weight: 900;
        font-size: 1.5rem;
    }

</style>
