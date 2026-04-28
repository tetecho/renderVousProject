{{-- resources/views/services/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="p-4 rounded-2xl gradient-primary shadow-lg">
                    <i class="fas fa-stethoscope text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ __('Fiche spécialité') }}</h1>
                    <p class="text-gray-500 mt-1">{{ $service->name }}</p>
                </div>
            </div>
            <a href="{{ route('service.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-xl hover:border-blue-300 hover:text-blue-600 transition-all duration-300 hover:bg-blue-50 self-start lg:self-auto">
                <i class="fas fa-arrow-left text-xs"></i> {{ __('Retour à la liste') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-4">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="h-1.5 gradient-primary"></div>

            <div class="px-6 py-8 flex flex-col items-center text-center border-b border-gray-100">
                <div class="w-24 h-24 rounded-full gradient-primary flex items-center justify-center shadow-lg mb-4">
                    <i class="fas fa-stethoscope text-white text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $service->name }}</h2>
                <span class="mt-2 px-3 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-600 border border-blue-100">
                    Spécialité #{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
                </span>
            </div>

            <div class="p-6 space-y-3">
                <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-2.5 rounded-lg bg-blue-50 border border-blue-100 shrink-0">
                        <i class="fas fa-tag text-blue-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">{{ __('Nom de la spécialité') }}</p>
                        <p class="text-sm font-medium text-gray-800 mt-0.5">{{ $service->name }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-2.5 rounded-lg bg-indigo-50 border border-indigo-100 shrink-0">
                        <i class="fas fa-calendar-alt text-indigo-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">{{ __('Date de création') }}</p>
                        <p class="text-sm font-medium text-gray-800 mt-0.5">
                            {{ $service->created_at ? $service->created_at->format('d/m/Y à H:i') : __('Date inconnue') }}
                        </p>
                    </div>
                </div>

                @if($service->updated_at && $service->updated_at != $service->created_at)
                <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-2.5 rounded-lg bg-gray-50 border border-gray-200 shrink-0">
                        <i class="fas fa-edit text-gray-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">{{ __('Dernière modification') }}</p>
                        <p class="text-sm font-medium text-gray-800 mt-0.5">
                            {{ $service->updated_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                </div>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row gap-3 p-6 pt-2 border-t border-gray-100">
                <a href="{{ route('service.edit', $service->id) }}"
                    class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium text-sm">
                    <i class="fas fa-edit text-xs"></i> {{ __('Modifier') }}
                </a>
                <form action="{{ route('service.destroy', $service->id) }}" method="POST"
                    onsubmit="return confirm('{{ __('Supprimer définitivement cette spécialité ?') }}')" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-gradient-to-r from-red-500 to-red-600 text-white hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium text-sm">
                        <i class="fas fa-trash-alt text-xs"></i> {{ __('Supprimer') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>