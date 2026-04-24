{{-- resources/views/profile/partials/update-password-form.blade.php --}}
<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        {{-- Mot de passe actuel --}}
        <div>
            <label for="update_password_current_password"
                class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                {{ __('Mot de passe actuel') }}
            </label>
            <div class="relative">
                <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center pointer-events-none border border-gray-200">
                    <i class="fas fa-key text-gray-400 text-xs"></i>
                </div>
                <input id="update_password_current_password" name="current_password" type="password"
                    autocomplete="current-password"
                    class="w-full pl-14 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400 transition-all duration-300 bg-gray-50 focus:bg-white">
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1.5 text-xs" />
        </div>

        {{-- Nouveau mot de passe --}}
        <div>
            <label for="update_password_password"
                class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                {{ __('Nouveau mot de passe') }}
            </label>
            <div class="relative">
                <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center pointer-events-none border border-emerald-100">
                    <i class="fas fa-lock text-emerald-400 text-xs"></i>
                </div>
                <input id="update_password_password" name="password" type="password"
                    autocomplete="new-password"
                    class="w-full pl-14 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400 transition-all duration-300 bg-gray-50 focus:bg-white">
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1.5 text-xs" />
        </div>

        {{-- Confirmation --}}
        <div>
            <label for="update_password_password_confirmation"
                class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                {{ __('Confirmer le nouveau mot de passe') }}
            </label>
            <div class="relative">
                <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-teal-50 rounded-lg flex items-center justify-center pointer-events-none border border-teal-100">
                    <i class="fas fa-lock text-teal-400 text-xs"></i>
                </div>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    autocomplete="new-password"
                    class="w-full pl-14 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400 transition-all duration-300 bg-gray-50 focus:bg-white">
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1.5 text-xs" />
        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-semibold text-sm">
                <i class="fas fa-shield-alt text-xs"></i>
                {{ __('Mettre à jour') }}
            </button>

            @if (session('status') === 'password-updated')
                <span x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm text-emerald-600 font-medium flex items-center gap-1.5">
                    <i class="fas fa-check-circle"></i>
                    {{ __('Mot de passe mis à jour !') }}
                </span>
            @endif
        </div>
    </form>
</section>