<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-100">Finaliser ma commande</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4">

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-800 text-red-200 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Formulaire adresse et paiement --}}
            <div class="bg-gray-800 border border-gray-700 rounded shadow p-6">
                <form action="{{ route('checkout.valider') }}" method="POST">
                    @csrf

                    <h3 class="text-lg font-bold text-gray-100 mb-4">Adresse de livraison</h3>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-300 mb-1">Numero</label>
                        <input type="text" name="numero" value="{{ old('numero', $adresse->numero ?? '') }}"
                               class="border border-gray-600 bg-gray-900 text-gray-200 rounded w-full px-3 py-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-300 mb-1">Rue</label>
                        <input type="text" name="rue" value="{{ old('rue', $adresse->rue ?? '') }}"
                               class="border border-gray-600 bg-gray-900 text-gray-200 rounded w-full px-3 py-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-300 mb-1">Ville</label>
                        <input type="text" name="ville" value="{{ old('ville', $adresse->ville ?? '') }}"
                               class="border border-gray-600 bg-gray-900 text-gray-200 rounded w-full px-3 py-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-300 mb-1">Code postal</label>
                        <input type="text" name="code_postal" value="{{ old('code_postal', $adresse->code_postal ?? '') }}"
                               class="border border-gray-600 bg-gray-900 text-gray-200 rounded w-full px-3 py-2" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-1">Pays</label>
                        <input type="text" name="pays" value="{{ old('pays', $adresse->pays ?? '') }}"
                               class="border border-gray-600 bg-gray-900 text-gray-200 rounded w-full px-3 py-2" required>
                    </div>

                    <h3 class="text-lg font-bold text-gray-100 mb-3">Mode de paiement</h3>

                    <div class="space-y-2 mb-4">
                        <label class="flex items-center gap-2 cursor-pointer text-gray-300">
                            <input type="radio" name="mode_paiement" value="cheque"
                                   onchange="afficherChampsCarte(false)" checked>
                            <span>Par cheque (telecharge la facture PDF)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-gray-300">
                            <input type="radio" name="mode_paiement" value="paypal"
                                   onchange="afficherChampsCarte(false)">
                            <span>PayPal</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-gray-300">
                            <input type="radio" name="mode_paiement" value="carte"
                                   onchange="afficherChampsCarte(true)">
                            <span>Carte bancaire</span>
                        </label>
                    </div>

                    {{-- Champs carte bancaire : caches par defaut, affiches si carte selectionnee --}}
                    <div id="champs-carte" class="hidden mb-6 space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Nom sur la carte</label>
                            <input type="text" name="card_nom"
                                   class="border border-gray-600 bg-gray-900 text-gray-200 rounded w-full px-3 py-2"
                                   placeholder="Ex : Jean Dupont">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Numero de carte</label>
                            <input type="text" name="card_numero" maxlength="19"
                                   class="border border-gray-600 bg-gray-900 text-gray-200 rounded w-full px-3 py-2"
                                   placeholder="XXXX XXXX XXXX XXXX">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Date d'expiration</label>
                                <input type="text" name="card_expiration" maxlength="5"
                                       class="border border-gray-600 bg-gray-900 text-gray-200 rounded w-full px-3 py-2"
                                       placeholder="MM/AA">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">CVC</label>
                                <input type="text" name="card_cvc" maxlength="3"
                                       class="border border-gray-600 bg-gray-900 text-gray-200 rounded w-full px-3 py-2"
                                       placeholder="123">
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded hover:bg-blue-700 font-semibold">
                        Valider ma commande
                    </button>
                </form>
            </div>

            {{-- Recapitulatif --}}
            <div class="bg-gray-800 border border-gray-700 rounded shadow p-6">
                <h3 class="text-lg font-bold text-gray-100 mb-4">Recapitulatif</h3>

                <table class="w-full mb-4">
                    @foreach($lignes as $ligne)
                        <tr class="border-b border-gray-700">
                            <td class="py-2 text-gray-300">{{ $ligne->puzzle->nom }} x{{ $ligne->quantite }}</td>
                            <td class="py-2 text-right text-gray-200">
                                {{ number_format($ligne->puzzle->prix * $ligne->quantite, 2, ',', ' ') }} €
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="text-right">
                    <span class="text-xl font-bold text-gray-100">
                        Total : {{ number_format($panier->total, 2, ',', ' ') }} €
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Affiche ou cache les champs carte bancaire selon le mode de paiement selectionne
        function afficherChampsCarte(afficher) {
            var champs = document.getElementById('champs-carte');
            if (afficher) {
                champs.classList.remove('hidden');
            } else {
                champs.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>