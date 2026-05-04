<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-100">Mon panier</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">

        @if(session('succes'))
            <div class="mb-4 p-3 bg-green-800 text-green-200 rounded">{{ session('succes') }}</div>
        @endif
        @if(session('erreur'))
            <div class="mb-4 p-3 bg-red-800 text-red-200 rounded">{{ session('erreur') }}</div>
        @endif

        <a href="{{ route('dashboard') }}" class="text-blue-400 hover:underline text-sm">
            &larr; Continuer mes achats
        </a>

        <div class="bg-gray-800 border border-gray-700 rounded shadow mt-4">
            @if($lignes->isEmpty())
                <div class="p-8 text-center">
                    <p class="text-gray-400 text-lg">Votre panier est vide.</p>
                    <a href="{{ route('dashboard') }}"
                       class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Voir les puzzles
                    </a>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="p-3 text-left text-gray-200">Puzzle</th>
                            <th class="p-3 text-right text-gray-200">Prix unitaire</th>
                            <th class="p-3 text-center text-gray-200">Quantite</th>
                            <th class="p-3 text-right text-gray-200">Sous-total</th>
                            <th class="p-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lignes as $ligne)
                            <tr class="border-t border-gray-700">
                                <td class="p-3 text-gray-200">{{ $ligne->puzzle->nom }}</td>
                                <td class="p-3 text-right text-gray-300">
                                    {{ number_format($ligne->puzzle->prix, 2, ',', ' ') }} €
                                </td>
                                <td class="p-3 text-center">
                                    <form action="{{ route('panier.update', $ligne) }}" method="POST"
                                          class="flex items-center justify-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantite" value="{{ $ligne->quantite }}"
                                               min="1"
                                               class="border border-gray-600 bg-gray-900 text-gray-200 rounded w-16 px-2 py-1 text-center">
                                        <button type="submit"
                                                class="text-sm bg-gray-700 text-gray-200 px-2 py-1 rounded hover:bg-gray-600">
                                            OK
                                        </button>
                                    </form>
                                </td>
                                <td class="p-3 text-right font-semibold text-gray-100">
                                    {{ number_format($ligne->puzzle->prix * $ligne->quantite, 2, ',', ' ') }} €
                                </td>
                                <td class="p-3 text-center">
                                    <form action="{{ route('panier.remove', $ligne) }}" method="POST"
                                          onsubmit="return confirm('Supprimer ce produit ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:underline text-sm">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-4 border-t border-gray-700 flex justify-between items-center">
                    <span class="text-xl font-bold text-gray-100">
                        Total : {{ number_format($panier->total, 2, ',', ' ') }} €
                    </span>
                    <a href="{{ route('checkout.index') }}"
                       class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 font-semibold">
                        Passer commande
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>