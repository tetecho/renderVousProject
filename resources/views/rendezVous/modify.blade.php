<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('rendezvous.index') }}" 
               class="p-2 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-300">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="p-4 rounded-2xl gradient-primary shadow-lg">
                <i class="fas fa-edit text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ __('Modifier le rendez-vous') }}</h1>
                <p class="text-gray-500 mt-1">#{{ $rendezVous->id }} • {{ $rendezVous->date_heure->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="h-1.5 gradient-primary"></div>
            <div class="p-6">
                <form action="{{ route('rendezvous.update', $rendezVous->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Patient') }} <span class="text-red-500">*</span></label>
                        <select name="patient_id" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all bg-gray-50 focus:bg-white">
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}" {{ $rendezVous->patient_id == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }} ({{ $patient->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Médecin') }} <span class="text-red-500">*</span></label>
                        <select name="medecin_id" id="medecinSelect" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all bg-gray-50 focus:bg-white">
                            @foreach ($medecins as $medecin)
                                <option value="{{ $medecin->id }}" {{ $rendezVous->medecin_id == $medecin->id ? 'selected' : '' }}>
                                    {{ $medecin->name }} ({{ $medecin->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Service') }} <span class="text-red-500">*</span></label>
                        <select name="service_id" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all bg-gray-50 focus:bg-white">
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" {{ $rendezVous->service_id == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Date et heure') }} <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center pointer-events-none">
                                <i class="fas fa-clock text-purple-400 text-xs"></i>
                            </div>
                            <input type="datetime-local" name="date_heure" required value="{{ $rendezVous->date_heure->format('Y-m-d\TH:i') }}"
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all bg-gray-50 focus:bg-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ __('Statut') }} <span class="text-red-500">*</span></label>
                        <select name="statut" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition-all bg-gray-50 focus:bg-white">
                            <option value="en_attente" {{ $rendezVous->statut == 'en_attente' ? 'selected' : '' }}>{{ __('En attente') }}</option>
                            <option value="confirme" {{ $rendezVous->statut == 'confirme' ? 'selected' : '' }}>{{ __('Confirmé') }}</option>
                            <option value="annule" {{ $rendezVous->statut == 'annule' ? 'selected' : '' }}>{{ __('Annulé') }}</option>
                        </select>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <a href="{{ route('rendezvous.index') }}"
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-300 font-medium hover:border-gray-400 text-sm text-center">
                            <i class="fas fa-times text-xs"></i> {{ __('Annuler') }}
                        </a>
                        <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl gradient-primary text-white hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium text-sm">
                            <i class="fas fa-save text-xs"></i> {{ __('Mettre à jour') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Optional doctor availability check on date/medecin change
        const dateInput = document.querySelector('input[name="date_heure"]');
        const medecinSelect = document.querySelector('#medecinSelect');
        if (dateInput && medecinSelect) {
            async function checkAvailability() {
                const date = dateInput.value;
                const medecinId = medecinSelect.value;
                if (!date || !medecinId) return;
                try {
                    const response = await fetch(`/rendezvous/available-doctors?date_heure=${encodeURIComponent(date)}&exclude_id={{ $rendezVous->id }}`);
                    const available = await response.json();
                    if (!available.some(doc => doc.id == medecinId)) {
                        alert('{{ __("Ce médecin est déjà occupé à cette heure. Veuillez choisir un autre créneau.") }}');
                    }
                } catch (err) { console.error(err); }
            }
            dateInput.addEventListener('change', checkAvailability);
            medecinSelect.addEventListener('change', checkAvailability);
        }
    </script>
</x-app-layout>