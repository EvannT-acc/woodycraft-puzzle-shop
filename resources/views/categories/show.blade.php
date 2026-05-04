<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-100">Categorie : {{ $categorie->nom }}</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">

        @if(session('succes'))
            <div class="mb-4 p-3 bg-green-800 text-green-200 rounded">{{ session('succes') }}</div>
        @endif
        @if(session('erreur'))
            <div class="mb-4 p-3 bg-red-800 text-red-200 rounded">{{ session('erreur') }}</div>
        @endif

        <a href="{{ route('dashboard') }}" class="text-blue-400 hover:underline text-sm">
            &larr; Retour aux categories
        </a>

        <h3 class="text-2xl font-bold mt-4 mb-6 text-gray-100">{{ $categorie->nom }}</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($categorie->puzzles as $puzzle)
                <div class="bg-gray-800 border border-gray-700 rounded shadow p-4 flex flex-col">

                    @if($puzzle->image)
                        <img src="{{ asset('images/puzzles/' . $puzzle->image) }}"
                             alt="{{ $puzzle->nom }}"
                             class="w-full h-40 object-cover rounded mb-3">
                    @else
                        <div class="w-full h-40 bg-gray-700 rounded mb-3 flex items-center justify-center">
                            <span class="text-gray-400">Pas d'image</span>
                        </div>
                    @endif

                    <h4 class="font-bold text-gray-100">{{ $puzzle->nom }}</h4>
                    <p class="text-sm text-gray-400 mb-2">{{ Str::limit($puzzle->description, 80) }}</p>

                    <p class="font-bold text-blue-400 text-lg mb-3">
                        {{ number_format($puzzle->prix, 2, ',', ' ') }} €
                    </p>

                    <div class="mt-auto flex gap-2">
                        <a href="{{ route('puzzles.show', $puzzle) }}"
                           class="flex-1 text-center bg-gray-700 text-gray-200 py-2 rounded hover:bg-gray-600 text-sm">
                            Voir le detail
                        </a>

                        @auth
                            <form action="{{ route('panier.add', $puzzle) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 text-sm">
                                    Ajouter
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            @empty
                <p class="text-gray-400 col-span-3">Aucun puzzle dans cette categorie.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>