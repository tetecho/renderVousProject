<x-guest-layout>
    <div class="text-center mb-8">
        <div class="inline-flex items-center bg-blue-100 rounded-full px-4 py-2 mb-4">
            <i class="fas fa-envelope-open-text text-blue-600 mr-2"></i>
            <span class="text-blue-600 text-sm font-semibold">Vérification email</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Vérifiez votre email</h2>
        <div class="bg-blue-50 rounded-xl p-4 mb-4">
            <i class="fas fa-info-circle text-blue-600 text-lg mb-2"></i>
            <p class="text-gray-600 text-sm leading-relaxed">
                {{ __('Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous vous avons envoyé.') }}
            </p>
        </div>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                <p class="text-sm text-green-700">
                    {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                </p>
            </div>
        </div>
    @endif

    <div class="flex flex-col gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full justify-center py-3 gradient-bg text-white rounded-xl font-bold hover:shadow-xl transition-all duration-300 shine-effect">
                <i class="fas fa-paper-plane mr-2"></i>
                {{ __('Renvoyer l\'email de vérification') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-3 text-gray-600 hover:text-gray-900 font-semibold transition duration-300 flex items-center justify-center gap-2">
                <i class="fas fa-sign-out-alt"></i>
                {{ __('Se déconnecter') }}
            </button>
        </form>
    </div>
</x-guest-layout>