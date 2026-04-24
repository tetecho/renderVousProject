{{-- resources/views/profile/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="p-4 rounded-2xl gradient-primary shadow-lg">
                <i class="fas fa-user-circle text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ __('Mon profil') }}</h1>
                <p class="text-gray-500 mt-1">{{ __('Gérez vos informations personnelles et votre sécurité') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-5">

        {{-- Informations du profil --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md"
             style="box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
            <div class="p-6">
                <div class="flex items-start gap-4 mb-6">
                    <div class="p-3 rounded-xl bg-indigo-50 border border-indigo-100 shadow-sm">
                        <i class="fas fa-id-card text-indigo-600 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Informations du profil') }}</h3>
                        <p class="text-gray-500 text-sm mt-0.5">{{ __('Mettez à jour votre nom et votre adresse email') }}</p>
                    </div>
                </div>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Sécurité / Mot de passe --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md"
             style="box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
            <div class="h-1.5 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
            <div class="p-6">
                <div class="flex items-start gap-4 mb-6">
                    <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-100 shadow-sm">
                        <i class="fas fa-lock text-emerald-600 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Sécurité') }}</h3>
                        <p class="text-gray-500 text-sm mt-0.5">{{ __('Utilisez un mot de passe long et aléatoire pour rester sécurisé') }}</p>
                    </div>
                </div>
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Zone dangereuse --}}
        <div class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md"
             style="box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
            <div class="h-1.5 bg-gradient-to-r from-red-500 to-red-600"></div>
            <div class="p-6">
                <div class="flex items-start gap-4 mb-6">
                    <div class="p-3 rounded-xl bg-red-50 border border-red-200 shadow-sm">
                        <i class="fas fa-trash-alt text-red-600 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Zone dangereuse') }}</h3>
                        <p class="text-gray-500 text-sm mt-0.5">{{ __('Suppression permanente et irréversible du compte') }}</p>
                    </div>
                </div>
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</x-app-layout>