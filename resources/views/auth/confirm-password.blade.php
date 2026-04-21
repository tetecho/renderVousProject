<x-guest-layout>
    <div class="text-center mb-8">
        <div class="inline-flex items-center bg-red-100 rounded-full px-4 py-2 mb-4">
            <i class="fas fa-shield-alt text-red-600 mr-2"></i>
            <span class="text-red-600 text-sm font-semibold">Zone sécurisée</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Confirmation requise</h2>
        <div class="bg-amber-50 rounded-xl p-4 mb-4">
            <i class="fas fa-exclamation-triangle text-amber-600 text-lg mb-2"></i>
            <p class="text-gray-600 text-sm leading-relaxed">
                {{ __('Cette zone est sécurisée. Veuillez confirmer votre mot de passe avant de continuer.') }}
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-700 font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <x-text-input id="password" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                    type="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-4">
            <x-primary-button class="w-full justify-center py-3 gradient-bg text-white rounded-xl font-bold hover:shadow-xl transition-all duration-300 shine-effect">
                <i class="fas fa-check-circle mr-2"></i>
                {{ __('Confirmer') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>