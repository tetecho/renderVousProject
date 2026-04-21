<x-guest-layout>
    <div class="text-center mb-8">
        <div class="inline-flex items-center bg-indigo-100 rounded-full px-4 py-2 mb-4">
            <i class="fas fa-sign-in-alt text-indigo-600 mr-2"></i>
            <span class="text-indigo-600 text-sm font-semibold">Connexion</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Bienvenue</h2>
        <p class="text-gray-500 text-sm">Connectez-vous à votre compte</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <x-text-input id="email" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" 
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                    placeholder="votre@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold mb-2" />
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

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-700 font-semibold transition duration-300" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif
        </div>

        <div class="flex flex-col gap-4">
            <x-primary-button class="w-full justify-center py-3 gradient-bg text-white rounded-xl font-bold hover:shadow-xl transition-all duration-300 shine-effect">
                <i class="fas fa-sign-in-alt mr-2"></i>
                {{ __('Se connecter') }}
            </x-primary-button>
            
            <div class="text-center text-gray-500 text-sm">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 transition duration-300">
                    Créer un compte
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>