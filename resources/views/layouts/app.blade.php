<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', __('Cabinet Médical')) }}</title>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }

        .gradient-bg  { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Sidebar */
        .sidebar { transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); z-index: 1000; }
        .sidebar-item { transition: all 0.2s ease; position: relative; overflow: hidden; }
        .sidebar-item::before {
            content: '';
            position: absolute; left: 0; top: 0;
            height: 100%; width: 3px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transform: scaleY(0);
            transition: transform 0.2s ease;
        }
        .sidebar-item:hover::before,
        .sidebar-item-active::before { transform: scaleY(1); }
        .sidebar-item:hover {
            background: linear-gradient(135deg,rgba(102,126,234,.08) 0%,rgba(118,75,162,.08) 100%);
            transform: translateX(3px);
        }
        .sidebar-item-active {
            background: linear-gradient(135deg,rgba(102,126,234,.12) 0%,rgba(118,75,162,.12) 100%);
        }

        /* Scrollbar */
        .scrollbar-custom::-webkit-scrollbar { width: 4px; }
        .scrollbar-custom::-webkit-scrollbar-track  { background: #f8f8fc; }
        .scrollbar-custom::-webkit-scrollbar-thumb  {
            background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
            border-radius: 4px;
        }

        /* Layout */
        .main-content { margin-left: 280px; transition: margin-left 0.3s ease; }
        @media (max-width: 1023px) { .main-content { margin-left: 0; } }

        /* Dropdown */
        .dropdown-menu {
            opacity: 0; visibility: hidden;
            transform: translateY(8px);
            transition: all 0.2s ease;
        }
        .dropdown-menu.show { opacity: 1; visibility: visible; transform: translateY(0); }

        /* Fade-in */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.4s ease-out both; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-indigo-50 bg-pattern min-h-screen">

<div class="relative min-h-screen">

    {{-- Mobile toggle --}}
    <div class="fixed top-4 left-4 z-50 lg:hidden">
        <button id="menuToggle"
            class="p-3 bg-white rounded-xl shadow-lg text-gray-600 hover:text-indigo-600 transition-all duration-300 hover:scale-105 hover:shadow-xl"
            aria-label="{{ __('Ouvrir le menu') }}">
            <i class="fas fa-bars text-lg"></i>
        </button>
    </div>

    {{-- Overlay --}}
    <div id="overlay"
        class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden transition-opacity duration-300"></div>

    {{-- ════════════════════ SIDEBAR ════════════════════ --}}
    <aside id="sidebar"
        class="sidebar fixed top-0 left-0 h-full w-72 bg-white shadow-2xl flex flex-col overflow-y-auto scrollbar-custom border-r border-gray-100/60">

        {{-- Logo --}}
        <div class="p-6 border-b border-gray-100">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center shadow-lg
                            group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-stethoscope text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold gradient-text leading-tight">{{ __('Cabinet Médical') }}</h1>
                    <p class="text-xs text-gray-400 mt-0.5">{{ __('OFPPT · Santé & Excellence') }}</p>
                </div>
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 p-4 space-y-1">

            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-4 pt-2 pb-1">
                {{ __('Principal') }}
            </p>

            <a href="{{ route('dashboard') }}"
                class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700
                       {{ request()->routeIs('dashboard') ? 'sidebar-item-active' : '' }}">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center
                            {{ request()->routeIs('dashboard') ? 'gradient-bg' : 'bg-indigo-50' }}">
                    <i class="fas fa-tachometer-alt text-sm
                              {{ request()->routeIs('dashboard') ? 'text-white' : 'text-indigo-500' }}"></i>
                </div>
                <span class="flex-1 text-sm font-medium">{{ __('Tableau de bord') }}</span>
                @if(request()->routeIs('dashboard'))
                    <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                @endif
            </a>

            <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700">
                <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-sm text-amber-500"></i>
                </div>
                <span class="flex-1 text-sm font-medium">{{ __('Rendez-vous') }}</span>
                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">12</span>
            </a>

            @if (Auth::user()->role === 'admin')
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-4 pt-4 pb-1">
                    {{ __('Administration') }}
                </p>

                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700">
                    <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-md text-sm text-emerald-500"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">{{ __('Médecins') }}</span>
                </a>

                <a href="{{ route('patient.index') }}"
                    class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700
                           {{ request()->routeIs('patient.*') ? 'sidebar-item-active' : '' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                {{ request()->routeIs('patient.*') ? 'gradient-bg' : 'bg-blue-50' }}">
                        <i class="fas fa-users text-sm
                                  {{ request()->routeIs('patient.*') ? 'text-white' : 'text-blue-500' }}"></i>
                    </div>
                    <span class="flex-1 text-sm font-medium">{{ __('Patients') }}</span>
                    @if(request()->routeIs('patient.*'))
                        <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                    @endif
                </a>
            @endif

            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-4 pt-4 pb-1">
                {{ __('Compte') }}
            </p>

            <a href="{{ route('profile.edit') }}"
                class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700
                       {{ request()->routeIs('profile.*') ? 'sidebar-item-active' : '' }}">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center
                            {{ request()->routeIs('profile.*') ? 'gradient-bg' : 'bg-purple-50' }}">
                    <i class="fas fa-user-circle text-sm
                              {{ request()->routeIs('profile.*') ? 'text-white' : 'text-purple-500' }}"></i>
                </div>
                <span class="flex-1 text-sm font-medium">{{ __('Mon profil') }}</span>
                @if(request()->routeIs('profile.*'))
                    <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                @endif
            </a>
        </nav>

        {{-- User card + dropdown --}}
        <div class="p-4 border-t border-gray-100 relative">
            <button id="userMenuButton"
                class="w-full flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50
                       transition-all duration-200 group text-left">
                <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center shadow-md
                            shrink-0 group-hover:scale-105 transition-transform duration-300">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 text-sm truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
                <i id="dropdownArrow"
                   class="fas fa-chevron-up text-gray-400 text-xs transition-transform duration-200"></i>
            </button>

            <div id="userDropdown"
                class="dropdown-menu absolute bottom-full left-4 right-4 mb-2 bg-white rounded-2xl
                       shadow-2xl border border-gray-100 overflow-hidden z-50">
                <div class="px-4 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-100">
                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-wide">
                        {{ __('Mon compte') }}
                    </p>
                </div>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-50 transition-colors group">
                    <i class="fas fa-user-circle text-gray-400 group-hover:text-indigo-600 w-4 text-sm"></i>
                    <span class="text-sm text-gray-700 group-hover:text-indigo-700 font-medium">
                        {{ __('Mon profil') }}
                    </span>
                </a>
                <div class="border-t border-gray-100 mx-3"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center space-x-3 px-4 py-3 hover:bg-red-50
                               transition-colors group">
                        <i class="fas fa-sign-out-alt text-gray-400 group-hover:text-red-500 w-4 text-sm"></i>
                        <span class="text-sm text-gray-700 group-hover:text-red-600 font-medium">
                            {{ __('Déconnexion') }}
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ════════════════════ MAIN ════════════════════ --}}
    <main class="main-content min-h-screen flex flex-col">

        {{-- Top bar --}}
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between gap-4">
                    <div class="w-8 lg:hidden shrink-0"></div>

                    <div class="flex-1 min-w-0 animate-fadeInUp">
                        @isset($header)
                            {{ $header }}
                        @else
                            <h2 class="text-xl font-bold gradient-text">{{ __('Tableau de bord') }}</h2>
                        @endisset
                        <p class="text-xs text-gray-400 mt-0.5 hidden sm:block">
                            {{ now()->translatedFormat('l d F Y') }}
                        </p>
                    </div>

                    <div class="flex items-center space-x-2 shrink-0">
                        
                        <button class="relative p-2.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50
                                       rounded-xl transition-all duration-300"
                            title="{{ __('Notifications') }}">
                            <i class="fas fa-bell text-base"></i>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <div class="flex-1 p-4 sm:p-6 lg:p-8 animate-fadeInUp">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <footer class="px-6 py-4 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">
                &copy; {{ date('Y') }} &mdash; {{ __('Cabinet Médical · OFPPT') }}
            </p>
        </footer>
    </main>
</div>

<script>
    const menuToggle = document.getElementById('menuToggle');
    const sidebar    = document.getElementById('sidebar');
    const overlay    = document.getElementById('overlay');

    const closeSidebar = () => {
        sidebar?.classList.add('-translate-x-full');
        overlay?.classList.add('hidden');
        document.body.style.overflow = '';
    };
    const openSidebar = () => {
        sidebar?.classList.remove('-translate-x-full');
        overlay?.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    menuToggle?.addEventListener('click', () =>
        sidebar?.classList.contains('-translate-x-full') ? openSidebar() : closeSidebar()
    );
    overlay?.addEventListener('click', closeSidebar);

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            sidebar?.classList.remove('-translate-x-full');
            overlay?.classList.add('hidden');
            document.body.style.overflow = '';
        } else {
            sidebar?.classList.add('-translate-x-full');
        }
    });

    if (window.innerWidth < 1024) sidebar?.classList.add('-translate-x-full');

    // User dropdown
    const userMenuButton = document.getElementById('userMenuButton');
    const userDropdown   = document.getElementById('userDropdown');
    const dropdownArrow  = document.getElementById('dropdownArrow');

    userMenuButton?.addEventListener('click', e => {
        e.stopPropagation();
        const open = userDropdown.classList.toggle('show');
        if (dropdownArrow) dropdownArrow.style.transform = open ? 'rotate(180deg)' : 'rotate(0deg)';
    });
    document.addEventListener('click', e => {
        if (!userMenuButton?.contains(e.target) && !userDropdown?.contains(e.target)) {
            userDropdown?.classList.remove('show');
            if (dropdownArrow) dropdownArrow.style.transform = 'rotate(0deg)';
        }
    });
</script>
</body>
</html>