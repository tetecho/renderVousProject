<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cabinet Médical') }}</title>

    <!-- Tailwind CSS CDN -->
    @vite('resources/css/app.css')

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Sidebar Styles */
        .sidebar {
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
        }

        .sidebar-closed {
            transform: translateX(-100%);
        }

        .sidebar-item {
            transition: all 0.2s ease;
        }

        .sidebar-item:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            transform: translateX(4px);
        }

        .sidebar-item-active {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
            border-left: 3px solid #667eea;
        }

        /* Scrollbar */
        .scrollbar-custom::-webkit-scrollbar {
            width: 4px;
        }

        .scrollbar-custom::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .scrollbar-custom::-webkit-scrollbar-thumb {
            background: #c7d2fe;
            border-radius: 4px;
        }

        /* Overlay */
        .overlay {
            transition: opacity 0.3s ease-in-out;
        }

        /* Main content margin for desktop */
        .main-content {
            margin-left: 288px;
            /* 72 * 4 = 288px */
        }

        /* Mobile responsive */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
            }
        }

        /* Dropdown animation */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-gray-50">

    <div class="relative min-h-screen">

        <!-- Mobile Menu Button -->
        <div class="fixed top-4 left-4 z-50 lg:hidden">
            <button id="menuToggle"
                class="p-2 bg-white rounded-lg shadow-lg text-gray-700 hover:text-indigo-600 transition">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Overlay for mobile -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden overlay"></div>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar fixed top-0 left-0 h-full w-72 bg-white shadow-xl border-r border-gray-100 flex flex-col overflow-y-auto scrollbar-custom">

            <!-- Logo Section -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center shadow-md">
                        <i class="fas fa-stethoscope text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-800">Cabinet Médical</h1>
                        <p class="text-xs text-gray-400">OFPPT - Santé & Excellence</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 transition {{ request()->routeIs('dashboard') ? 'sidebar-item-active' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="flex-1 text-sm font-medium">Dashboard</span>
                    @if(request()->routeIs('dashboard'))
                        <i class="fas fa-circle text-indigo-600 text-xs"></i>
                    @endif
                </a>

                <a href="#"
                    class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 transition">
                    <i class="fas fa-calendar-check w-5"></i>
                    <span class="flex-1 text-sm font-medium">Rendez-vous</span>
                    <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">12</span>
                </a>

                @if (Auth::user()->role === 'admin')
                    <a href="#"
                        class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 transition">
                        <i class="fas fa-user-md w-5"></i>
                        <span class="flex-1 text-sm font-medium">Médecins</span>
                    </a>

                    <a href="{{ route('patient.index') }}"
                        class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 transition">
                        <i class="fas fa-users w-5"></i>
                        <span class="flex-1 text-sm font-medium">Patients</span>
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}"
                    class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 transition {{ request()->routeIs('profile.*') ? 'sidebar-item-active' : '' }}">
                    <i class="fas fa-user-circle w-5"></i>
                    <span class="flex-1 text-sm font-medium">Profil</span>
                    @if(request()->routeIs('profile.*'))
                        <i class="fas fa-circle text-indigo-600 text-xs"></i>
                    @endif
                </a>

            </nav>

            <!-- User Info with Dropdown -->
            <div class="p-6 border-t border-gray-100 relative">
                <div id="userMenuButton" class="flex items-center space-x-3 cursor-pointer group">
                    <div
                        class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center shadow-md group-hover:scale-105 transition">
                        <i class="fas fa-user text-white text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                        id="dropdownArrow"></i>
                </div>

                <!-- Dropdown Menu - Changed to appear above (bottom-full) -->
                <div id="userDropdown"
                    class="dropdown-menu absolute bottom-full left-4 right-4 mb-2 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-50 transition group">
                        <i class="fas fa-user-circle text-gray-400 group-hover:text-indigo-600 w-5"></i>
                        <span class="text-sm text-gray-700 group-hover:text-indigo-600">Mon profil</span>
                    </a>
                    <div class="border-t border-gray-100"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center space-x-3 px-4 py-3 hover:bg-gray-50 transition group">
                            <i class="fas fa-sign-out-alt text-gray-400 group-hover:text-red-500 w-5"></i>
                            <span class="text-sm text-gray-700 group-hover:text-red-500">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">

            <!-- Top Bar -->
            <div class="sticky top-0 z-30 bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-100">
                <div class="px-6 py-4 lg:px-8">
                    <div class="flex items-center justify-between">
                        <!-- Page Title -->
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 lg:text-2xl">
                                @isset($header)
                                    {{ $header }}
                                @else
                                    Dashboard
                                @endisset
                            </h2>
                            <p class="text-xs text-gray-400 mt-1 hidden lg:block">
                                {{ now()->format('l d F Y') }}
                            </p>
                        </div>

                        <!-- Right Icons -->
                        <div class="flex items-center space-x-3">
                            <!-- Search (Desktop) -->
                            <div class="hidden lg:block relative">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" placeholder="Rechercher..."
                                    class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-64">
                            </div>

                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-500 hover:text-indigo-600 transition">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-6 lg:p-8">
                {{ $slot }}
            </div>

        </main>

    </div>

    <!-- Mobile Menu & Dropdown Script -->
    <script>
        // Sidebar toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mainContent = document.querySelector('.main-content');

        function closeSidebar() {
            if (sidebar) {
                sidebar.classList.add('-translate-x-full');
            }
            if (overlay) {
                overlay.classList.add('hidden');
            }
            if (mainContent) {
                mainContent.style.marginLeft = '0';
            }
            document.body.style.overflow = '';
        }

        function openSidebar() {
            if (sidebar) {
                sidebar.classList.remove('-translate-x-full');
            }
            if (overlay) {
                overlay.classList.remove('hidden');
            }
            if (mainContent && window.innerWidth < 1024) {
                mainContent.style.marginLeft = '0';
            }
            document.body.style.overflow = 'hidden';
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                if (sidebar && sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        // Handle resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                if (sidebar) {
                    sidebar.classList.remove('-translate-x-full');
                }
                if (overlay) {
                    overlay.classList.add('hidden');
                }
                if (mainContent) {
                    mainContent.style.marginLeft = '';
                }
                document.body.style.overflow = '';
            } else {
                if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
                if (mainContent) {
                    mainContent.style.marginLeft = '0';
                }
            }
        });

        // Initialize sidebar state for mobile
        if (window.innerWidth < 1024) {
            if (sidebar) {
                sidebar.classList.add('-translate-x-full');
            }
        }

        // User Dropdown
        const userMenuButton = document.getElementById('userMenuButton');
        const userDropdown = document.getElementById('userDropdown');
        const dropdownArrow = document.getElementById('dropdownArrow');

        if (userMenuButton && userDropdown) {
            userMenuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('show');
                if (dropdownArrow) {
                    dropdownArrow.style.transform = userDropdown.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.remove('show');
                    if (dropdownArrow) {
                        dropdownArrow.style.transform = 'rotate(0deg)';
                    }
                }
            });
        }
    </script>

</body>

</html>