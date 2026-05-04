<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Modifier le puzzle : {{ $puzzle->nom }}</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4">
        <div class="bg-white rounded shadow p-6">

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $erreur)
                            <li>{{ $erreur }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('puzzles.update', $puzzle) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom du puzzle</label>
                    <input type="text" name="nom" value="{{ old('nom', $puzzle->nom) }}"
                           class="border rounded w-full px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4"
                              class="border rounded w-full px-3 py-2">{{ old('description', $puzzle->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prix (€)</label>
                    <input type="number" name="prix" value="{{ old('prix', $puzzle->prix) }}" step="0.01" min="0"
                           class="border rounded w-full px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', $puzzle->stock) }}" min="0"
                           class="border rounded w-full px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categorie</label>
                    <select name="categorie_id" class="border rounded w-full px-3 py-2" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('categorie_id', $puzzle->categorie_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nouvelle image (laisser vide pour garder l'actuelle)
                    </label>
                    @if($puzzle->image)
                        <img src="{{ asset('storage/' . $puzzle->image) }}"
                             alt="{{ $puzzle->nom }}" class="h-24 rounded mb-2">
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="border rounded w-full px-3 py-2">
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-semibold">
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('puzzles.show', $puzzle) }}"
                       class="bg-gray-200 text-gray-800 px-6 py-2 rounded hover:bg-gray-300">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>