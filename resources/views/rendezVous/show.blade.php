<x-app-layout>
    @php($isAdmin = auth()->user()->isAdmin())
    @php($canCancel = !$isAdmin && $rendezVous->statut !== 'annule')
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('rendezvous.index') }}" 
               class="p-2 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-300">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="p-4 rounded-2xl gradient-primary shadow-lg">
                <i class="fas fa-calendar-check text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ __('Détails du rendez-vous') }}</h1>
                <p class="text-gray-500 mt-1">#{{ $rendezVous->id }} • {{ $rendezVous->date_heure->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Status card --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 rounded-xl bg-blue-50">
                            <i class="fas fa-info-circle text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">{{ __('Statut actuel') }}</p>
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold
                                @if($rendezVous->statut == 'confirme') bg-green-100 text-green-700
                                @elseif($rendezVous->statut == 'annule') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                <i class="fas fa-circle text-[8px]"></i>
                                {{ ucfirst($rendezVous->statut) }}
                            </span>
                        </div>
                    </div>
                    @if($isAdmin)
                        <div class="flex gap-3">
                            <a href="{{ route('rendezvous.edit', $rendezVous->id) }}" 
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-all duration-200 text-sm font-medium">
                                <i class="fas fa-edit text-xs"></i> {{ __('Modifier') }}
                            </a>
                            <button type="button" onclick="openDeleteModal({{ $rendezVous->id }})"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 transition-all duration-200 text-sm font-medium">
                                <i class="fas fa-trash-alt text-xs"></i> {{ __('Supprimer') }}
                            </button>
                        </div>
                    @else
                        @if($canCancel)
                            <form action="{{ route('rendezvous.cancel', $rendezVous->id) }}" method="POST"
                                onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir annuler ce rendez-vous ?') }}')">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 transition-all duration-200 text-sm font-medium">
                                    <i class="fas fa-ban text-xs"></i> {{ __('Annuler') }}
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        {{-- Informations principales --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-user text-blue-500"></i> {{ __('Patient') }}
                    </h3>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-user-circle text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $rendezVous->patient->name }}</p>
                            <p class="text-sm text-gray-500">{{ $rendezVous->patient->email }}</p>
                            @if($rendezVous->patient->phone)
                                <p class="text-sm text-gray-500">{{ $rendezVous->patient->phone }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-user-md text-emerald-500"></i> {{ __('Médecin') }}
                    </h3>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-stethoscope text-emerald-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $rendezVous->medecin->name }}</p>
                            <p class="text-sm text-gray-500">{{ $rendezVous->medecin->email }}</p>
                            @if($rendezVous->medecin->phone)
                                <p class="text-sm text-gray-500">{{ $rendezVous->medecin->phone }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-concierge-bell text-purple-500"></i> {{ __('Service') }}
                    </h3>
                </div>
                <div class="p-5">
                    <p class="text-gray-700">{{ $rendezVous->service->name }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-amber-500"></i> {{ __('Date et heure') }}
                    </h3>
                </div>
                <div class="p-5">
                    <p class="text-gray-700">{{ $rendezVous->date_heure->format('l d F Y à H:i') }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $rendezVous->date_heure->diffForHumans() }}</p>
                </div>
            </div>
        </div>

        {{-- Bouton retour --}}
        <div class="flex justify-center pt-4">
            <a href="{{ route('rendezvous.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-300 font-medium">
                <i class="fas fa-arrow-left text-xs"></i> {{ __('Retour à la liste') }}
            </a>
        </div>
    </div>

    @if($isAdmin)
        {{-- MODAL Supprimer (identique à l'index) --}}
        <div id="modalDelete" class="fixed inset-0 hidden items-center justify-center p-4 bg-black/40 backdrop-blur-sm z-[10000]">
            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-red-500 to-red-600"></div>
                <div class="p-6">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="p-3 rounded-xl bg-red-100 border border-red-200 shadow-sm">
                            <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900">{{ __('Supprimer le rendez-vous') }}</h3>
                            <p class="text-gray-500 text-sm mt-1">{{ __('Confirmer la suppression') }}</p>
                        </div>
                    </div>
                    <div class="mb-6 p-4 bg-red-50 rounded-xl border border-red-200">
                        <p class="text-gray-700 text-sm leading-relaxed">{{ __('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?') }}</p>
                        <p class="text-red-600 text-xs font-medium mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ __('Cette action est irréversible.') }}
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="closeDeleteModal()"
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-300 font-medium hover:border-gray-400 text-sm">
                            <i class="fas fa-times text-xs"></i> {{ __('Annuler') }}
                        </button>
                        <form id="deleteForm" action="" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-gradient-to-r from-red-500 to-red-600 text-white hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium text-sm">
                                <i class="fas fa-trash-alt text-xs"></i> {{ __('Supprimer') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($isAdmin)
        <script>
            const deleteModal = document.getElementById('modalDelete');
            function openDeleteModal(id) {
                document.getElementById('deleteForm').action = `/rendezvous/${id}`;
                deleteModal.classList.remove('hidden');
                deleteModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
            function closeDeleteModal() {
                deleteModal.classList.add('hidden');
                deleteModal.classList.remove('flex');
                document.body.style.overflow = '';
            }
            deleteModal?.addEventListener('click', e => { if (e.target === deleteModal) closeDeleteModal(); });
        </script>
    @endif
</x-app-layout>
