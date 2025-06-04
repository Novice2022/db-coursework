<x-guest-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Регистрация</h2>
                        
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <!-- Скрытое поле для роли -->
                            <input type="hidden" name="role" id="selected_role" value="client">
                            
                            <!-- Блок выбора роли -->
                            <div class="mb-4">
                                <label class="form-label mb-3">Выберите тип аккаунта:</label>
                                <div class="d-flex gap-3 flex-wrap">
                                    <!-- Клиент -->
                                    <div class="role-card flex-grow-1" data-role="1" onclick="selectRole(this)">
                                        <div class="card h-100 cursor-pointer hover-shadow">
                                            <div class="card-body text-center p-3">
                                                <div class="icon-wrapper bg-primary bg-opacity-10 p-3 rounded-circle mb-2 mx-auto">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                                <h6 class="mb-1">Клиент</h6>
                                                <small class="text-muted">Для получения кредитов</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Менеджер -->
                                    <div class="role-card flex-grow-1" data-role="3" onclick="selectRole(this)">
                                        <div class="card h-100 cursor-pointer hover-shadow">
                                            <div class="card-body text-center p-3">
                                                <div class="icon-wrapper bg-success bg-opacity-10 p-3 rounded-circle mb-2 mx-auto">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <h6 class="mb-1">Менеджер</h6>
                                                <small class="text-muted">Для сотрудников банка</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Аналитик -->
                                    <div class="role-card flex-grow-1" data-role="2" onclick="selectRole(this)">
                                        <div class="card h-100 cursor-pointer hover-shadow">
                                            <div class="card-body text-center p-3">
                                                <div class="icon-wrapper bg-info bg-opacity-10 p-3 rounded-circle mb-2 mx-auto">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                    </svg>
                                                </div>
                                                <h6 class="mb-1">Аналитик</h6>
                                                <small class="text-muted">Для оценки рисков</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Дополнительные поля для клиента -->
                            <div id="client_fields">
                                <div class="mb-3">
                                    <x-input-label for="entity_type" value="Тип клиента" />
                                    <select id="entity_type" name="entity_type" class="form-select">
                                        <option value="" disabled selected>Выберите тип</option>
                                        <option value="individual">Физическое лицо</option>
                                        <option value="legal">Юридическое лицо</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <x-input-label for="phone" value="Телефон" />
                                    <x-text-input id="phone" class="form-control" type="tel" name="phone" placeholder="+7 (XXX) XXX-XX-XX" />
                                </div>
                                
                                <div class="mb-3">
                                    <x-input-label for="address" value="Адрес" />
                                    <x-text-input id="address" class="form-control" type="text" name="address" placeholder="Город, улица, дом, квартира" />
                                </div>
                            </div>
                            
                            <!-- Общие поля для всех -->
                            <div class="mb-3">
                                <x-input-label for="name" value="ФИО" />
                                <x-text-input id="name" class="form-control" type="text" name="name" required autofocus />
                            </div>
                            
                            <div class="mb-3">
                                <x-input-label for="email" value="Email" />
                                <x-text-input id="email" class="form-control" type="email" name="email" required />
                            </div>
                            
                            <div class="mb-3">
                                <x-input-label for="password" value="Пароль" />
                                <x-text-input id="password" class="form-control" type="password" name="password" required />
                            </div>
                            
                            <div class="mb-4">
                                <x-input-label for="password_confirmation" value="Подтверждение пароля" />
                                <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required />
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <a class="text-sm text-muted text-decoration-underline" href="{{ route('login') }}">
                                    Уже зарегистрированы?
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    Зарегистрироваться
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @push('styles') --}}
    <style>
        .role-card .card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .role-card.active .card {
            border-color: var(--bs-primary);
            background-color: rgba(var(--bs-primary-rgb), 0.05);
        }
        .role-card .icon-wrapper {
            transition: all 0.3s ease;
        }
        .role-card.active .icon-wrapper {
            background-color: var(--bs-primary) !important;
        }
        .role-card.active .icon-wrapper svg {
            stroke: white;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
    </style>
    {{-- @endpush --}}

    {{-- @push('scripts') --}}
    <script>
        function selectRole(element) {
            // Убираем активный класс у всех карточек
            document.querySelectorAll('.role-card').forEach(card => {
                card.classList.remove('active');
            });
            
            // Добавляем активный класс выбранной карточке
            element.classList.add('active');
            
            // Устанавливаем значение скрытого поля
            const role = element.getAttribute('data-role');
            document.getElementById('selected_role').value = role;
            
            // Показываем/скрываем дополнительные поля
            const clientFields = document.getElementById('client_fields');
            clientFields.style.display = role === '1' ? 'block' : 'none';
        }
        
        // Инициализация - выбираем клиента по умолчанию
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.role-card[data-role="1"]').click();
        });
    </script>
    {{-- @endpush --}}
</x-guest-layout>
