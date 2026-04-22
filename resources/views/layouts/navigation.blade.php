<nav x-data="{ open: false }"
    class="bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- Logo --}}
            <div class="shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl
                                flex items-center justify-center shadow-md
                                group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-stethoscope text-white text-base"></i>
                    </div>
                    <span class="font-bold text-lg bg-gradient-to-r from-indigo-600 to-purple-600
                                 bg-clip-text text-transparent hidden sm:block">
                        {{ __('Cabinet Médical') }}
                    </span>
                </a>
            </div>

            {{-- Desktop links --}}
            <div class="hidden sm:flex items-center space-x-1">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200">
                    <i class="fas fa-tachometer-alt text-xs"></i>
                    {{ __('Tableau de bord') }}
                </x-nav-link>
            </div>

            {{-- Desktop user dropdown --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-3">
                <x-dropdown align="right" width="52">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 px-3 py-2 rounded-xl border border-gray-200
                                       text-sm font-medium text-gray-700 bg-white
                                       hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-700
                                       transition-all duration-200 focus:outline-none">
                            <div class="w-7 h-7 bg-gradient-to-br from-indigo-500 to-purple-600
                                        rounded-full flex items-center justify-center shrink-0">
                                <i class="fas fa-user text-white text-xs"></i>
                            </div>
                            <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0
                                       111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                            <i class="fas fa-user-circle text-gray-400 w-4"></i>
                            {{ __('Mon profil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center gap-2 text-red-600 hover:text-red-700">
                                <i class="fas fa-sign-out-alt w-4"></i>
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="p-2 rounded-xl text-gray-500 hover:text-indigo-600 hover:bg-indigo-50
                           transition-all duration-200 focus:outline-none"
                    aria-label="{{ __('Basculer le menu') }}">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="flex items-center gap-2">
                <i class="fas fa-tachometer-alt text-xs"></i>
                {{ __('Tableau de bord') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-100 px-4">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full
                            flex items-center justify-center shrink-0">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-semibold text-sm text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center gap-2">
                    <i class="fas fa-user-circle text-gray-400 w-4"></i>
                    {{ __('Mon profil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center gap-2 text-red-600">
                        <i class="fas fa-sign-out-alt w-4"></i>
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>