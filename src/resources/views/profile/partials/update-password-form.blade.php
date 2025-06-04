<form method="post" action="{{ route('password.update') }}" class="space-y-4">
    @csrf
    @method('put')

    <div class="mb-3">
        <x-input-label for="current_password" value="Текущий пароль" class="form-label" />
        <x-text-input id="current_password" name="current_password" type="password" 
                     class="form-control" autocomplete="current-password" />
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-danger" />
    </div>

    <div class="mb-3">
        <x-input-label for="password" value="Новый пароль" class="form-label" />
        <x-text-input id="password" name="password" type="password" 
                     class="form-control" autocomplete="new-password" />
        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-danger" />
    </div>

    <div class="mb-3">
        <x-input-label for="password_confirmation" value="Подтвердите пароль" class="form-label" />
        <x-text-input id="password_confirmation" name="password_confirmation" type="password" 
                     class="form-control" autocomplete="new-password" />
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-danger" />
    </div>

    <div class="d-flex justify-content-between align-items-center">
        @if (session('status') === 'password-updated')
            <p class="text-success mb-0">
                Пароль успешно изменен.
            </p>
        @endif
        <x-primary-button class="btn btn-primary px-4">
            Сохранить
        </x-primary-button>
    </div>
</form>
