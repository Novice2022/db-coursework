<x-guest-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Вход в систему</h2>
                        
                        <!-- Session Status -->
                        <x-auth-session-status class="alert alert-info mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="form-control"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label for="remember_me" class="form-check-label">
                                    {{ __('Remember me') }}
                                </label>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                @if (Route::has('password.request'))
                                    <a class="text-sm text-muted text-decoration-underline" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif

                                <button type="submit" class="btn btn-primary px-4">
                                    {{ __('Log in') }}
                                </button>
                            </div>
                        </form>
                        
                        <div class="mt-4 text-center">
                            <p class="text-muted">Нет аккаунта? <a href="{{ route('register') }}" class="text-decoration-underline">Зарегистрируйтесь</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
