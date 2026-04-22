<section>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <p class="text-sm text-gray-600 max-w-md leading-relaxed">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez télécharger toute donnée que vous souhaitez conserver avant de procéder.') }}
        </p>
        <x-danger-button
            class="shrink-0 flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-xl
                   transition-all duration-300 hover:scale-105"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            <i class="fas fa-trash-alt text-xs"></i>
            {{ __('Supprimer le compte') }}
        </x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-7">
            @csrf
            @method('delete')

            {{-- Modal header --}}
            <div class="flex items-center gap-3 mb-5">
                <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900">
                        {{ __('Supprimer votre compte ?') }}
                    </h2>
                    <p class="text-xs text-gray-500">{{ __('Cette action est irréversible') }}</p>
                </div>
            </div>

            {{-- Warning box --}}
            <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl">
                <p class="text-sm text-gray-600 leading-relaxed">
                    <i class="fas fa-info-circle text-red-400 mr-2"></i>
                    {{ __('Toutes vos données seront définitivement supprimées. Veuillez saisir votre mot de passe pour confirmer.') }}
                </p>
            </div>

            {{-- Password field --}}
            <div class="mb-6">
                <label class="sr-only" for="modal_delete_password">
                    {{ __('Mot de passe') }}
                </label>
                <div class="relative">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-red-50 rounded-lg
                                flex items-center justify-center pointer-events-none">
                        <i class="fas fa-lock text-red-400 text-xs"></i>
                    </div>
                    <input id="modal_delete_password" name="password" type="password"
                        placeholder="{{ __('Votre mot de passe actuel') }}"
                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-2xl text-sm
                               focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent
                               transition-all duration-200 bg-gray-50 focus:bg-white">
                </div>
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1 text-xs" />
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')"
                    class="px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200">
                    {{ __('Annuler') }}
                </x-secondary-button>
                <x-danger-button
                    class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-xl
                           transition-all duration-300 hover:scale-105">
                    <i class="fas fa-trash-alt text-xs"></i>
                    {{ __('Confirmer la suppression') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>