<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{-- update page --}}
</body>
</html><x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('modify') }} — {{ $patient->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <form action="{{ route('patient.update', $patient->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label for="name">{{ __('name') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name', $patient->name) }}" required>
            </div>
            <div>
                <label for="email">{{ __('email') }}</label>
                <input type="email" name="email" id="email" value="{{ old('email', $patient->email) }}" required>
            </div>
            <div>
                <label for="phone">{{ __('phone') }}</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}">
            </div>
            <div>
                <label for="password">{{ __('password') }} ({{ __('leave blank to keep current') }})</label>
                <input type="password" name="password" id="password">
            </div>

            <button type="submit">{{ __('save') }}</button>
            <a href="{{ route('patient.index') }}">{{ __('cancel') }}</a>
        </form>
    </div>
</x-app-layout>