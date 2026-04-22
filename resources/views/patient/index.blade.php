<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-users text-white text-base"></i>
                </div>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 leading-tight">
                        {{ __('Gestion des Patients') }}
                    </h2>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ __('Gérer et consulter tous les patients') }}
                    </p>
                </div>
            </div>
            <button onclick="showAjouteModal()"
                class="gradient-bg text-white px-5 py-2.5 rounded-xl hover:shadow-xl transition-all
                       duration-300 flex items-center gap-2 text-sm font-semibold hover:scale-105 shrink-0">
                <i class="fas fa-plus"></i>
                <span>{{ __('Ajouter un patient') }}</span>
            </button>
        </div>
    </x-slot>

    <div class="space-y-5">

        {{-- Alerts --}}
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl shadow-sm">
                <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                </div>
                <p class="text-emerald-700 text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-2xl shadow-sm">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <p class="text-red-700 text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Search + counter --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="relative w-full sm:max-w-sm">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="searchInput"
                    placeholder="{{ __('Rechercher un patient...') }}"
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm
                           focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent
                           bg-white/80 backdrop-blur-sm transition-all duration-300 shadow-sm">
            </div>
            <p class="text-sm text-gray-500 shrink-0">
                <span class="font-semibold text-indigo-600">{{ $patients->count() }}</span>
                {{ __('patient(s)') }}
            </p>
        </div>

        {{-- Table card --}}
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-indigo-50/40 border-b border-gray-100">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-user text-indigo-400"></i>
                                    {{ __('Nom') }}
                                </span>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-envelope text-indigo-400"></i>
                                    {{ __('Email') }}
                                </span>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-phone text-indigo-400"></i>
                                    {{ __('Téléphone') }}
                                </span>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <span class="flex items-center justify-center gap-2">
                                    <i class="fas fa-cog text-indigo-400"></i>
                                    {{ __('Actions') }}
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50" id="patientsTable">
                        @forelse ($patients as $p)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-200 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 gradient-bg rounded-full flex items-center
                                                    justify-center shadow-sm shrink-0">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $p->name }}</p>
                                            <p class="text-xs text-gray-400 sm:hidden">{{ $p->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                    <span class="text-sm text-gray-600">{{ $p->email }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                    <span class="text-sm text-gray-600">{{ $p->phone ?? '—' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('patient.show', $p->id) }}"
                                            title="{{ __('Voir') }}"
                                            class="p-2 text-blue-500 hover:text-white hover:bg-blue-500
                                                   rounded-lg transition-all duration-200">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <a href="{{ route('patient.edit', $p->id) }}"
                                            title="{{ __('Modifier') }}"
                                            class="p-2 text-emerald-500 hover:text-white hover:bg-emerald-500
                                                   rounded-lg transition-all duration-200">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button type="button"
                                            onclick="handelShowModal(event, {{ $p->id }})"
                                            title="{{ __('Supprimer') }}"
                                            class="p-2 text-red-500 hover:text-white hover:bg-red-500
                                                   rounded-lg transition-all duration-200">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center">
                                            <i class="fas fa-users text-indigo-300 text-3xl"></i>
                                        </div>
                                        <p class="text-gray-500 font-medium">{{ __('Aucun patient trouvé') }}</p>
                                        <button onclick="showAjouteModal()"
                                            class="gradient-bg text-white px-4 py-2 rounded-xl
                                                   hover:shadow-lg transition-all duration-300 text-sm
                                                   flex items-center gap-2">
                                            <i class="fas fa-plus"></i>
                                            {{ __('Ajouter le premier patient') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($patients, 'links') && $patients->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $patients->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         MODAL — Ajouter un patient
    ══════════════════════════════════════════ --}}
    <div id="formAjoute"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md transform transition-all">

            {{-- Header --}}
            <div class="px-7 py-5 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-800">{{ __('Ajouter un patient') }}</h3>
                        <p class="text-xs text-gray-400">{{ __('Remplissez les informations ci-dessous') }}</p>
                    </div>
                </div>
                <button onclick="hideAjouteModal()"
                    class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600
                           hover:bg-gray-100 rounded-lg transition-all duration-200"
                    aria-label="{{ __('Fermer') }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Form --}}
            <form action="{{ route('patient.store') }}" method="POST">
                @csrf
                <div class="px-7 py-5 space-y-4">

                    {{-- Nom --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                            {{ __('Nom complet') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="name" required
                                placeholder="{{ __('Jean Dupont') }}"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400 transition-all">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                            {{ __('Adresse email') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="email" name="email" required
                                placeholder="{{ __('jean@exemple.com') }}"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400 transition-all">
                        </div>
                    </div>

                    {{-- Téléphone --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                            {{ __('Téléphone') }}
                        </label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="phone"
                                placeholder="{{ __('06 XX XX XX XX') }}"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400 transition-all">
                        </div>
                    </div>

                    {{-- Mot de passe --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                            {{ __('Mot de passe') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="password" name="password" required
                                placeholder="{{ __('Minimum 8 caractères') }}"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400 transition-all">
                        </div>
                    </div>

                </div>

                <div class="px-7 py-5 border-t border-gray-100 flex items-center justify-end gap-3
                            bg-gray-50/60 rounded-b-3xl">
                    <button type="button" onclick="hideAjouteModal()"
                        class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200
                               rounded-xl hover:bg-gray-100 transition-all duration-200">
                        {{ __('Annuler') }}
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 gradient-bg text-white text-sm font-semibold rounded-xl
                               hover:shadow-lg transition-all duration-300 hover:scale-105 flex items-center gap-2">
                        <i class="fas fa-plus text-xs"></i>
                        {{ __('Ajouter') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         MODAL — Supprimer un patient
    ══════════════════════════════════════════ --}}
    <div id="modalDelete"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm transform transition-all">

            <div class="px-7 py-5 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">{{ __('Confirmer la suppression') }}</h3>
                </div>
                <button onclick="handelCancel()"
                    class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600
                           hover:bg-gray-100 rounded-lg transition-all duration-200"
                    aria-label="{{ __('Fermer') }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="px-7 py-6 text-center">
                <p class="text-gray-700 font-medium">
                    {{ __('Êtes-vous sûr de vouloir supprimer ce patient ?') }}
                </p>
                <p class="text-gray-400 text-sm mt-2">
                    {{ __('Cette action est') }}
                    <strong class="text-red-500">{{ __('irréversible') }}</strong>.
                </p>
            </div>

            <div class="px-7 py-5 border-t border-gray-100 bg-gray-50/60 rounded-b-3xl">
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" onclick="handelCancel()"
                            class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200
                                   rounded-xl hover:bg-gray-100 transition-all duration-200">
                            {{ __('Annuler') }}
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-red-500 text-white text-sm font-semibold rounded-xl
                                   hover:bg-red-600 hover:shadow-lg transition-all duration-300
                                   flex items-center gap-2">
                            <i class="fas fa-trash-alt text-xs"></i>
                            {{ __('Supprimer') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ── Add patient modal ──
        const ajouteModal    = document.getElementById('formAjoute');
        const showAjouteModal = () => { ajouteModal.classList.remove('hidden'); ajouteModal.classList.add('flex'); document.body.style.overflow='hidden'; };
        const hideAjouteModal = () => { ajouteModal.classList.add('hidden'); ajouteModal.classList.remove('flex'); document.body.style.overflow=''; };
        ajouteModal?.addEventListener('click', e => { if(e.target === ajouteModal) hideAjouteModal(); });

        // ── Delete modal ──
        const deleteModal    = document.getElementById('modalDelete');
        const handelShowModal = (e, id) => { e.preventDefault(); document.getElementById('deleteForm').action = `/patient/${id}`; deleteModal.classList.remove('hidden'); deleteModal.classList.add('flex'); document.body.style.overflow='hidden'; };
        const handelCancel   = () => { deleteModal.classList.add('hidden'); deleteModal.classList.remove('flex'); document.body.style.overflow=''; };
        deleteModal?.addEventListener('click', e => { if(e.target === deleteModal) handelCancel(); });

        // ── Live search ──
        document.getElementById('searchInput')?.addEventListener('keyup', function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll('#patientsTable tr').forEach(row => {
                row.style.display = (row.innerText || '').toLowerCase().includes(term) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>