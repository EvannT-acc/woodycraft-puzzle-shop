<?php

namespace App\Http\Controllers;

use App\Models\Categorie;

class CategorieController extends Controller
{
    // Affiche une categorie et tous ses puzzles
    public function show(Categorie $categorie)
    {
        // On charge les puzzles lies a cette categorie
        $categorie->load('puzzles');

        return view('categories.show', compact('categorie'));
    }
}