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

        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .glass-card {
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.6);
        }
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-18px); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.55s ease-out both; }

        input:focus {
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
            border-color: #667eea !important;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-indigo-50 bg-pattern min-h-screen">

<div class="min-h-screen flex flex-col items-center justify-center px-4 py-10 relative overflow-hidden">

    {{-- Animated blobs --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        <div class="absolute -top-48 -right-48 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply
                    filter blur-3xl opacity-25 animate-float"></div>
        <div class="absolute -bottom-48 -left-48 w-96 h-96 bg-indigo-300 rounded-full mix-blend-multiply
                    filter blur-3xl opacity-25 animate-float" style="animation-delay:2s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-blue-200
                    rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    </div>

    {{-- Logo --}}
    <div class="relative mb-8 animate-fadeInUp">
        <a href="{{ url('/') }}" class="flex items-center space-x-4 group">
            <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center shadow-2xl
                        group-hover:scale-110 transition-all duration-300">
                <i class="fas fa-stethoscope text-white text-3xl"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold gradient-text leading-tight">
                    {{ __('Cabinet Médical') }}
                </h1>
                <p class="text-xs text-gray-500 mt-0.5">{{ __('OFPPT · Santé & Excellence') }}</p>
            </div>
        </a>
    </div>

    {{-- Card --}}
    <div class="relative w-full max-w-md animate-fadeInUp" style="animation-delay:0.1s">
        <div class="glass-card rounded-3xl shadow-2xl overflow-hidden px-8 py-10 sm:px-10">
            {{-- Top accent bar --}}
            <div class="absolute top-0 left-0 right-0 h-1 gradient-bg"></div>
            {{-- Soft glow corners --}}
            <div class="absolute top-0 right-0 w-28 h-28 gradient-bg rounded-full filter blur-3xl
                        opacity-[0.07] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-28 h-28 bg-indigo-400 rounded-full filter blur-3xl
                        opacity-[0.07] pointer-events-none"></div>

            {{ $slot }}
        </div>
    </div>

    {{-- Back link --}}
    <div class="relative mt-8 animate-fadeInUp" style="animation-delay:0.2s">
        <a href="{{ url('/') }}"
            class="text-sm text-gray-500 hover:text-indigo-600 transition-all duration-300
                   inline-flex items-center gap-2 group">
            <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform duration-300"></i>
            {{ __('Retour à l\'accueil') }}
        </a>
    </div>
</div>
</body>
</html>