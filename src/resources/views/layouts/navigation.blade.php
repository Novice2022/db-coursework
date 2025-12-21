@php
    $user = auth()->user();
    $client = $user ? $user->client : null;
@endphp

<nav class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Логотип -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <x-application-logo class="h-8 w-auto" />
                    <span class="font-bold text-xl text-gray-800">Кредитная система</span>
                </a>
            </div>

            <!-- Правая часть -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Навигация по ролям -->
                    @if($user->isManager() || $user->isAdmin())
                        <a href="{{ route('manager.dashboard') }}" 
                           class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Панель управления
                        </a>
                    @endif
                    
                    @if($user->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Администрирование
                        </a>
                    @endif

                    <!-- Выпадающее меню пользователя -->
                    <div class="relative ml-3" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">Открыть меню пользователя</span>
                            <div class="flex items-center space-x-3">
                                <x-role-badge :roleId="$user->role_id" />
                                <span class="text-gray-700 font-medium">
                                    {{ $client ? $client->fullname : $user->name }}
                                </span>
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>

                        <!-- Выпадающее меню -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                            
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Профиль
                            </a>
                            
                            @if($user->isClient())
                                <a href="{{ route('client.dashboard') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Мои кредиты
                                </a>
                            @endif
                            
                            <!-- Разделитель -->
                            <div class="border-t my-1"></div>
                            
                            <!-- Форма выхода -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Выйти
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Вход
                    </a>
                    
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="bg-indigo-600 text-white hover:bg-indigo-700 px-4 py-2 rounded-md text-sm font-medium">
                            Регистрация
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    [x-cloak] { display: none; }
</style>