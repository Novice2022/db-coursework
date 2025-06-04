<form method="post" action="{{ route('profile.update') }}" class="space-y-4">
    @csrf
    @method('patch')

    <div class="mb-3">
        <x-input-label for="name" value="ФИО" class="form-label" />
        <x-text-input id="name" name="name" type="text" class="form-control" 
                     :value="old('name', $user->name)" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
    </div>

    <div class="mb-3">
        <x-input-label for="email" value="Email" class="form-label" />
        <x-text-input id="email" name="email" type="email" class="form-control" 
                     :value="old('email', $user->email)" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
    </div>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="alert alert-warning">
            <p class="mb-1">Ваш email не подтвержден.</p>
            <button form="send-verification" class="btn btn-link p-0 text-decoration-underline">
                Нажмите здесь, чтобы отправить письмо подтверждения повторно.
            </button>
            @if (session('status') === 'verification-link-sent')
                <p class="mt-2 text-success">
                    На ваш email отправлена новая ссылка для подтверждения.
                </p>
            @endif
        </div>
    @endif

    <div class="d-flex justify-content-end">
        <x-primary-button class="btn btn-primary px-4">
            Сохранить
        </x-primary-button>
    </div>
</form>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>
