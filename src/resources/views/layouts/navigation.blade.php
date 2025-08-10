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

<nav>
    <a
        class="company-name"
        href="{{ route($contentViewName, $user -> id) }}"
    >
        На доброе дело
    </a>
    <div class="header-nav-right">
        @auth
            <div id="dropleft" style="display: none">
                <a href="{{ route('profile.edit') }}">
                    <button class="profile" type="button">Профиль</button>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout" type="submit">Выйти</button>
                </form>
            </div>
            <button 
                onclick="toggleDropleft(event)"
                class="dropleft-toggler" 
                type="button" 
            >
                {{ $client -> fullname }}
            </button>
        @else
            <a href="{{ route('login') }}">Вход</a>
            <a href="{{ route('register') }}">Регистрация</a>
        @endauth
    </div>
</nav>

<style>

    nav {
        padding: 15px 10%;
        display: flex;
        justify-content: space-between;
        background-color: rgb(0, 100, 255);  /* var(--primary-color); */
        align-items: center
    }

    .company-name {
        padding: 20px;
        margin: -20px;
        align-self: center;
        font-weight: 900;
        font-size: 1.5rem;
        color: white;
    }

    .header-nav-right {
        display: flex;
    }

    .header-nav-right button {
        cursor: pointer;
        font-weight: 700;
    }

    .header-nav-right button:hover {
        text-decoration: underline;
    }

    .dropleft-toggler {
        padding: 10px 20px;
        border: 2px solid white;
        border-radius: 15px;
        background-color: white;
        color: rgb(0, 100, 255);  /* var(--primary-color); */
        font-size: .9rem;
        transition: none !important;
    }

    .dropleft-toggler:hover {
        text-decoration: underline;
    }

    #dropleft {
        background-color: white;
        border-radius: 15px 0 0 15px;
        border-right: 2px solid rgb(0, 100, 255);  /* var(--primary-color); */
        align-items: center;
        padding: 0 10px;
    }

    #dropleft button {
        width: 100%;
        padding: 10px;
        border: none;
        background-color: transparent;
        font-size: .8rem;
    }
    
    #dropleft .profile {
        color: rgb(0, 100, 255);  /* var(--primary-color); */
    }

    #dropleft .logout {
        color: rgb(255, 72, 72);
    }

</style>

<script>

    const dropleftElement = document.getElementById('dropleft');
    let showDropleft = false;

    const toggleDropleft = (event) => {
        const target = event.target;

        showDropleft = !showDropleft;

        if (showDropleft) {
            target.style.borderRadius = '0 15px 15px 0';
            dropleftElement.style.display = 'flex';
        } else {
            target.style.borderRadius = '15px';
            dropleftElement.style.display = 'none';
        }
    }

</script>
