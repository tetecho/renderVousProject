{{-- resources/views/layouts/guest.blade.php --}}
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

        .gradient-primary { background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%); }
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .bg-pattern {
            background-image: radial-gradient(circle at 1px 1px, rgba(59,130,246,0.05) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.5s ease-out both; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-16px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }

        input:focus {
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-blue-50 bg-pattern min-h-screen">

<div class="min-h-screen flex flex-col items-center justify-center px-4 py-10 relative overflow-hidden">

    {{-- Ambient blobs --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        <div class="absolute -top-48 -right-48 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute -bottom-48 -left-48 w-96 h-96 bg-cyan-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float" style="animation-delay:2s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-15 animate-pulse"></div>
    </div>

    {{-- Logo --}}
    <div class="relative mb-8 animate-fadeIn">
        <a href="{{ url('/') }}" class="flex items-center space-x-4 group">
            <div class="relative">
                <div class="w-14 h-14 gradient-primary rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-heartbeat text-white text-2xl"></i>
                </div>
                <div class="absolute -inset-1 gradient-primary rounded-2xl opacity-25 blur-sm"></div>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold gradient-text leading-tight">
                    {{ __('Cabinet Médical') }}
                </h1>
                <p class="text-xs text-gray-400 mt-0.5">{{ __('Soins & Excellence') }}</p>
            </div>
        </a>
    </div>

    {{-- Card --}}
    <div class="relative w-full max-w-md animate-fadeIn" style="animation-delay: 0.1s;">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden"
             style="box-shadow: 0 10px 40px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.04);">
            <div class="h-1.5 gradient-primary"></div>
            <div class="px-8 py-8 sm:px-10">
                {{ $slot }}
            </div>
        </div>
    </div>

    {{-- Back link --}}
    <div class="relative mt-6 animate-fadeIn" style="animation-delay: 0.2s;">
        <a href="{{ url('/') }}"
            class="text-sm text-gray-400 hover:text-blue-600 transition-all duration-300 inline-flex items-center gap-2 group">
            <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform duration-300"></i>
            {{ __("Retour à l'accueil") }}
        </a>
    </div>
</div>
</body>
</html>