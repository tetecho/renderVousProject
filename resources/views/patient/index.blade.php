<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('patient') }}
        </h2>
    </x-slot>

    <div class="py-12">

        @if (session('success'))
            <div>
                <p>{{ __('patient ajouter avec success') }}</p>
            </div>
        @endif

        <button onclick="showAjouteModal()">Ajouter Un Patient</button>

        {{-- Add modal --}}
        <div class="hidden" id="formAjoute">
            <form action="{{ route('patient.store') }}" method="POST">
                @csrf
                <div>
                    <label for="name">{{ __('name') }}</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div>
                    <label for="email">{{ __('email') }}</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div>
                    <label for="phone">{{ __('phone') }}</label>
                    <input type="text" name="phone" id="phone">
                </div>
                <div>
                    <label for="password">{{ __('password') }}</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit">{{ __('Ajouter le Patient') }}</button>
                <button type="button" onclick="hideAjouteModal()">{{ __('cancel') }}</button>
            </form>
        </div>

        {{-- Delete modal --}}
        <div class="hidden" id="modalDelete">
            <form id="deleteForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <p>{{ __('are you sure you want to delete the patient') }}</p>
                <button type="submit">{{ __('delete') }}</button>
                <button type="button" onclick="handelCancel()">{{ __('cancel') }}</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <td>{{ __('name') }}</td>
                    <td>{{ __('email') }}</td>
                    <td>{{ __('phone') }}</td>
                    <td>{{ __('action') }}</td>
                </tr>
            </thead>
            <tbody>
                @forelse ($patients as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->phone }}</td>
                        <td>
                            <a href="{{ route('patient.show', $p->id) }}">{{ __('view') }}</a>
                            <a href="{{ route('patient.edit', $p->id) }}">{{ __('modify') }}</a>
                            <button type="button" onclick="handelShowModal(event, {{ $p->id }})">
                                {{ __('delete') }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">{{ __('No Patient Was Found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        const handelShowModal = (e, id) => {
            e.preventDefault();
            const modal = document.getElementById('modalDelete');
            const form  = document.getElementById('deleteForm');
            form.action = `/patient/${id}`;
            modal.classList.remove('hidden');
        }

        const handelCancel = () => {
            document.getElementById('modalDelete').classList.add('hidden');
        }

        const showAjouteModal = () => {
            document.getElementById('formAjoute').classList.remove('hidden');
        }

        const hideAjouteModal = () => {
            document.getElementById('formAjoute').classList.add('hidden');
        }
    </script>
</x-app-layout>