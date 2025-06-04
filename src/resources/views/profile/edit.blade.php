<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-8">
                <!-- Секция информации профиля -->
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="mb-0">Профиль пользователя</h2>
                            <span class="badge bg-primary">
                                @if(auth()->user()->role_id == 1) Клиент @endif
                                @if(auth()->user()->role_id == 2) Аналитик @endif
                                @if(auth()->user()->role_id == 3) Менеджер @endif
                                @if(auth()->user()->role_id == 4) Администратор @endif
                            </span>
                        </div>
                        
                        <div class="mb-4">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <!-- Секция смены пароля -->
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                    <div class="card-body p-5">
                        <h2 class="mb-4">Смена пароля</h2>
                        
                        <div class="mb-4">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                <!-- Секция удаления аккаунта -->
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <h2 class="mb-4">Удаление аккаунта</h2>
                        
                        <div class="mb-4">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .profile-section {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        .profile-section:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        .form-control:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
        }
        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        .btn-danger {
            background-color: var(--bs-danger);
            border-color: var(--bs-danger);
        }
        .btn-danger:hover {
            background-color: #bb2d3b;
            border-color: #b02a37;
        }
    </style>
</x-app-layout>
