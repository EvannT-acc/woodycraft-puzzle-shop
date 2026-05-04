<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-100">Detail du puzzle</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4">

        @if(session('succes'))
            <div class="mb-4 p-3 bg-green-800 text-green-200 rounded">{{ session('succes') }}</div>
        @endif
        @if(session('erreur'))
            <div class="mb-4 p-3 bg-red-800 text-red-200 rounded">{{ session('erreur') }}</div>
        @endif

        <a href="{{ route('categories.show', $puzzle->categorie) }}"
           class="text-blue-400 hover:underline text-sm">
            &larr; Retour a la categorie {{ $puzzle->categorie->nom }}
        </a>

        <div class="bg-gray-800 border border-gray-700 rounded shadow p-6 mt-4 flex flex-col md:flex-row gap-6">

            {{-- Image du puzzle --}}
            <div class="md:w-1/2">
                @if($puzzle->image)
                    <img src="{{ asset('images/puzzles/' . $puzzle->image) }}"
                         alt="{{ $puzzle->nom }}"
                         class="w-full rounded">
                @else
                    <div class="w-full h-64 bg-gray-700 rounded flex items-center justify-center">
                        <span class="text-gray-400">Pas d'image</span>
                    </div>
                @endif
            </div>

            {{-- Informations du puzzle --}}
            <div class="md:w-1/2">
                <h1 class="text-2xl font-bold text-gray-100 mb-2">{{ $puzzle->nom }}</h1>
                <p class="text-sm text-gray-400 mb-1">Categorie : {{ $puzzle->categorie->nom }}</p>
                <p class="text-gray-300 mb-4">{{ $puzzle->description }}</p>

                <p class="text-3xl font-bold text-blue-400 mt-4 mb-6">
                    {{ number_format($puzzle->prix, 2, ',', ' ') }} €
                </p>

                @auth
                    <form action="{{ route('panier.add', $puzzle) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 font-semibold">
                            Ajouter au panier
                        </button>
                    </form>

                    {{-- Boutons admin --}}
                    @if(auth()->user()->role === 'admin')
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('puzzles.edit', $puzzle) }}"
                               class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                                Modifier
                            </a>
                            <form action="{{ route('puzzles.destroy', $puzzle) }}" method="POST"
                                  onsubmit="return confirm('Supprimer ce puzzle ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="inline-block bg-gray-700 text-gray-200 px-4 py-2 rounded hover:bg-gray-600">
                        Se connecter pour acheter
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>