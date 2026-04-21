<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cabinet Médical') }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
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
            transform: translateY(-5px);
            box-shadow: 0 25px 40px -12px rgba(0,0,0,0.15);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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
        
        input:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            border-color: #667eea;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-indigo-50 bg-pattern">
    
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float" style="animation-delay: 2s;"></div>
        </div>
        
        <!-- Logo -->
        <div class="relative mb-6">
            <a href="/" class="flex items-center space-x-3 group cursor-pointer">
                <div class="w-14 h-14 gradient-bg rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-110 transition duration-300">
                    <i class="fas fa-stethoscope text-white text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Cabinet Médical</h1>
                    <p class="text-xs text-gray-500">OFPPT - Santé & Excellence</p>
                </div>
            </a>
        </div>
        
        <!-- Content Box -->
        <div class="relative w-full sm:max-w-md mt-6 px-6 py-8 bg-white/90 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-100 card-hover">
            <div class="absolute top-0 right-0 w-32 h-32 gradient-bg rounded-full filter blur-2xl opacity-10"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-indigo-400 rounded-full filter blur-2xl opacity-10"></div>
            
            {{ $slot }}
        </div>
        
        <!-- Footer Links -->
        <div class="relative text-center mt-6">
            <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-indigo-600 transition duration-300 inline-flex items-center gap-2 group">
                <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
                Retour à l'accueil
            </a>
        </div>
    </div>
    
</body>
</html>