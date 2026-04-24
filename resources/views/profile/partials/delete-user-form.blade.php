{{-- resources/views/profile/partials/delete-user-form.blade.php --}}
<section>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <p class="text-sm text-gray-600 max-w-md leading-relaxed">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez télécharger toute donnée que vous souhaitez conserver avant de procéder.') }}
        </p>
        <x-danger-button
            class="shrink-0 inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold rounded-xl transition-all duration-300 hover:shadow-lg transform hover:-translate-y-0.5"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            <i class="fas fa-trash-alt text-xs"></i>
            {{ __('Supprimer le compte') }}
        </x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="relative overflow-hidden rounded-2xl">
            <div class="h-1.5 bg-gradient-to-r from-red-500 to-red-600 absolute top-0 left-0 right-0"></div>

            <form method="post" action="{{ route('profile.destroy') }}" class="p-7 pt-8">
                @csrf
                @method('delete')

                {{-- Header --}}
                <div class="flex items-start gap-4 mb-5">
                    <div class="p-3 rounded-xl bg-red-100 border border-red-200 shadow-sm shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900">{{ __('Supprimer votre compte ?') }}</h3>
                        <p class="text-gray-500 text-sm mt-0.5">{{ __('Cette action est irréversible') }}</p>
                    </div>
                </div>

                {{-- Warning --}}
                <div class="mb-6 p-4 bg-red-50 rounded-xl border border-red-200">
                    <p class="text-gray-700 text-sm leading-relaxed">
                        <i class="fas fa-info-circle text-red-400 mr-1.5"></i>
                        {{ __('Toutes vos données seront définitivement supprimées. Veuillez saisir votre mot de passe pour confirmer.') }}
                    </p>
                    <p class="text-red-600 text-xs font-medium mt-2 flex items-center gap-1">
                        <i class="fas fa-exclamation-triangle text-xs"></i>
                        {{ __('Cette action ne peut pas être annulée.') }}
                    </p>
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2" for="modal_delete_password">
                        {{ __('Mot de passe actuel') }}
                    </label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center pointer-events-none border border-red-100">
                            <i class="fas fa-lock text-red-400 text-xs"></i>
                        </div>
                        <input id="modal_delete_password" name="password" type="password"
                            placeholder="{{ __('Votre mot de passe actuel') }}"
                            class="w-full pl-14 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-400/30 focus:border-red-400 transition-all duration-300 bg-gray-50 focus:bg-white">
                    </div>
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5 text-xs" />
                </div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" x-on:click="$dispatch('close')"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-300 font-medium hover:border-gray-400 text-sm">
                        <i class="fas fa-times text-xs"></i> {{ __('Annuler') }}
                    </button>
                    <x-danger-button
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300 hover:shadow-lg transform hover:-translate-y-0.5">
                        <i class="fas fa-trash-alt text-xs"></i>
                        {{ __('Confirmer la suppression') }}
                    </x-danger-button>
                </div>
            </form>
        </div>
    </x-modal>
</section>