{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', __('Cabinet Médical')) }}</title>
    @vite(['resources/js/app.js'])
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        :root {
            --primary-50: #eff6ff;
            --primary-100: #dbeafe;
            --primary-200: #bfdbfe;
            --primary-300: #93c5fd;
            --primary-400: #60a5fa;
            --primary-500: #3b82f6;
            --primary-600: #2563eb;
            --primary-700: #1d4ed8;
        }

        .gradient-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
        }

        .gradient-success {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

        .gradient-danger {
            background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
        }

        .gradient-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.98) 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(203, 213, 225, 0.5);
            z-index: 1000;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }

        .sidebar-item {
            transition: all 0.25s ease;
            border-radius: 12px;
            position: relative;
        }

        .sidebar-item-active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.12) 0%, rgba(6, 182, 212, 0.12) 100%);
        }

        .sidebar-item-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 70%;
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
            border-radius: 0 4px 4px 0;
        }

        .sidebar-item-active .icon-wrapper {
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
        }

        .sidebar-item-active .icon-wrapper i {
            color: white !important;
        }

        .sidebar-item:not(.sidebar-item-active):hover {
            background: rgba(59, 130, 246, 0.05);
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        html[dir="rtl"] .sidebar {
            left: auto;
            right: 0;
            border-right: 0;
            border-left: 1px solid rgba(203, 213, 225, 0.5);
            direction: rtl;
        }

        html[dir="rtl"] .main-content {
            margin-left: 0;
            margin-right: 280px;
        }

        html[dir="rtl"] .sidebar-item-active::before {
            left: auto;
            right: 0;
            border-radius: 4px 0 0 4px;
        }

        html[dir="rtl"] #menuToggle {
            left: auto;
            right: 1.25rem;
        }

        /* RTL polish for sidebar spacing/alignment */
        html[dir="rtl"] .sidebar [class*="space-x-"] {
            --tw-space-x-reverse: 1;
        }

        html[dir="rtl"] .sidebar .sidebar-item,
        html[dir="rtl"] .sidebar .p-6>a,
        html[dir="rtl"] .sidebar .w-full.flex.items-center {
            flex-direction: row-reverse;
        }

        html[dir="rtl"] .sidebar .sidebar-item,
        html[dir="rtl"] .sidebar .sidebar-item span,
        html[dir="rtl"] .sidebar .p-6 h1,
        html[dir="rtl"] .sidebar .p-6 p,
        html[dir="rtl"] .sidebar .text-left {
            text-align: right;
        }

        html[dir="rtl"] .sidebar .sidebar-item .flex-1 {
            margin-left: 0;
        }

        html[dir="rtl"] .sidebar .sidebar-item .rounded-full {
            margin-right: auto;
            margin-left: 0;
        }

        @media (max-width: 1023px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            html[dir="rtl"] .sidebar {
                transform: translateX(100%);
            }

            html[dir="rtl"] .main-content {
                margin-right: 0;
            }
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 4px;
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out both;
        }

        .animate-slideIn {
            animation: slideIn 0.3s ease-out both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .bg-pattern {
            background-image: radial-gradient(circle at 1px 1px, rgba(59, 130, 246, 0.05) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(203, 213, 225, 0.5);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 via-white to-blue-50 bg-pattern min-h-screen">

    {{-- Mobile Menu Button --}}
    <button id="menuToggle"
        class="fixed top-5 left-5 z-50 lg:hidden p-3 bg-white rounded-xl shadow-lg text-gray-600 hover:text-blue-600 transition-all duration-300 hover:shadow-xl">
        <i class="fas fa-bars text-xl"></i>
    </button>

    {{-- Overlay --}}
    <div id="overlay" class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40 hidden lg:hidden"></div>

    {{-- Sidebar --}}
    <aside id="sidebar" class="sidebar">
        {{-- Logo --}}
        <div class="p-6 border-b border-slate-100">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                <div class="relative">
                    <div
                        class="w-12 h-12 gradient-primary rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-heartbeat text-white text-xl"></i>
                    </div>
                    <div class="absolute -inset-1 gradient-primary rounded-2xl opacity-30 blur-sm"></div>
                </div>
                <div>
                    <h1
                        class="text-xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent leading-tight">
                        {{ __('Cabinet Medical') }}
                    </h1>
                    <p class="text-xs text-gray-400 mt-0.5">{{ __('Soins & Excellence') }}</p>
                </div>
            </a>
        </div>

        {{-- Navigation --}}
        <div class="flex-1 p-4 space-y-6 overflow-y-auto">
            {{-- Main Menu --}}
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 mb-3">
                    {{ __('Menu Principal') }}
                </p>
                <a href="{{ route('dashboard') }}"
                    class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-xl text-gray-700 transition-all duration-200 {{ request()->routeIs('dashboard') ? 'sidebar-item-active' : '' }}">
                    <div
                        class="icon-wrapper w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('dashboard') ? 'gradient-primary' : 'bg-blue-50' }}">
                        <i
                            class="fas fa-chart-line text-sm {{ request()->routeIs('dashboard') ? 'text-white' : 'text-blue-500' }}"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">{{ __('Tableau de bord') }}</span>
                </a>
                <a href="{{ route('rendezvous.index') }}"
                    class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-xl text-gray-700 transition-all duration-200 {{ request()->routeIs('rendezvous.*') ? 'sidebar-item-active' : '' }}">
                    <div
                        class="icon-wrapper w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('rendezvous.*') ? 'gradient-primary' : 'bg-amber-50' }}">
                        <i
                            class="fas fa-calendar-check text-sm {{ request()->routeIs('rendezvous.*') ? 'text-white' : 'text-amber-600' }}"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">{{ __('Rendez-vous') }}</span>
                    <span
                        class="bg-gradient-danger text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ \App\Models\RendezVous::where('statut', 'en_attente')->count() }}</span>
                </a>
            </div>

            {{-- Management Section --}}
            @if (Auth::user()->role === 'admin')
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 mb-3">{{ __('Gestion') }}
                    </p>

                    <a href="{{ route('medecin.index') }}"
                        class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-xl text-gray-700 transition-all duration-200 {{ request()->routeIs('medecin.*') ? 'sidebar-item-active' : '' }}">
                        <div
                            class="icon-wrapper w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('medecin.*') ? 'gradient-primary' : 'bg-emerald-50' }}">
                            <i
                                class="fas fa-user-md text-sm {{ request()->routeIs('medecin.*') ? 'text-white' : 'text-emerald-600' }}"></i>
                        </div>
                        <span class="flex-1 text-sm font-medium">{{ __('Médecins') }}</span>
                    </a>

                    <a href="{{ route('patient.index') }}"
                        class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-xl text-gray-700 transition-all duration-200 {{ request()->routeIs('patient.*') ? 'sidebar-item-active' : '' }}">
                        <div
                            class="icon-wrapper w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('patient.*') ? 'gradient-primary' : 'bg-blue-50' }}">
                            <i
                                class="fas fa-users text-sm {{ request()->routeIs('patient.*') ? 'text-white' : 'text-blue-500' }}"></i>
                        </div>
                        <span class="flex-1 text-sm font-medium">{{ __('Patients') }}</span>
                    </a>
                </div>
            @endif

            {{-- Account Section --}}
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 mb-3">{{ __('Mon Espace') }}
                </p>
                <a href="{{ route('profile.edit') }}"
                    class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-xl text-gray-700 transition-all duration-200 {{ request()->routeIs('profile.*') ? 'sidebar-item-active' : '' }}">
                    <div
                        class="icon-wrapper w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('profile.*') ? 'gradient-primary' : 'bg-purple-50' }}">
                        <i
                            class="fas fa-user-circle text-sm {{ request()->routeIs('profile.*') ? 'text-white' : 'text-purple-500' }}"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">{{ __('Mon profil') }}</span>
                </a>
            </div>
        </div>

        {{-- User Profile --}}
        <div class="p-4 border-t border-slate-100 mt-auto">
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                    class="w-full flex items-center space-x-3 p-2.5 rounded-xl hover:bg-slate-50 transition-all duration-200">
                    <div class="relative">
                        <img class="w-10 h-10 rounded-xl object-cover border-2 border-white shadow-lg"
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&rounded=true&bold=true"
                            alt="Profile">
                        <div
                            class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-400 border-2 border-white rounded-full shadow-sm">
                        </div>
                    </div>
                    <div class="flex-1 min-w-0 text-left">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                        :class="{'rotate-180': open}"></i>
                </button>

                <div x-show="open" @click.outside="open = false" x-transition.opacity.duration.200ms
                    class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center space-x-3 px-4 py-3 hover:bg-slate-50 transition-colors">
                        <i class="fas fa-user-cog text-gray-400 w-4 text-sm"></i>
                        <span class="text-sm text-gray-700 font-medium">{{ __('Paramètres') }}</span>
                    </a>
                    <div class="border-t border-slate-100"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center space-x-3 px-4 py-3 hover:bg-red-50 transition-colors">
                            <i class="fas fa-sign-out-alt text-gray-400 group-hover:text-red-500 w-4 text-sm"></i>
                            <span
                                class="text-sm text-gray-700 group-hover:text-red-600 font-medium">{{ __('Déconnexion') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="main-content">
        <header class="sticky top-0 z-30 glass-effect shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex-1 min-w-0 animate-fadeIn">
                        @isset($header)
                            {{ $header }}
                        @else
                            <h2
                                class="text-2xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
                                {{ __('Tableau de bord') }}
                            </h2>
                            <p class="text-sm text-gray-500 mt-0.5">{{ now()->translatedFormat('l d F Y') }}</p>
                        @endisset
                    </div>
                    @php
                        $localeLabels = [
                            'fr' => 'Français',
                            'en' => 'English',
                            'es' => 'Español',
                            'ar' => 'العربية',
                        ];
                        $currentLocale = app()->getLocale();
                    @endphp
                    <div class="flex items-center space-x-2 shrink-0">
                        <div x-data="{ openTopLanguage: false }" class="relative">
                            <button @click="openTopLanguage = !openTopLanguage"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-indigo-200 text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-all duration-300 font-semibold text-sm">
                                <i class="fas fa-language"></i>
                                <span>{{ $localeLabels[$currentLocale] ?? strtoupper($currentLocale) }}</span>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                    :class="{'rotate-180': openTopLanguage}"></i>
                            </button>
                            <div x-show="openTopLanguage" @click.outside="openTopLanguage = false"
                                x-transition.opacity.duration.200ms
                                class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden">
                                @foreach($localeLabels as $localeCode => $localeLabel)
                                    <a href="{{ route('locale.switch', $localeCode) }}"
                                        class="flex items-center justify-between px-4 py-2.5 text-sm transition-colors {{ $currentLocale === $localeCode ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                        <span>{{ $localeLabel }}</span>
                                        @if($currentLocale === $localeCode)
                                            <i class="fas fa-check text-xs"></i>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 p-4 sm:p-6 lg:p-8 animate-fadeIn">
            {{ $slot }}
        </div>

        <footer class="px-6 py-5 border-t border-slate-100 text-center">
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} {{ __('Cabinet Medical — Tous droits réservés') }}
            </p>
        </footer>
    </main>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if (menuToggle && sidebar && overlay) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
                overlay.classList.toggle('hidden');
                document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
            });

            overlay.addEventListener('click', () => {
                sidebar.classList.remove('mobile-open');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            });
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>