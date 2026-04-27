<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cabinet Médical | Prise de Rendez-vous</title>
    
    <!-- Tailwind CSS CDN -->
    @vite(['resources/js/app.js'])
    @vite('resources/css/app.css')    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-bg-hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 40px -12px rgba(0,0,0,0.15);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .animate-pulse-slow {
            animation: pulseSlow 3s ease-in-out infinite;
        }
        
        @keyframes pulseSlow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.05); }
        }
        
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .shine-effect {
            position: relative;
            overflow: hidden;
        }
        
        .shine-effect::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: rotate(30deg);
            animation: shine 8s infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) rotate(30deg); }
            20% { transform: translateX(100%) rotate(30deg); }
            100% { transform: translateX(100%) rotate(30deg); }
        }
        
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-indigo-50 bg-pattern">
    
    <!-- Navigation Bar -->
    <nav class="bg-white/95 backdrop-blur-md shadow-xl sticky top-0 z-50 border-b border-gray-100">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between flex-wrap">
                <!-- Logo -->
                <div class="flex items-center space-x-3 group cursor-pointer">
                    <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition duration-300">
                        <i class="fas fa-stethoscope text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Cabinet Médical</h1>
                        <p class="text-xs text-gray-500">OFPPT - Santé & Excellence</p>
                    </div>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-10">
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300 font-medium relative group">
                        Accueil
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300 font-medium relative group">
                        Services
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300 font-medium relative group">
                        Médecins
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300 font-medium relative group">
                        Contact
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
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

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button id="languageToggle"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-indigo-200 text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-all duration-300 font-semibold text-sm">
                            <i class="fas fa-language"></i>
                            <span>{{ $localeLabels[$currentLocale] ?? strtoupper($currentLocale) }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div id="languageMenu"
                            class="hidden absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden">
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

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" 
                               class="px-6 py-2.5 gradient-bg text-white rounded-xl font-semibold hover:shadow-xl transition-all duration-300 hover:scale-105">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="px-6 py-2.5 text-indigo-600 border-2 border-indigo-600 rounded-xl hover:bg-indigo-50 transition-all duration-300 font-semibold hover:scale-105">
                                <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                            </a>
                            <a href="{{ route('register') }}" 
                               class="px-6 py-2.5 gradient-bg text-white rounded-xl hover:shadow-xl transition-all duration-300 font-semibold hover:scale-105 shine-effect">
                                <i class="fas fa-user-plus mr-2"></i>Inscription
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Animated Background -->
    <section class="relative overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <!-- Animated Background Circles -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow"></div>
        </div>
        
        <div class="container mx-auto px-6 py-24 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-16">
                <!-- Left Content -->
                <div class="lg:w-1/2 text-center lg:text-left">
                    <div class="inline-flex items-center bg-white/80 backdrop-blur-sm rounded-full px-5 py-2.5 mb-8 shadow-lg border border-gray-100">
                        <i class="fas fa-heartbeat text-indigo-600 mr-2 animate-pulse"></i>
                        <span class="text-indigo-600 text-sm font-bold">✨ Excellence Médicale ✨</span>
                    </div>
                    
                    <h1 class="text-6xl lg:text-7xl font-extrabold mb-6 leading-tight">
                        <span class="text-gray-800">Prenez soin de</span>
                        <br>
                        <span class="gradient-bg bg-clip-text text-transparent">votre santé</span>
                        <br>
                        <span class="text-gray-700">avec nos experts</span>
                    </h1>
                    
                    <p class="text-xl text-gray-600 mb-10 leading-relaxed max-w-lg mx-auto lg:mx-0">
                        Prenez rendez-vous en ligne avec nos médecins spécialistes. 
                        Une prise en charge rapide, efficace et personnalisée 24h/24.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-5">
                        <a href="{{ route('register') }}" 
                           class="px-10 py-4 gradient-bg text-white rounded-xl font-bold hover:shadow-2xl transition-all duration-300 text-center hover:scale-105 shine-effect inline-flex items-center justify-center gap-2">
                            <i class="fas fa-calendar-plus"></i>
                            Prendre Rendez-vous
                            <i class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
                        </a>
                        <a href="#" 
                           class="px-10 py-4 bg-white text-indigo-600 rounded-xl font-bold border-2 border-indigo-600 hover:bg-indigo-50 transition-all duration-300 text-center hover:scale-105 inline-flex items-center justify-center gap-2">
                            <i class="fas fa-play-circle"></i>
                            Découvrir nos services
                        </a>
                    </div>
                    
                    <!-- Stats with Animations -->
                    <div class="grid grid-cols-3 gap-8 mt-16 pt-8 border-t border-gray-200">
                        <div class="text-center lg:text-left group cursor-pointer">
                            <div class="text-4xl font-black text-indigo-600 group-hover:scale-110 transition-transform duration-300">5000+</div>
                            <div class="text-gray-500 text-sm font-medium mt-2">Patients satisfaits</div>
                            <div class="w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300 mt-2"></div>
                        </div>
                        <div class="text-center lg:text-left group cursor-pointer">
                            <div class="text-4xl font-black text-indigo-600 group-hover:scale-110 transition-transform duration-300">25+</div>
                            <div class="text-gray-500 text-sm font-medium mt-2">Médecins experts</div>
                            <div class="w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300 mt-2"></div>
                        </div>
                        <div class="text-center lg:text-left group cursor-pointer">
                            <div class="text-4xl font-black text-indigo-600 group-hover:scale-110 transition-transform duration-300">15+</div>
                            <div class="text-gray-500 text-sm font-medium mt-2">Années d'excellence</div>
                            <div class="w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300 mt-2"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Illustration (SVG sans image) -->
                <div class="lg:w-1/2">
                    <div class="relative">
                        <!-- Decorative circles -->
                        <div class="absolute top-0 right-0 w-64 h-64 gradient-bg rounded-full filter blur-2xl opacity-20 animate-float"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-400 rounded-full filter blur-2xl opacity-20 animate-float" style="animation-delay: 1s;"></div>
                        
                        <!-- Main Card -->
                        <div class="relative bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-gray-100 hover:shadow-3xl transition-all duration-500">
                            <!-- Icon Grid -->
                            <div class="grid grid-cols-3 gap-6 mb-8">
                                <div class="text-center">
                                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-calendar-check text-white text-3xl"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-700">Rendez-vous<br>Facile</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-clock text-white text-3xl"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-700">Sans<br>Attente</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-shield-alt text-white text-3xl"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-700">100%<br>Sécurisé</p>
                                </div>
                            </div>
                            
                            <!-- Features List -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50 transition-all duration-300 group">
                                    <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                    <span class="text-gray-700 font-medium">Consultations en ligne 24/7</span>
                                </div>
                                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50 transition-all duration-300 group">
                                    <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                    <span class="text-gray-700 font-medium">Suivi médical personnalisé</span>
                                </div>
                                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50 transition-all duration-300 group">
                                    <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                    <span class="text-gray-700 font-medium">Rappels automatiques par SMS/Email</span>
                                </div>
                            </div>
                            
                            <!-- CTA inside card -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="gradient-bg rounded-xl p-4 text-center text-white">
                                    <p class="text-sm font-semibold">✨ Premier rendez-vous offert ✨</p>
                                    <p class="text-xs opacity-90 mt-1">Pour tout nouveau patient</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section with Premium Design -->
    <section class="py-24 bg-white relative">
        <div class="absolute inset-0 bg-pattern opacity-5"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <span class="text-indigo-600 font-bold text-sm uppercase tracking-wider bg-indigo-50 px-4 py-2 rounded-full inline-block">⭐ Nos Services Premium ⭐</span>
                <h2 class="text-5xl font-bold text-gray-800 mt-6 mb-4">Des soins complets<br>pour toute la famille</h2>
                <div class="w-24 h-1 gradient-bg mx-auto rounded-full"></div>
                <p class="text-gray-600 max-w-2xl mx-auto mt-6 text-lg">Des services médicaux de qualité supérieure adaptés à vos besoins spécifiques</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="group relative bg-gradient-to-br from-white to-gray-50 rounded-2xl p-10 card-hover border border-gray-100">
                    <div class="absolute top-0 right-0 w-20 h-20 gradient-bg rounded-full filter blur-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-6 shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-calendar-check text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Prise de Rendez-vous</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Réservez votre consultation en ligne facilement et rapidement, disponible 24h/24 et 7j/7.
                    </p>
                    <div class="flex items-center text-indigo-600 font-semibold group-hover:translate-x-2 transition-transform duration-300">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
                
                <!-- Service 2 -->
                <div class="group relative bg-gradient-to-br from-white to-gray-50 rounded-2xl p-10 card-hover border border-gray-100 transform lg:-translate-y-4">
                    <div class="absolute top-0 right-0 w-20 h-20 gradient-bg rounded-full filter blur-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-md text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Médecins Spécialistes</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Une équipe de médecins expérimentés dans différentes spécialités médicales à votre service.
                    </p>
                    <div class="flex items-center text-indigo-600 font-semibold group-hover:translate-x-2 transition-transform duration-300">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
                
                <!-- Service 3 -->
                <div class="group relative bg-gradient-to-br from-white to-gray-50 rounded-2xl p-10 card-hover border border-gray-100">
                    <div class="absolute top-0 right-0 w-20 h-20 gradient-bg rounded-full filter blur-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-heartbeat text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Suivi Personnalisé</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Un suivi médical adapté à vos besoins avec des rappels de rendez-vous et conseils santé.
                    </p>
                    <div class="flex items-center text-indigo-600 font-semibold group-hover:translate-x-2 transition-transform duration-300">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-24 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <div class="relative">
                        <div class="absolute -top-10 -left-10 w-32 h-32 bg-white rounded-full filter blur-3xl opacity-20 animate-float"></div>
                        <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-10 border border-white/20">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="text-center p-6 rounded-xl bg-white/5 hover:bg-white/10 transition-all duration-300 group cursor-pointer">
                                    <i class="fas fa-microscope text-4xl text-white mb-3 group-hover:scale-110 transition-transform inline-block"></i>
                                    <p class="text-white font-semibold">Équipements<br>Modernes</p>
                                </div>
                                <div class="text-center p-6 rounded-xl bg-white/5 hover:bg-white/10 transition-all duration-300 group cursor-pointer">
                                    <i class="fas fa-smile text-4xl text-white mb-3 group-hover:scale-110 transition-transform inline-block"></i>
                                    <p class="text-white font-semibold">Accueil<br>Chaleureux</p>
                                </div>
                                <div class="text-center p-6 rounded-xl bg-white/5 hover:bg-white/10 transition-all duration-300 group cursor-pointer">
                                    <i class="fas fa-clock text-4xl text-white mb-3 group-hover:scale-110 transition-transform inline-block"></i>
                                    <p class="text-white font-semibold">Rendez-vous<br>Rapides</p>
                                </div>
                                <div class="text-center p-6 rounded-xl bg-white/5 hover:bg-white/10 transition-all duration-300 group cursor-pointer">
                                    <i class="fas fa-phone-alt text-4xl text-white mb-3 group-hover:scale-110 transition-transform inline-block"></i>
                                    <p class="text-white font-semibold">Support<br>24/7</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="lg:w-1/2 text-white">
                    <span class="text-white/80 font-semibold text-sm uppercase tracking-wider bg-white/20 px-4 py-2 rounded-full inline-block">✨ Pourquoi Nous Choisir ✨</span>
                    <h2 class="text-5xl font-bold mt-6 mb-6">Votre santé est notre priorité absolue</h2>
                    <p class="text-white/90 text-lg mb-8 leading-relaxed">
                        Depuis plus de 15 ans, nous offrons des soins de qualité supérieure dans un cadre moderne et accueillant.
                        Notre équipe dédiée est là pour vous accompagner à chaque étape de votre parcours de soins.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-white/10 hover:bg-white/20 transition-all duration-300 group cursor-pointer">
                            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-trophy text-indigo-600"></i>
                            </div>
                            <span class="font-semibold">Certifié ISO 9001:2024</span>
                        </div>
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-white/10 hover:bg-white/20 transition-all duration-300 group cursor-pointer">
                            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-award text-indigo-600"></i>
                            </div>
                            <span class="font-semibold">Prix de l'Excellence Médicale 2024</span>
                        </div>
                    </div>
                    
                    <div class="mt-10">
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold hover:shadow-2xl transition-all duration-300 hover:scale-105 gap-3">
                            Commencer maintenant
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-indigo-600 font-bold text-sm uppercase tracking-wider bg-indigo-50 px-4 py-2 rounded-full inline-block">💬 Témoignages 💬</span>
                <h2 class="text-5xl font-bold text-gray-800 mt-6 mb-4">Ce que disent nos patients</h2>
                <div class="w-24 h-1 gradient-bg mx-auto rounded-full"></div>
                <p class="text-gray-600 max-w-2xl mx-auto mt-6 text-lg">Des retours authentiques de personnes que nous avons accompagnées</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-8 card-hover border border-gray-100 relative">
                    <div class="absolute top-0 right-0 w-20 h-20 gradient-bg rounded-full filter blur-2xl opacity-10"></div>
                    <i class="fas fa-quote-left text-4xl text-indigo-200 mb-4"></i>
                    <p class="text-gray-700 leading-relaxed mb-6 relative z-10">
                        "Excellent service ! Prise de rendez-vous rapide et équipe très professionnelle. Je recommande vivement ce cabinet."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 gradient-bg rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg">Marie Dupont</h4>
                            <div class="flex text-yellow-400 mt-1">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-8 card-hover border border-gray-100 relative transform lg:translate-y-4">
                    <div class="absolute top-0 right-0 w-20 h-20 gradient-bg rounded-full filter blur-2xl opacity-10"></div>
                    <i class="fas fa-quote-left text-4xl text-indigo-200 mb-4"></i>
                    <p class="text-gray-700 leading-relaxed mb-6 relative z-10">
                        "Un cabinet moderne avec des médecins à l'écoute. Les rappels par email sont très pratiques et efficaces."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg">Karim Benali</h4>
                            <div class="flex text-yellow-400 mt-1">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-8 card-hover border border-gray-100 relative">
                    <div class="absolute top-0 right-0 w-20 h-20 gradient-bg rounded-full filter blur-2xl opacity-10"></div>
                    <i class="fas fa-quote-left text-4xl text-indigo-200 mb-4"></i>
                    <p class="text-gray-700 leading-relaxed mb-6 relative z-10">
                        "Très satisfaite de la prise en charge. Le système de réservation en ligne est super simple d'utilisation."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg">Sophie Martin</h4>
                            <div class="flex text-yellow-400 mt-1">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section Premium -->
    <section class="py-24 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0">
            <svg class="absolute bottom-0 left-0 w-full h-32 text-white" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor" opacity="0.1"></path>
            </svg>
        </div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-12 max-w-4xl mx-auto border border-white/20">
                <i class="fas fa-calendar-alt text-5xl text-white mb-6 animate-bounce"></i>
                <h2 class="text-5xl font-bold text-white mb-4">Prêt à prendre soin de votre santé ?</h2>
                <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                    Rejoignez plus de 5000 patients satisfaits et prenez rendez-vous dès aujourd'hui
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-5">
                    <a href="{{ route('register') }}" 
                       class="px-10 py-4 bg-white text-indigo-600 rounded-xl font-bold hover:shadow-2xl transition-all duration-300 hover:scale-105 inline-flex items-center justify-center gap-3">
                        <i class="fas fa-calendar-plus"></i>
                        Prendre Rendez-vous
                    </a>
                    <a href="#" 
                       class="px-10 py-4 border-2 border-white text-white rounded-xl font-bold hover:bg-white hover:text-indigo-600 transition-all duration-300 hover:scale-105 inline-flex items-center justify-center gap-3">
                        <i class="fas fa-phone-alt"></i>
                        Nous Contacter
                    </a>
                </div>
                <p class="text-white/80 text-sm mt-6">⚡ Réponse garantie sous 24h ⚡</p>
            </div>
        </div>
    </section>

    <!-- Footer Premium -->
    <footer class="bg-gray-900 text-white py-16 relative">
        <div class="absolute inset-0 bg-pattern opacity-5"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-stethoscope text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl">Cabinet Médical</h3>
                            <p class="text-gray-400 text-sm">OFPPT - Santé & Excellence</p>
                        </div>
                    </div>
                    <p class="text-gray-400 leading-relaxed">Prenez soin de votre santé avec nos médecins experts. Votre bien-être, notre priorité.</p>
                    <div class="flex gap-4 mt-6">
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-indigo-600 transition-all duration-300 hover:scale-110">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-indigo-600 transition-all duration-300 hover:scale-110">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-indigo-600 transition-all duration-300 hover:scale-110">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-indigo-600 transition-all duration-300 hover:scale-110">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold text-lg mb-6 relative inline-block">
                        Liens Rapides
                        <div class="absolute bottom-0 left-0 w-full h-0.5 gradient-bg rounded-full"></div>
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300 flex items-center gap-2 group"><i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i> Accueil</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300 flex items-center gap-2 group"><i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i> Services</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300 flex items-center gap-2 group"><i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i> Médecins</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300 flex items-center gap-2 group"><i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i> Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-lg mb-6 relative inline-block">
                        Horaires
                        <div class="absolute bottom-0 left-0 w-full h-0.5 gradient-bg rounded-full"></div>
                    </h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex justify-between"><span>Lun - Ven:</span><span class="text-white font-semibold">8h00 - 20h00</span></li>
                        <li class="flex justify-between"><span>Samedi:</span><span class="text-white font-semibold">9h00 - 16h00</span></li>
                        <li class="flex justify-between"><span>Dimanche:</span><span class="text-red-400">Fermé</span></li>
                        <li class="mt-4 pt-4 border-t border-gray-800"><span class="text-emerald-400">🚨 Urgences 24/24</span></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-lg mb-6 relative inline-block">
                        Contact
                        <div class="absolute bottom-0 left-0 w-full h-0.5 gradient-bg rounded-full"></div>
                    </h4>
                    <ul class="space-y-4 text-gray-400">
                        <li class="flex items-center gap-3 group cursor-pointer hover:text-white transition">
                            <i class="fas fa-phone-alt group-hover:scale-110 transition-transform"></i>
                            <span>+212 5XX XXX XXX</span>
                        </li>
                        <li class="flex items-center gap-3 group cursor-pointer hover:text-white transition">
                            <i class="fas fa-envelope group-hover:scale-110 transition-transform"></i>
                            <span>contact@cabinet.ma</span>
                        </li>
                        <li class="flex items-center gap-3 group cursor-pointer hover:text-white transition">
                            <i class="fas fa-map-marker-alt group-hover:scale-110 transition-transform"></i>
                            <span>Casablanca, Maroc</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400">© 2025 Cabinet Médical. Tous droits réservés. | OFPPT - Développement Back End</p>
                <p class="text-gray-500 text-sm mt-2">✨ Design Premium | Expérience Patient Exceptionnelle ✨</p>
            </div>
        </div>
    </footer>

    <script>
        const languageToggle = document.getElementById('languageToggle');
        const languageMenu = document.getElementById('languageMenu');

        if (languageToggle && languageMenu) {
            languageToggle.addEventListener('click', function (event) {
                event.stopPropagation();
                languageMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!languageMenu.contains(event.target) && event.target !== languageToggle) {
                    languageMenu.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
