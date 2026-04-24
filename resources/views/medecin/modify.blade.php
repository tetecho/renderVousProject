{{-- resources/views/patients/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div class="p-4 rounded-2xl gradient-primary shadow-lg">
                        <i class="fas fa-user-edit text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ __('Modifier le patient') }}</h1>
                        <p class="text-gray-500 mt-1">{{ $medecin->name }}</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('medecin.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-xl hover:border-blue-300 hover:text-blue-600 transition-all duration-300 hover:bg-blue-50 self-start lg:self-auto">
                <i class="fas fa-arrow-left text-xs"></i> {{ __('Retour à la liste') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden"
             style="box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
            <div class="h-1.5 gradient-primary"></div>

            <form action="{{ route('medecin.update', $medecin->id) }}" method="POST" class="p-6 space-y-5">
                @csrf @method('PUT')

                {{-- Nom --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                        {{ __('Nom complet') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center pointer-events-none border border-blue-100">
                            <i class="fas fa-user text-blue-400 text-xs"></i>
                        </div>
                        <input type="text" name="name" value="{{ old('name', $medecin->name) }}" required
                            placeholder="{{ __('Jean Dupont') }}"
                            class="w-full pl-14 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all duration-300 bg-gray-50 focus:bg-white @error('name') border-red-400 bg-red-50 @enderror">
                    </div>
                    @error('name')
                        <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1.5">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                        {{ __('Adresse email') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center pointer-events-none border border-blue-100">
                            <i class="fas fa-envelope text-blue-400 text-xs"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email', $medecin->email) }}" required
                            placeholder="{{ __('jean@exemple.com') }}"
                            class="w-full pl-14 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all duration-300 bg-gray-50 focus:bg-white @error('email') border-red-400 bg-red-50 @enderror">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1.5">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Téléphone --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                        {{ __('Téléphone') }}
                    </label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center pointer-events-none border border-emerald-100">
                            <i class="fas fa-phone-alt text-emerald-400 text-xs"></i>
                        </div>
                        <input type="tel" name="phone" value="{{ old('phone', $medecin->phone) }}"
                            placeholder="{{ __('06 12 34 56 78') }}"
                            class="w-full pl-14 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all duration-300 bg-gray-50 focus:bg-white">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                        {{ __('Nouveau mot de passe') }}
                    </label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center pointer-events-none border border-purple-100">
                            <i class="fas fa-key text-purple-400 text-xs"></i>
                        </div>
                        <input type="password" name="password"
                            placeholder="{{ __('Laisser vide pour conserver l\'actuel') }}"
                            class="w-full pl-14 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all duration-300 bg-gray-50 focus:bg-white">
                    </div>
                    <p class="text-xs text-gray-400 mt-2 flex items-center gap-1.5">
                        <i class="fas fa-info-circle text-blue-400"></i>
                        {{ __('Laissez vide pour conserver le mot de passe actuel') }}
                    </p>
                </div>

                {{-- Submit --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('medecin.index') }}"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-300 font-medium hover:border-gray-400 text-sm">
                        <i class="fas fa-times text-xs"></i> {{ __('Annuler') }}
                    </a>
                    <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl gradient-primary text-white hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-semibold text-sm">
                        <i class="fas fa-save text-xs"></i> {{ __('Enregistrer les modifications') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>