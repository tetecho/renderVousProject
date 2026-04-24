{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}
<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        {{-- Nom --}}
        <div>
            <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                {{ __('Nom complet') }} <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center pointer-events-none border border-indigo-100">
                    <i class="fas fa-user text-indigo-400 text-xs"></i>
                </div>
                <input id="name" name="name" type="text"
                    value="{{ old('name', $user->name) }}"
                    required autofocus autocomplete="name"
                    class="w-full pl-14 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400/30 focus:border-indigo-400 transition-all duration-300 bg-gray-50 focus:bg-white">
            </div>
            <x-input-error class="mt-1.5 text-xs" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                {{ __('Adresse email') }} <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute left-3.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center pointer-events-none border border-blue-100">
                    <i class="fas fa-envelope text-blue-400 text-xs"></i>
                </div>
                <input id="email" name="email" type="email"
                    value="{{ old('email', $user->email) }}"
                    required autocomplete="username"
                    class="w-full pl-14 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400/30 focus:border-indigo-400 transition-all duration-300 bg-gray-50 focus:bg-white">
            </div>
            <x-input-error class="mt-1.5 text-xs" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                    <p class="text-sm text-amber-700 flex flex-wrap items-start gap-1">
                        <i class="fas fa-exclamation-triangle mt-0.5 shrink-0 text-amber-500"></i>
                        {{ __('Votre adresse email n\'est pas vérifiée.') }}
                        <button form="send-verification" class="underline font-semibold hover:text-amber-900 transition">
                            {{ __('Renvoyer le lien de vérification') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-emerald-600 font-medium flex items-center gap-1.5">
                            <i class="fas fa-check-circle"></i>
                            {{ __('Lien de vérification envoyé avec succès !') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl gradient-primary text-white hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-semibold text-sm">
                <i class="fas fa-save text-xs"></i>
                {{ __('Enregistrer') }}
            </button>

            @if (session('status') === 'profile-updated')
                <span x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm text-emerald-600 font-medium flex items-center gap-1.5">
                    <i class="fas fa-check-circle"></i>
                    {{ __('Modifications enregistrées !') }}
                </span>
            @endif
        </div>
    </form>
</section>