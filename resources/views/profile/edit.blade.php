<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Mon profil</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4">

        @if(session('succes'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('succes') }}</div>
        @endif

        {{-- Modifier les informations --}}
        <div class="bg-white rounded shadow p-6 mb-6">
            <h3 class="text-lg font-bold mb-4">Modifier mes informations</h3>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom', $user->nom) }}"
                           class="border rounded w-full px-3 py-2" required>
                    @error('nom')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prenom</label>
                    <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}"
                           class="border rounded w-full px-3 py-2" required>
                    @error('prenom')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="border rounded w-full px-3 py-2" required>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telephone</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}"
                           class="border rounded w-full px-3 py-2">
                </div>

                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-semibold">
                    Enregistrer
                </button>
            </form>
        </div>

        {{-- Supprimer le compte --}}
        <div class="bg-white rounded shadow p-6 border border-red-200">
            <h3 class="text-lg font-bold text-red-700 mb-4">Supprimer mon compte</h3>
            <p class="text-sm text-gray-600 mb-4">
                Cette action est irreversible. Toutes vos donnees seront supprimees.
            </p>

            <form action="{{ route('profile.destroy') }}" method="POST"
                  onsubmit="return confirm('Etes-vous certain de vouloir supprimer votre compte ?')">
                @csrf
                @method('DELETE')

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Confirmez votre mot de passe
                    </label>
                    <input type="password" name="password"
                           class="border rounded w-full px-3 py-2" required>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 font-semibold">
                    Supprimer mon compte
                </button>
            </form>
        </div>
    </div>
</x-app-layout>