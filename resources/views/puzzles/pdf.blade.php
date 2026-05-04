<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des puzzles</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h1 { font-size: 18px; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 6px; }
        th { background: #eee; text-align: left; }
        .prix { text-align: right; }
    </style>
</head>
<body>
    <h1>Liste des puzzles</h1>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Categorie</th>
                <th>Stock</th>
                <th class="prix">Prix (€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($puzzles as $puzzle)
                <tr>
                    <td>{{ $puzzle->nom }}</td>
                    <td>{{ $puzzle->categorie ? $puzzle->categorie->nom : 'N/A' }}</td>
                    <td>{{ $puzzle->stock }}</td>
                    <td class="prix">{{ number_format($puzzle->prix, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>