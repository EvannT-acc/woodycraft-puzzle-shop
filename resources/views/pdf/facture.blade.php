<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture n°{{ $panier->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h1 { font-size: 20px; }
        h3 { margin-top: 20px; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #f3f3f3; }
        .droite { text-align: right; }
    </style>
</head>
<body>
    <h1>Facture n°{{ $panier->id }}</h1>

    <p>
        <strong>Date :</strong> {{ $panier->updated_at->format('d/m/Y') }}<br>
        <strong>Client :</strong> {{ $user->prenom }} {{ $user->nom }} ({{ $user->email }})<br>
        <strong>Mode de paiement :</strong> {{ ucfirst($panier->mode_paiement) }}
    </p>

    <h3>Adresse de livraison</h3>
    <p>
        {{ $adresse->numero }} {{ $adresse->rue }}<br>
        {{ $adresse->code_postal }} {{ $adresse->ville }}<br>
        {{ $adresse->pays }}
    </p>

    <h3>Detail de la commande</h3>
    <table>
        <thead>
            <tr>
                <th>Puzzle</th>
                <th class="droite">Qte</th>
                <th class="droite">Prix unitaire</th>
                <th class="droite">Sous-total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lignes as $ligne)
                <tr>
                    <td>{{ $ligne->puzzle->nom }}</td>
                    <td class="droite">{{ $ligne->quantite }}</td>
                    <td class="droite">{{ number_format($ligne->puzzle->prix, 2, ',', ' ') }} €</td>
                    <td class="droite">{{ number_format($ligne->puzzle->prix * $ligne->quantite, 2, ',', ' ') }} €</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="droite">Total</th>
                <th class="droite">{{ number_format($panier->total, 2, ',', ' ') }} €</th>
            </tr>
        </tfoot>
    </table>

    @if($panier->mode_paiement === 'cheque')
        <h3>Instructions de paiement par cheque</h3>
        <p>
            Merci d'envoyer votre cheque a l'ordre de <strong>WoodyCraft</strong> a l'adresse :<br>
            <strong>WoodyCraft - 12 rue des Artisans - 75001 Paris</strong><br>
            Votre commande sera traitee a la reception du cheque.
        </p>
    @endif
</body>
</html>