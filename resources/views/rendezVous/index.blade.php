{{-- resources/views/rendezvous/index.blade.php --}}
<x-app-layout>
    @php($currentUser = auth()->user())
    @php($isAdmin = $currentUser->isAdmin())
    @php($canCreate = $isAdmin || $currentUser->isPatient())

    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div class="p-4 rounded-2xl gradient-primary shadow-lg">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ __('Rendez-vous') }}</h1>
                        <p class="text-gray-500 mt-1">
                            {{ __('Total :') }} <span class="font-bold text-gray-900">{{ $rendezVous->count() }}</span>
                            {{ __('rendez-vous') }}
                        </p>
                    </div>
                </div>
            </div>
            @if($canCreate)
                <button onclick="showAjouteModal()"
                    class="group inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl gradient-primary text-white hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 font-semibold shadow-md text-sm">
                    <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                    {{ __('Ajouter un rendez-vous') }}
                </button>
            @endif
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <p class="text-emerald-700 text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <p class="text-red-700 text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex-1 max-w-2xl">
                <div class="relative group">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="searchInput"
                        placeholder="{{ __('Rechercher un rendez-vous...') }}"
                        class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400/20 focus:border-blue-400 transition-all duration-300 shadow-sm text-sm">
                </div>
            </div>
            <div class="hidden md:flex items-center gap-3 text-sm text-gray-600 bg-gray-50 px-4 py-2.5 rounded-lg border border-gray-200">
                <span>{{ __('Affichage') }}</span>
                <span class="font-bold text-gray-900" id="visibleCount">{{ $rendezVous->count() }}</span>
                <span>{{ __('sur') }}</span>
                <span class="font-bold text-gray-900">{{ $rendezVous->count() }}</span>
            </div>
        </div>

        @if($rendezVous->isEmpty())
            <div class="text-center py-16 lg:py-20">
                <div class="inline-flex p-6 rounded-2xl bg-blue-50 mb-6">
                    <i class="fas fa-calendar-times text-blue-400 text-5xl"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-semibold text-gray-800 mb-3">{{ __('Aucun rendez-vous trouvé') }}</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-8">{{ __('Ajoutez votre premier rendez-vous pour commencer.') }}</p>
                @if($canCreate)
                    <button onclick="showAjouteModal()"
                        class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl gradient-primary text-white hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium">
                        <i class="fas fa-plus"></i>{{ __('Ajouter un rendez-vous') }}
                    </button>
                @endif
            </div>
        @else
            <div class="space-y-3" id="rendezvousTable">
                @foreach ($rendezVous as $rdv)
                    {{-- Store status in data attribute so JS can read it --}}
                    <div class="rendezvous-row group flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200 hover:border-gray-300 shadow-sm hover:shadow-lg transition-all duration-300 cursor-pointer"
                         onclick="window.location='{{ route('rendezvous.show', $rdv->id) }}'"
                         data-rendezvous-id="{{ $rdv->id }}"
                         data-rendezvous-status="{{ $rdv->statut }}">

                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-11 h-11 gradient-primary rounded-full flex items-center justify-center shadow-md shrink-0">
                                <i class="fas fa-calendar-check text-white text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-1">
                                    <h3 class="text-base font-semibold text-gray-900 truncate">
                                        {{ $rdv->patient->name }} → {{ $rdv->medecin->name }}
                                    </h3>
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full border shadow-sm shrink-0
                                        @if($rdv->statut == 'confirme') bg-green-50 text-green-600 border-green-200
                                        @elseif($rdv->statut == 'annule') bg-red-50 text-red-600 border-red-200
                                        @else bg-yellow-50 text-yellow-600 border-yellow-200 @endif">
                                        {{ ucfirst($rdv->statut) }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-stethoscope text-xs"></i>
                                        <span>{{ $rdv->service->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-calendar-alt text-xs"></i>
                                        <span>{{ $rdv->date_heure->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden lg:flex items-center gap-2 ml-4">
                                <span class="text-xs font-medium text-gray-400">{{ __('Cliquer pour voir') }}</span>
                                <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0 ml-4" onclick="event.stopPropagation()">
                            <button type="button"
                                class="rdv-action-btn p-2 rounded-lg hover:bg-gray-100 transition-all duration-200"
                                data-id="{{ $rdv->id }}"
                                data-status="{{ $rdv->statut }}"
                                aria-label="{{ __('Actions') }}">
                                <i class="fas fa-ellipsis-v text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden mt-4 p-4 bg-blue-50/50 border border-blue-100 rounded-xl">
                <p class="text-sm text-blue-600 text-center font-medium">
                    {{ __('Appuyer pour voir • Menu ⋮ pour les actions') }}
                </p>
            </div>
        @endif
    </div>

    {{-- Hidden forms for confirm/cancel (admins) --}}
    @if($isAdmin)
        <form id="confirmForm" action="" method="POST" class="hidden">
            @csrf
            @method('PATCH')
        </form>
        <form id="cancelForm" action="" method="POST" class="hidden">
            @csrf
            @method('PATCH')
        </form>
    @endif

    {{-- MODAL — Ajouter --}}
    @if($canCreate)
        <div id="formAjoute" class="fixed inset-0 z-[10000] hidden items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                <div class="h-1.5 gradient-primary"></div>
                <div class="p-6">
                    <div class="flex items-start gap-4 mb-5">
                        <div class="p-3 rounded-xl bg-blue-50 border border-blue-100 shadow-sm">
                            <i class="fas fa-calendar-plus text-blue-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900">{{ __('Ajouter un rendez-vous') }}</h3>
                            <p class="text-gray-500 text-sm mt-1">{{ __('Remplissez les informations ci-dessous') }}</p>
                        </div>
                        <button onclick="hideAjouteModal()" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form action="{{ route('rendezvous.store') }}" method="POST" class="space-y-4">
                        @csrf
                        @if($isAdmin)
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Patient') }} <span class="text-red-500">*</span></label>
                                <select name="patient_id" required class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all bg-gray-50 focus:bg-white">
                                    <option value="">{{ __('Sélectionner un patient') }}</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="patient_id" value="{{ $currentUser->id }}">
                            <div class="p-3 rounded-xl bg-blue-50 border border-blue-100 text-sm text-blue-700">
                                <span class="font-semibold">{{ __('Patient') }}:</span> {{ $currentUser->name }}
                            </div>
                        @endif
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Médecin') }} <span class="text-red-500">*</span></label>
                            <select name="medecin_id" required class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all bg-gray-50 focus:bg-white">
                                <option value="">{{ __('Sélectionner un médecin') }}</option>
                                @foreach ($medecins as $medecin)
                                    <option value="{{ $medecin->id }}">{{ $medecin->name }} ({{ $medecin->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Service') }} <span class="text-red-500">*</span></label>
                            <select name="service_id" required class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all bg-gray-50 focus:bg-white">
                                <option value="">{{ __('Sélectionner un service') }}</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Date et heure') }} <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center pointer-events-none">
                                    <i class="fas fa-clock text-purple-400 text-xs"></i>
                                </div>
                                <input type="datetime-local" name="date_heure" required
                                    class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all bg-gray-50 focus:bg-white">
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button type="button" onclick="hideAjouteModal()"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-300 font-medium hover:border-gray-400 text-sm">
                                <i class="fas fa-times text-xs"></i> {{ __('Annuler') }}
                            </button>
                            <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl gradient-primary text-white hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium text-sm">
                                <i class="fas fa-save text-xs"></i> {{ __('Créer') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL — Supprimer --}}
    <div id="modalDelete" class="fixed inset-0 z-[10000] hidden items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
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

    <style>
        #rdvDropdown {
            position: fixed !important;
            z-index: 999999 !important;
            min-width: 220px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.18), 0 4px 16px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            padding: 6px 0;
            display: none;
        }
        #rdvDropdown.rdv-open { display: block; animation: rdvFade 0.12s ease-out; }
        @keyframes rdvFade { from { opacity:0; transform:scale(0.96) translateY(-4px); } to { opacity:1; transform:scale(1) translateY(0); } }
        .rdv-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 14px; cursor: pointer;
            border: none; background: none; width: 100%;
            text-align: left; text-decoration: none; color: inherit;
            font-size: 13px;
        }
        .rdv-item:hover { background: #f9fafb; }
        .rdv-item.rdv-danger:hover { background: #fef2f2; }
        .rdv-item.rdv-confirm:hover { background: #f0fdf4; }
        .rdv-item.rdv-cancelitem:hover { background: #fffbeb; }
        .rdv-item.rdv-disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }
        .rdv-ico { width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:11px; }
        .rdv-label { font-weight:500; }
        .rdv-sub { font-size:11px; color:#9ca3af; margin-top:1px; }
        .rdv-hr { height:1px; background:#f3f4f6; margin:4px 0; }
    </style>

    <script>
        const isAdmin = @json($isAdmin);
        let currentRdvId   = null;
        let currentRdvStatus = null;

        /* ── Build dropdown once, insert DIRECTLY into <body> ── */
        const rdvDrop = document.createElement('div');
        rdvDrop.id = 'rdvDropdown';
        rdvDrop.innerHTML = `
            <a href="#" id="rdvView" class="rdv-item">
                <div class="rdv-ico" style="background:#eff6ff"><i class="fas fa-eye" style="color:#3b82f6"></i></div>
                <div><div class="rdv-label" style="color:#111827">{{ __('Voir') }}</div><div class="rdv-sub">{{ __('Détails du rendez-vous') }}</div></div>
            </a>
            ${isAdmin ? `
            <a href="#" id="rdvEdit" class="rdv-item">
                <div class="rdv-ico" style="background:#ecfdf5"><i class="fas fa-edit" style="color:#10b981"></i></div>
                <div><div class="rdv-label" style="color:#111827">{{ __('Modifier') }}</div><div class="rdv-sub">{{ __('Éditer le rendez-vous') }}</div></div>
            </a>
            <button id="rdvConfirm" class="rdv-item rdv-confirm">
                <div class="rdv-ico" style="background:#dcfce7"><i class="fas fa-check" style="color:#16a34a"></i></div>
                <div><div class="rdv-label" style="color:#15803d">{{ __('Confirmer') }}</div><div class="rdv-sub" style="color:#4ade80">{{ __('Valider ce rendez-vous') }}</div></div>
            </button>
            <button id="rdvCancel" class="rdv-item rdv-cancelitem">
                <div class="rdv-ico" style="background:#fef3c7"><i class="fas fa-ban" style="color:#d97706"></i></div>
                <div><div class="rdv-label" style="color:#b45309">{{ __('Annuler') }}</div><div class="rdv-sub" style="color:#f59e0b">{{ __('Annuler ce rendez-vous') }}</div></div>
            </button>
            <div class="rdv-hr"></div>
            ` : ''}
            <button id="rdvDelete" class="rdv-item rdv-danger">
                <div class="rdv-ico" style="background:#fee2e2"><i class="fas fa-trash-alt" style="color:#dc2626"></i></div>
                <div><div class="rdv-label" style="color:#b91c1c">{{ __('Supprimer') }}</div><div class="rdv-sub">{{ __('Action irréversible') }}</div></div>
            </button>
        `;
        /* Append straight to body — no layout parent can trap it */
        document.body.appendChild(rdvDrop);

        function rdvClose() { rdvDrop.classList.remove('rdv-open'); }

        document.addEventListener('click', e => {
            if (!rdvDrop.contains(e.target) && !e.target.closest('.rdv-action-btn')) rdvClose();
        });

        document.querySelectorAll('.rdv-action-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();

                currentRdvId     = this.dataset.id;
                currentRdvStatus = this.dataset.status; // 'confirme' | 'annule' | 'en_attente'

                /* Update static links */
                document.getElementById('rdvView').href = `/rendezvous/${currentRdvId}`;
                if (isAdmin) {
                    document.getElementById('rdvEdit').href = `/rendezvous/${currentRdvId}/edit`;

                    /* ── Smart disable: hide confirm if already confirmed,
                              hide cancel if already cancelled ── */
                    const confirmBtn = document.getElementById('rdvConfirm');
                    const cancelBtn  = document.getElementById('rdvCancel');

                    if (currentRdvStatus === 'confirme') {
                        confirmBtn.classList.add('rdv-disabled');
                        cancelBtn.classList.remove('rdv-disabled');
                    } else if (currentRdvStatus === 'annule') {
                        cancelBtn.classList.add('rdv-disabled');
                        confirmBtn.classList.remove('rdv-disabled');
                    } else {
                        confirmBtn.classList.remove('rdv-disabled');
                        cancelBtn.classList.remove('rdv-disabled');
                    }
                }

                /* ── Position: below button, flip up if near bottom ── */
                const r  = this.getBoundingClientRect();
                const W  = window.innerWidth;
                const H  = window.innerHeight;
                const mW = 230;
                const mH = isAdmin ? 290 : 110;

                let left = r.right - mW;
                if (left < 8)       left = 8;
                if (left + mW > W - 8) left = W - mW - 8;

                let top = r.bottom + 6;
                if (top + mH > H - 8) top = r.top - mH - 6;
                if (top < 8) top = 8;

                rdvDrop.style.left = left + 'px';
                rdvDrop.style.top  = top  + 'px';
                rdvDrop.classList.remove('rdv-open');
                void rdvDrop.offsetWidth; /* force reflow for animation */
                rdvDrop.classList.add('rdv-open');
            });
        });

        @if($isAdmin)
        document.getElementById('rdvConfirm').addEventListener('click', function() {
            rdvClose();
            if (currentRdvId) {
                const f = document.getElementById('confirmForm');
                f.action = `/rendezvous/${currentRdvId}/confirm`;
                f.submit();
            }
        });
        document.getElementById('rdvCancel').addEventListener('click', function() {
            rdvClose();
            if (currentRdvId) {
                const f = document.getElementById('cancelForm');
                f.action = `/rendezvous/${currentRdvId}/cancel`;
                f.submit();
            }
        });
        @endif

        document.getElementById('rdvDelete').addEventListener('click', function() {
            rdvClose();
            if (currentRdvId) {
                document.getElementById('deleteForm').action = `/rendezvous/${currentRdvId}`;
                const m = document.getElementById('modalDelete');
                m.classList.remove('hidden');
                m.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        });

        function closeDeleteModal() {
            const m = document.getElementById('modalDelete');
            m.classList.add('hidden');
            m.classList.remove('flex');
            document.body.style.overflow = '';
        }
        document.getElementById('modalDelete')?.addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        /* Add modal */
        const ajouteModal = document.getElementById('formAjoute');
        function showAjouteModal() {
            if (ajouteModal) { ajouteModal.classList.remove('hidden'); ajouteModal.classList.add('flex'); document.body.style.overflow = 'hidden'; }
        }
        function hideAjouteModal() {
            if (ajouteModal) { ajouteModal.classList.add('hidden'); ajouteModal.classList.remove('flex'); document.body.style.overflow = ''; }
        }
        ajouteModal?.addEventListener('click', e => { if (e.target === ajouteModal) hideAjouteModal(); });

        /* Search */
        document.getElementById('searchInput')?.addEventListener('keyup', function () {
            const term = this.value.toLowerCase();
            let count = 0;
            document.querySelectorAll('#rendezvousTable .rendezvous-row').forEach(row => {
                const visible = row.innerText.toLowerCase().includes(term);
                row.style.display = visible ? '' : 'none';
                if (visible) count++;
            });
            const vc = document.getElementById('visibleCount');
            if (vc) vc.textContent = count;
        });
    </script>
</x-app-layout>