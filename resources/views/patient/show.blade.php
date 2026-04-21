<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('patient') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <p>{{ __('name') }} : {{ $patient->name }}</p>
        <p>{{ __('email') }} : {{ $patient->email }}</p>
        <p>{{ __('phone') }} : {{ $patient->phone ?? '—' }}</p>

        <a href="{{ route('patient.edit', $patient->id) }}">{{ __('modify') }}</a>

        <form action="{{ route('patient.destroy', $patient->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('{{ __('are you sure you want to delete the patient') }}')">
                {{ __('delete') }}
            </button>
        </form>

        <a href="{{ route('patient.index') }}">{{ __('back') }} →</a>
    </div>
</x-app-layout>