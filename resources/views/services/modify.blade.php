{{-- resources/views/services/modify.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="p-4 rounded-2xl gradient-primary shadow-lg">
                    <i class="fas fa-edit text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ __('Modifier la spécialité') }}</h1>
                    <p class="text-gray-500 mt-1">{{ $service->name }}</p>
                </div>
            </div>
            <a href="{{ route('service.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-xl hover:border-blue-300 hover:text-blue-600 transition-all duration-300 hover:bg-blue-50 self-start lg:self-auto">
                <i class="fas fa-arrow-left text-xs"></i> {{ __('Retour à la liste') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="h-1.5 gradient-primary"></div>

            <form action="{{ route('service.update', $service->id) }}" method="POST" class="p-6 space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                        {{ __('Nom de la spécialité') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center pointer-events-none border border-blue-100">
                            <i class="fas fa-tag text-blue-400 text-xs"></i>
                        </div>
                        <input type="text" name="name" value="{{ old('name', $service->name) }}" required
                            placeholder="{{ __('Cardiologie') }}"
                            class="w-full pl-14 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all duration-300 bg-gray-50 focus:bg-white @error('name') border-red-400 bg-red-50 @enderror">
                    </div>
                    @error('name')
                        <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1.5">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('service.index') }}"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-300 font-medium text-sm">
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