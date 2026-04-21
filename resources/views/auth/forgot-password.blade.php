<x-guest-layout>
    <div class="text-center mb-8">
        <div class="inline-flex items-center bg-amber-100 rounded-full px-4 py-2 mb-4">
            <i class="fas fa-key text-amber-600 mr-2"></i>
            <span class="text-amber-600 text-sm font-semibold">Mot de passe oublié</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Besoin d'aide ?</h2>
        <p class="text-gray-500 text-sm mb-4">
            {{ __('Entrez votre email et nous vous enverrons un lien de réinitialisation.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-6">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <x-text-input id="email" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" 
                    type="email" name="email" :value="old('email')" required autofocus 
                    placeholder="votre@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-4">
            <x-primary-button class="w-full justify-center py-3 gradient-bg text-white rounded-xl font-bold hover:shadow-xl transition-all duration-300 shine-effect">
                <i class="fas fa-paper-plane mr-2"></i>
                {{ __('Envoyer le lien de réinitialisation') }}
            </x-primary-button>
            
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-indigo-600 text-sm font-semibold hover:text-indigo-700 transition duration-300 inline-flex items-center gap-1">
                    <i class="fas fa-arrow-left"></i>
                    Retour à la connexion
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>