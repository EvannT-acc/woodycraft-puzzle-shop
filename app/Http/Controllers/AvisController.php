<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Puzzle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    // Ajoute un avis sur un puzzle
    public function store(Request $request, Puzzle $puzzle)
    {
        $request->validate([
            'commentaire' => 'required|string|max:500',
            'note'        => 'required|integer|between:1,5',
        ]);

        Avis::create([
            'user_id'     => Auth::id(),
            'puzzle_id'   => $puzzle->id,
            'commentaire' => $request->commentaire,
            'note'        => $request->note,
        ]);

        return back()->with('succes', 'Votre avis a ete ajoute.');
    }

    // Supprime un avis (seulement l'auteur ou un admin)
    public function destroy(Avis $avis)
    {
        if (Auth::id() !== $avis->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Vous ne pouvez pas supprimer cet avis.');
        }

        $avis->delete();

        return back()->with('succes', 'Avis supprime.');
    }
}