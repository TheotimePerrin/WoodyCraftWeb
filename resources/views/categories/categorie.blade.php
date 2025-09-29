<!DOCTYPE html>
<html>
<head>
    <title>{{ $categorie->nom }} - Produits</title>
</head>
<body>
    <h1>Produits dans la catégorie : {{ $categorie->nom }}</h1>

    <ul>
        @forelse ($categorie->puzzles as $puzzle)
            <li>{{ $puzzle->nom }}</li>
        @empty
            <li>Aucun produit dans cette catégorie.</li>
        @endforelse
    </ul>

</body>
</html>
