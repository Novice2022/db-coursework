<div class="alert alert-warning">
    <p class="mb-3">После удаления аккаунта все ваши данные будут безвозвратно удалены. Пожалуйста, сохраните важную информацию перед удалением.</p>
    
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn btn-danger"
    >
        Удалить аккаунт
    </x-danger-button>
</div>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Подтвердите удаление аккаунта</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" x-on:click="$dispatch('close')"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                @csrf
                @method('delete')

                <div class="modal-body">
                    <p>Для подтверждения удаления аккаунта введите ваш пароль.</p>

                    <div class="mb-3">
                        <x-input-label for="password" value="Пароль" class="form-label visually-hidden" />
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control"
                            placeholder="Введите ваш пароль"
                        />
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-danger" />
                    </div>
                </div>

                <div class="modal-footer">
                    <x-secondary-button x-on:click="$dispatch('close')" class="btn btn-secondary">
                        Отмена
                    </x-secondary-button>

                    <x-danger-button class="btn btn-danger ms-3">
                        Удалить аккаунт
                    </x-danger-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>

<style>
    .modal-content {
        border-radius: 0.5rem;
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .modal-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }
</style>
