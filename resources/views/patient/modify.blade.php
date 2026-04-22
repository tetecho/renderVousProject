<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl
                            flex items-center justify-center shadow-md">
                    <i class="fas fa-edit text-white text-base"></i>
                </div>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 leading-tight">
                        {{ __('Modifier le patient') }}
                    </h2>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $patient->name }}</p>
                </div>
            </div>
            <a href="{{ route('patient.index') }}"
                class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600
                       bg-white border border-gray-200 hover:border-indigo-300 px-4 py-2 rounded-xl
                       transition-all duration-200 hover:shadow-sm">
                <i class="fas fa-arrow-left text-xs"></i>
                {{ __('Retour') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

            {{-- Top accent --}}
            <div class="h-1.5 bg-gradient-to-r from-emerald-400 via-teal-400 to-indigo-500"></div>

            <form action="{{ route('patient.update', $patient->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="p-6 sm:p-8 space-y-5">

                    {{-- Nom --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                            {{ __('Nom complet') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-indigo-50
                                        rounded-lg flex items-center justify-center pointer-events-none">
                                <i class="fas fa-user text-indigo-400 text-xs"></i>
                            </div>
                            <input type="text" name="name"
                                value="{{ old('name', $patient->name) }}" required
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-2xl text-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent
                                       transition-all duration-200 bg-gray-50 focus:bg-white
                                       @error('name') border-red-400 @enderror"
                                placeholder="{{ __('Jean Dupont') }}">
                        </div>
                        @error('name')
                            <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
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
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-blue-50
                                        rounded-lg flex items-center justify-center pointer-events-none">
                                <i class="fas fa-envelope text-blue-400 text-xs"></i>
                            </div>
                            <input type="email" name="email"
                                value="{{ old('email', $patient->email) }}" required
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-2xl text-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent
                                       transition-all duration-200 bg-gray-50 focus:bg-white
                                       @error('email') border-red-400 @enderror"
                                placeholder="{{ __('jean@exemple.com') }}">
                        </div>
                        @error('email')
                            <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
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
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-emerald-50
                                        rounded-lg flex items-center justify-center pointer-events-none">
                                <i class="fas fa-phone text-emerald-400 text-xs"></i>
                            </div>
                            <input type="text" name="phone"
                                value="{{ old('phone', $patient->phone) }}"
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-2xl text-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent
                                       transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="{{ __('06 XX XX XX XX') }}">
                        </div>
                    </div>

                    {{-- Mot de passe --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                            {{ __('Nouveau mot de passe') }}
                        </label>
                        <div class="relative">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-purple-50
                                        rounded-lg flex items-center justify-center pointer-events-none">
                                <i class="fas fa-lock text-purple-400 text-xs"></i>
                            </div>
                            <input type="password" name="password"
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-2xl text-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent
                                       transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="{{ __('Laisser vide pour conserver l\'actuel') }}">
                        </div>
                        <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1.5">
                            <i class="fas fa-info-circle text-indigo-400"></i>
                            {{ __('Laissez vide pour conserver le mot de passe actuel') }}
                        </p>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="px-6 sm:px-8 py-5 bg-gray-50/70 border-t border-gray-100 rounded-b-3xl
                            flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('patient.index') }}"
                        class="w-full sm:w-auto text-center px-5 py-2.5 text-sm font-medium text-gray-600
                               bg-white border border-gray-200 rounded-xl hover:bg-gray-100
                               transition-all duration-200">
                        {{ __('Annuler') }}
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto gradient-bg text-white px-6 py-2.5 text-sm font-semibold
                               rounded-xl hover:shadow-lg transition-all duration-300 hover:scale-105
                               flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        {{ __('Enregistrer les modifications') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>