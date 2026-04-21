<x-guest-layout>
    <div class="text-center mb-8">
        <div class="inline-flex items-center bg-indigo-100 rounded-full px-4 py-2 mb-4">
            <i class="fas fa-user-plus text-indigo-600 mr-2"></i>
            <span class="text-indigo-600 text-sm font-semibold">Inscription</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Créer un compte</h2>
        <p class="text-gray-500 text-sm">Rejoignez notre cabinet médical</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-5">
            <x-input-label for="name" :value="__('Nom complet')" class="text-gray-700 font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user text-gray-400"></i>
                </div>
                <x-text-input id="name" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" 
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                    placeholder="Jean Dupont" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-5">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <x-text-input id="email" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" 
                    type="email" name="email" :value="old('email')" required autocomplete="username" 
                    placeholder="jean@exemple.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-700 font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <x-text-input id="password" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                    type="password" name="password" required autocomplete="new-password"
                    placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-gray-700 font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-check-circle text-gray-400"></i>
                </div>
                <x-text-input id="password_confirmation" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                    type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-4">
            <x-primary-button class="w-full justify-center py-3 gradient-bg text-white rounded-xl font-bold hover:shadow-xl transition-all duration-300 shine-effect">
                <i class="fas fa-user-plus mr-2"></i>
                {{ ("S'inscrire") }}
            </x-primary-button>
            
            <div class="text-center text-gray-500 text-sm">
                Déjà inscrit ?
                <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 transition duration-300">
                    Se connecter
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>