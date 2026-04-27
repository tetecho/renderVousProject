<x-app-layout>
    @php($currentUser = auth()->user())

    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div class="p-4 rounded-2xl gradient-primary shadow-lg">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ __('tableau_de_bord') }}</h1>
                        <p class="text-gray-500 mt-1">{{ __('apercu_general_clinique') }}</p>
                    </div>
                </div>
            </div>
            <div class="text-sm text-gray-500 bg-white/50 px-4 py-2 rounded-lg">
                {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">

        {{-- Statistiques (cartes) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('patients') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $numberPatient }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('medecins') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $numberMedecin }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-user-md text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('total_rendez_vous') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalRdv }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-cyan-100 flex items-center justify-center">
                        <i class="fas fa-calendar-check text-cyan-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('rendez_vous_aujourdhui') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $todayRdv }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center">
                        <i class="fas fa-calendar-day text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cartes par statut (confirmé, en attente, annulé) --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-green-50 to-white rounded-xl border border-green-200 shadow-sm p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-semibold">{{ __('confirme') }}</p>
                        <p class="text-2xl font-bold text-green-700 mt-1">{{ $rdvConfirmed }}</p>
                    </div>
                    <i class="fas fa-check-circle text-green-500 text-3xl"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-yellow-50 to-white rounded-xl border border-yellow-200 shadow-sm p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-600 text-sm font-semibold">{{ __('en_attente') }}</p>
                        <p class="text-2xl font-bold text-yellow-700 mt-1">{{ $rdvPending }}</p>
                    </div>
                    <i class="fas fa-clock text-yellow-500 text-3xl"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-red-50 to-white rounded-xl border border-red-200 shadow-sm p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 text-sm font-semibold">{{ __('annule') }}</p>
                        <p class="text-2xl font-bold text-red-700 mt-1">{{ $rdvCancelled }}</p>
                    </div>
                    <i class="fas fa-ban text-red-500 text-3xl"></i>
                </div>
            </div>
        </div>

        {{-- Deux colonnes : prochains RDV & derniers RDV --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Prochains rendez-vous --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-calendar-week mr-2 text-blue-500"></i> {{ __('prochains_rendez_vous') }}
                    </h2>
                    <span class="text-xs text-gray-400">{{ __('5_prochains') }}</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($upcomingRdv as $rdv)
                        <div class="p-4 hover:bg-gray-50 transition duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ $rdv->patient->name }} → {{ $rdv->medecin->name }}
                                    </p>
                                    <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                                        <span><i class="fas fa-stethoscope mr-1"></i> {{ $rdv->service->name }}</span>
                                        <span><i class="fas fa-calendar-alt mr-1"></i>
                                            {{ $rdv->date_heure->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full 
                                            @if($rdv->statut == 'confirme') bg-green-100 text-green-700
                                            @elseif($rdv->statut == 'annule') bg-red-100 text-red-700
                                            @else bg-yellow-100 text-yellow-700 @endif">
                                    {{ __($rdv->statut) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-400">
                            <i class="fas fa-calendar-times text-3xl mb-2"></i>
                            <p>{{ __('aucun_rendez_vous_a_venir') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Derniers rendez-vous --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-history mr-2 text-purple-500"></i> {{ __('derniers_rendez_vous') }}
                    </h2>
                    <span class="text-xs text-gray-400">{{ __('5_derniers') }}</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentRdv as $rdv)
                        <div class="p-4 hover:bg-gray-50 transition duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ $rdv->patient->name }} → {{ $rdv->medecin->name }}
                                    </p>
                                    <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                                        <span><i class="fas fa-stethoscope mr-1"></i> {{ $rdv->service->name }}</span>
                                        <span><i class="fas fa-calendar-alt mr-1"></i>
                                            {{ $rdv->date_heure->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full 
                                            @if($rdv->statut == 'confirme') bg-green-100 text-green-700
                                            @elseif($rdv->statut == 'annule') bg-red-100 text-red-700
                                            @else bg-yellow-100 text-yellow-700 @endif">
                                    {{ __($rdv->statut) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-400">
                            <i class="fas fa-database text-3xl mb-2"></i>
                            <p>{{ __('aucun_rendez_vous_enregistre') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Graphique mensuel --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-line mr-2 text-indigo-500"></i> {{ __('apercu_rendez_vous') }}
            </h2>
            <canvas id="appointmentsChart" class="w-full h-64"></canvas>
        </div>



    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('appointmentsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($months),
                    datasets: [{
                        label: '{{ __("nombre_rendez_vous") }}',
                        data: @json($appointmentsCount),
                        backgroundColor: 'rgba(59, 130, 246, 0.6)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { callbacks: { label: (ctx) => `${ctx.raw} {{ __('rendez_vous') }}` } }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }
                    }
                }
            });
        });
    </script>
</x-app-layout>