<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-user-circle text-white text-base"></i>
                </div>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 leading-tight">{{ __('Fiche patient') }}</h2>
                    <p class="text-xs text-gray-400 mt-0.5">{{ __('Détails complets du patient') }}</p>
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

            {{-- Hero banner --}}
            <div class="gradient-bg px-6 py-10 text-center relative overflow-hidden">
                <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full pointer-events-none"></div>
                <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-white/10 rounded-full pointer-events-none"></div>
                <div class="relative">
                    <div class="w-24 h-24 bg-white rounded-2xl flex items-center justify-center mx-auto shadow-xl">
                        <i class="fas fa-user text-4xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-white text-2xl font-extrabold mt-4">{{ $patient->name }}</h3>
                    <span class="inline-block mt-2 px-3 py-1 bg-white/20 backdrop-blur-sm text-white
                                 text-xs font-semibold rounded-full border border-white/30">
                        <i class="fas fa-id-badge mr-1"></i>
                        {{ __('Patient') }} #{{ $patient->id }}
                    </span>
                </div>
            </div>

            {{-- Info rows --}}
            <div class="p-6 sm:p-8 space-y-3">

                <div class="flex items-center gap-4 p-4 bg-gray-50 hover:bg-indigo-50/40 rounded-2xl
                            transition-colors duration-200 group">
                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center shrink-0
                                group-hover:bg-indigo-200 transition-colors">
                        <i class="fas fa-envelope text-indigo-600 text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ __('Email') }}</p>
                        <p class="text-sm font-medium text-gray-800 truncate mt-0.5">{{ $patient->email }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-4 bg-gray-50 hover:bg-indigo-50/40 rounded-2xl
                            transition-colors duration-200 group">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0
                                group-hover:bg-emerald-200 transition-colors">
                        <i class="fas fa-phone text-emerald-600 text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ __('Téléphone') }}</p>
                        <p class="text-sm font-medium text-gray-800 mt-0.5">{{ $patient->phone ?? '—' }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-4 bg-gray-50 hover:bg-indigo-50/40 rounded-2xl
                            transition-colors duration-200 group">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center shrink-0
                                group-hover:bg-purple-200 transition-colors">
                        <i class="fas fa-calendar-alt text-purple-600 text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">
                            {{ __('Date d\'inscription') }}
                        </p>
                        <p class="text-sm font-medium text-gray-800 mt-0.5">
                            {{ $patient->created_at->format('d/m/Y') }}
                            {{ __('à') }}
                            {{ $patient->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- Actions --}}
            <div class="px-6 sm:px-8 pb-8 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('patient.edit', $patient->id) }}"
                    class="flex-1 flex items-center justify-center gap-2 px-5 py-3 bg-emerald-500
                           hover:bg-emerald-600 text-white text-sm font-semibold rounded-2xl
                           transition-all duration-300 hover:shadow-lg hover:scale-[1.02]">
                    <i class="fas fa-edit"></i>
                    {{ __('Modifier') }}
                </a>
                <form action="{{ route('patient.destroy', $patient->id) }}" method="POST"
                    onsubmit="return confirm('{{ __('Supprimer définitivement ce patient ?') }}')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-3
                               bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-2xl
                               transition-all duration-300 hover:shadow-lg hover:scale-[1.02]">
                        <i class="fas fa-trash-alt"></i>
                        {{ __('Supprimer') }}
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>