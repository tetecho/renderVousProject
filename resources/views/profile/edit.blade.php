<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center shadow-md">
                <i class="fas fa-user-circle text-white text-base"></i>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">{{ __('Mon profil') }}</h2>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ __('Gérez vos informations personnelles et votre sécurité') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">

        {{-- ── Informations du profil ── --}}
        <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
            <div class="px-6 sm:px-8 py-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-id-card text-indigo-600 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">{{ __('Informations du profil') }}</h3>
                        <p class="text-xs text-gray-400">
                            {{ __('Mettez à jour votre nom et votre adresse email') }}
                        </p>
                    </div>
                </div>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- ── Sécurité / Mot de passe ── --}}
        <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="h-1 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
            <div class="px-6 sm:px-8 py-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-lock text-emerald-600 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">{{ __('Sécurité') }}</h3>
                        <p class="text-xs text-gray-400">
                            {{ __('Utilisez un mot de passe long et aléatoire pour rester sécurisé') }}
                        </p>
                    </div>
                </div>
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- ── Zone dangereuse ── --}}
        <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-lg border border-red-100 overflow-hidden">
            <div class="h-1 bg-gradient-to-r from-red-400 to-rose-500"></div>
            <div class="px-6 sm:px-8 py-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-trash-alt text-red-500 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">{{ __('Zone dangereuse') }}</h3>
                        <p class="text-xs text-gray-400">
                            {{ __('Suppression permanente et irréversible du compte') }}
                        </p>
                    </div>
                </div>
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</x-app-layout>