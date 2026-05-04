<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-100">Tableau de bord - Nos categories</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">

        @if(session('succes'))
            <div class="mb-4 p-3 bg-green-800 text-green-200 rounded">{{ session('succes') }}</div>
        @endif

        @auth
            @if(auth()->user()->role === 'admin')
                <div class="mb-4">
                    <a href="{{ route('puzzles.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Ajouter un puzzle
                    </a>
                    <a href="{{ route('puzzles.export-pdf') }}"
                       class="ml-2 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Exporter en PDF
                    </a>
                </div>
            @endif
        @endauth

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($categories as $categorie)
                <div class="bg-gray-800 border border-gray-700 rounded shadow p-4">

                    @if($categorie->image)
                        <img src="{{ asset('images/categories/' . $categorie->image) }}"
                             alt="{{ $categorie->nom }}"
                             class="w-full h-40 object-cover rounded mb-3">
                    @else
                        <div class="w-full h-40 bg-gray-700 rounded mb-3 flex items-center justify-center">
                            <span class="text-gray-400">Pas d'image</span>
                        </div>
                    @endif

                    <h3 class="text-lg font-bold text-gray-100">{{ $categorie->nom }}</h3>

                    @if($categorie->description)
                        <p class="text-sm text-gray-400 mb-2">{{ $categorie->description }}</p>
                    @endif

                    <p class="text-sm text-gray-500 mb-3">{{ $categorie->puzzles_count }} puzzle(s)</p>

                    <a href="{{ route('categories.show', $categorie) }}"
                       class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                        Voir les puzzles
                    </a>
                </div>
            @empty
                <p class="text-gray-400 col-span-3">Aucune categorie disponible.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>