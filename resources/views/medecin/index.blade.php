{{-- resources/views/medecins/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div class="p-4 rounded-2xl gradient-primary shadow-lg">
                        <i class="fas fa-user-md text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ __('Médecins') }}</h1>
                        <p class="text-gray-500 mt-1">
                            {{ __('Total :') }} <span class="font-bold text-gray-900">{{ $medecins->count() }}</span>
                            {{ __('médecin(s)') }}
                        </p>
                    </div>
                </div>
            </div>
            <button onclick="showAjouteModal()"
                class="group inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl gradient-primary text-white hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 font-semibold shadow-md text-sm">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                {{ __('Ajouter un médecin') }}
            </button>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- Alerts --}}
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

        {{-- Search + counter bar --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex-1 max-w-2xl">
                <div class="relative group">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="searchInput"
                        placeholder="{{ __('Rechercher un médecin...') }}"
                        class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400/20 focus:border-blue-400 transition-all duration-300 shadow-sm text-sm">
                </div>
            </div>
            <div class="hidden md:flex items-center gap-3 text-sm text-gray-600 bg-gray-50 px-4 py-2.5 rounded-lg border border-gray-200">
                <span>{{ __('Affichage') }}</span>
                <span class="font-bold text-gray-900" id="visibleCount">{{ $medecins->count() }}</span>
                <span>{{ __('sur') }}</span>
                <span class="font-bold text-gray-900">{{ $medecins->count() }}</span>
            </div>
        </div>

        {{-- Médecin rows --}}
        @if($medecins->isEmpty())
            <div class="text-center py-16 lg:py-20">
                <div class="inline-flex p-6 rounded-2xl bg-blue-50 mb-6">
                    <i class="fas fa-user-md text-blue-400 text-5xl"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-semibold text-gray-800 mb-3">{{ __('Aucun médecin trouvé') }}</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-8">{{ __('Ajoutez votre premier médecin pour commencer.') }}</p>
                <button onclick="showAjouteModal()"
                    class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl gradient-primary text-white hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium">
                    <i class="fas fa-plus"></i>{{ __('Ajouter le premier médecin') }}
                </button>
            </div>
        @else
            <div class="space-y-3" id="medecinsTable">
                @foreach ($medecins as $index => $p)
                    <div class="medecin-row group flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200 hover:border-gray-300 shadow-sm hover:shadow-lg transition-all duration-300 cursor-pointer"
                         onclick="window.location='{{ route('medecin.show', $p->id) }}'"
                         data-medecin-id="{{ $p->id }}"
                         data-medecin-name="{{ $p->name }}"
                         data-medecin-email="{{ $p->email }}"
                         data-medecin-phone="{{ $p->phone }}">

                        {{-- Left: avatar + info --}}
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-11 h-11 gradient-primary rounded-full flex items-center justify-center shadow-md shrink-0">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-1">
                                    <h3 class="text-base font-semibold text-gray-900 truncate">{{ $p->name }}</h3>
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-blue-50 text-blue-600 border border-blue-100 shadow-sm shrink-0">
                                        #{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-envelope text-xs"></i>
                                        <span>{{ $p->email }}</span>
                                    </div>
                                    @if ($p->phone)
                                        <div class="flex items-center gap-1.5">
                                            <i class="fas fa-phone text-xs"></i>
                                            <span>{{ $p->phone }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-calendar-alt text-xs"></i>
                                        <span>{{ $p->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Desktop hint --}}
                            <div class="hidden lg:flex items-center gap-2 ml-4">
                                <span class="text-xs font-medium text-gray-400">{{ __('Cliquer pour voir') }}</span>
                                <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                            </div>
                        </div>

                        {{-- Action menu button --}}
                        <div class="flex items-center gap-2 shrink-0 ml-4" onclick="event.stopPropagation()">
                            <button type="button"
                                class="action-menu-btn p-2 rounded-lg hover:bg-gray-100 transition-all duration-200"
                                data-medecin-id="{{ $p->id }}"
                                aria-label="{{ __('Actions') }}">
                                <i class="fas fa-ellipsis-v text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="lg:hidden mt-4 p-4 bg-blue-50/50 border border-blue-100 rounded-xl">
                <p class="text-sm text-blue-600 text-center font-medium">
                    {{ __('Appuyer pour voir • Menu pour les actions') }}
                </p>
            </div>

            @if(method_exists($medecins, 'links') && $medecins->hasPages())
                <div class="mt-4">{{ $medecins->links() }}</div>
            @endif
        @endif
    </div>

    {{-- Floating Action Menu (rendered at body level) --}}
    <div id="floatingActionMenu" class="fixed z-[9999] hidden bg-white rounded-xl shadow-2xl border border-gray-200 py-2" style="min-width: 220px;">
        <a href="#" id="menuView" class="group flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-all duration-200">
            <div class="p-2 rounded-lg bg-blue-50 group-hover:scale-110 transition-transform duration-200">
                <i class="fas fa-eye text-blue-500 text-xs"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">{{ __('Voir') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ __('Fiche complète') }}</p>
            </div>
        </a>
        <a href="#" id="menuEdit" class="group flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-all duration-200">
            <div class="p-2 rounded-lg bg-emerald-50 group-hover:scale-110 transition-transform duration-200">
                <i class="fas fa-edit text-emerald-500 text-xs"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">{{ __('Modifier') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ __('Éditer les infos') }}</p>
            </div>
        </a>
        <div class="h-px bg-gray-100 my-1"></div>
        <button type="button" id="menuDelete" class="group flex items-center gap-3 px-4 py-3 hover:bg-red-50 transition-all duration-200 w-full text-left">
            <div class="p-2 rounded-lg bg-red-100 group-hover:scale-110 transition-transform duration-200">
                <i class="fas fa-trash-alt text-red-600 text-xs"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-red-700">{{ __('Supprimer') }}</p>
                <p class="text-xs text-red-400 mt-0.5">{{ __('Action irréversible') }}</p>
            </div>
        </button>
    </div>

    {{-- MODAL — Ajouter --}}
    <div id="formAjoute" class="fixed inset-0 z-[10000] hidden items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
            <div class="h-1.5 gradient-primary"></div>
            <div class="p-6">
                <div class="flex items-start gap-4 mb-5">
                    <div class="p-3 rounded-xl bg-blue-50 border border-blue-100 shadow-sm">
                        <i class="fas fa-user-plus text-blue-600 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900">{{ __('Ajouter un médecin') }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ __('Remplissez les informations du médecin') }}</p>
                    </div>
                    <button onclick="hideAjouteModal()" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('medecin.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Nom complet') }} <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center pointer-events-none">
                                <i class="fas fa-user text-blue-400 text-xs"></i>
                            </div>
                            <input type="text" name="name" required placeholder="{{ __('Dr. Martin') }}"
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all bg-gray-50 focus:bg-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Email') }} <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center pointer-events-none">
                                <i class="fas fa-envelope text-blue-400 text-xs"></i>
                            </div>
                            <input type="email" name="email" required placeholder="{{ __('dr.martin@clinique.com') }}"
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all bg-gray-50 focus:bg-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Téléphone') }}</label>
                        <div class="relative">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-emerald-50 rounded-lg flex items-center justify-center pointer-events-none">
                                <i class="fas fa-phone text-emerald-400 text-xs"></i>
                            </div>
                            <input type="text" name="phone" placeholder="{{ __('06 12 34 56 78') }}"
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all bg-gray-50 focus:bg-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Mot de passe') }} <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center pointer-events-none">
                                <i class="fas fa-key text-purple-400 text-xs"></i>
                            </div>
                            <input type="password" name="password" required
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
                            <i class="fas fa-user-plus text-xs"></i> {{ __('Ajouter') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                        <h3 class="text-xl font-bold text-gray-900">{{ __('Supprimer le médecin') }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ __('Confirmer la suppression') }}</p>
                    </div>
                </div>
                <div class="mb-6 p-4 bg-red-50 rounded-xl border border-red-200">
                    <p class="text-gray-700 text-sm leading-relaxed">{{ __('Êtes-vous sûr de vouloir supprimer ce médecin ?') }}</p>
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
        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        
        /* Dropdown animation */
        .dropdown-appear {
            animation: dropdownAppear 0.15s ease-out;
        }
        @keyframes dropdownAppear {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>

    <script>
        // Floating menu elements
        const floatingMenu = document.getElementById('floatingActionMenu');
        let currentMedecinId = null;

        // Close floating menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!floatingMenu.contains(e.target) && !e.target.closest('.action-menu-btn')) {
                floatingMenu.classList.add('hidden');
            }
        });

        // Handle action menu button clicks
        document.querySelectorAll('.action-menu-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                
                const medecinId = this.dataset.medecinId;
                const row = this.closest('.medecin-row');
                const medecinName = row?.dataset.medecinName || '';
                const medecinEmail = row?.dataset.medecinEmail || '';
                const medecinPhone = row?.dataset.medecinPhone || '';
                
                currentMedecinId = medecinId;
                
                // Update menu links
                document.getElementById('menuView').href = `/medecin/${medecinId}`;
                document.getElementById('menuEdit').href = `/medecin/${medecinId}/edit`;
                
                // Get button position
                const rect = this.getBoundingClientRect();
                const viewportWidth = window.innerWidth;
                const menuWidth = 220;
                
                // Calculate position (prefer right-aligned, but adjust if off screen)
                let leftPos = rect.right - menuWidth;
                if (leftPos < 10) leftPos = 10;
                if (leftPos + menuWidth > viewportWidth - 10) leftPos = viewportWidth - menuWidth - 10;
                
                // Position the menu below the button
                floatingMenu.style.position = 'fixed';
                floatingMenu.style.top = (rect.bottom + 8) + 'px';
                floatingMenu.style.left = leftPos + 'px';
                floatingMenu.classList.remove('hidden');
                floatingMenu.classList.add('dropdown-appear');
                
                // Remove animation class after it completes
                setTimeout(() => {
                    floatingMenu.classList.remove('dropdown-appear');
                }, 150);
            });
        });

        // Delete modal functions
        const deleteModal = document.getElementById('modalDelete');
        
        document.getElementById('menuDelete').addEventListener('click', function(e) {
            e.preventDefault();
            floatingMenu.classList.add('hidden');
            if (currentMedecinId) {
                document.getElementById('deleteForm').action = `/medecin/${currentMedecinId}`;
                deleteModal.classList.remove('hidden');
                deleteModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        });
        
        function closeDeleteModal() { 
            deleteModal.classList.add('hidden'); 
            deleteModal.classList.remove('flex'); 
            document.body.style.overflow = ''; 
        }
        
        deleteModal?.addEventListener('click', e => { 
            if (e.target === deleteModal) closeDeleteModal(); 
        });

        // Add modal
        const ajouteModal = document.getElementById('formAjoute');
        const showAjouteModal = () => { ajouteModal.classList.remove('hidden'); ajouteModal.classList.add('flex'); document.body.style.overflow = 'hidden'; };
        const hideAjouteModal = () => { ajouteModal.classList.add('hidden'); ajouteModal.classList.remove('flex'); document.body.style.overflow = ''; };
        ajouteModal?.addEventListener('click', e => { if (e.target === ajouteModal) hideAjouteModal(); });

        // Search
        const searchInput = document.getElementById('searchInput');
        const visibleCount = document.getElementById('visibleCount');
        searchInput?.addEventListener('keyup', function () {
            const term = this.value.toLowerCase();
            let count = 0;
            document.querySelectorAll('#medecinsTable .medecin-row').forEach(row => {
                const visible = row.innerText.toLowerCase().includes(term);
                row.style.display = visible ? '' : 'none';
                if (visible) count++;
            });
            if (visibleCount) visibleCount.textContent = count;
        });
    </script>
</x-app-layout>