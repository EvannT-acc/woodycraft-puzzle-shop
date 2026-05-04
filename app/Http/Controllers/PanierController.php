<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\LignePanier;
use App\Models\Puzzle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    // Affiche le panier en cours de l'utilisateur connecte
    public function index()
    {
        // firstOrCreate : recupere le panier en cours, ou en cree un s'il n'existe pas
        $panier = Panier::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 0],
            ['total'   => 0]
        );

        $lignes = $panier->lignes()->with('puzzle')->get();

        return view('paniers.index', compact('panier', 'lignes'));
    }

    // Ajoute un puzzle au panier
    public function add(Puzzle $puzzle)
    {
        if ($puzzle->stock < 1) {
            return back()->with('erreur', 'Ce puzzle est en rupture de stock.');
        }

        $panier = Panier::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 0],
            ['total'   => 0]
        );

        // Si ce puzzle est deja dans le panier, on incremente la quantite
        $ligne = LignePanier::where('panier_id', $panier->id)
            ->where('puzzle_id', $puzzle->id)
            ->first();

        if ($ligne) {
            if ($ligne->quantite >= $puzzle->stock) {
                return back()->with('erreur', 'Vous avez atteint le stock maximum disponible.');
            }
            $ligne->increment('quantite');
        } else {
            LignePanier::create([
                'panier_id' => $panier->id,
                'puzzle_id' => $puzzle->id,
                'quantite'  => 1,
            ]);
        }

        $this->recalculerTotal($panier);

        return back()->with('succes', 'Puzzle ajoute au panier.');
    }

    // Met a jour la quantite d'une ligne du panier
    public function update(Request $request, LignePanier $ligne)
    {
        // Securite : la ligne doit appartenir au panier de l'utilisateur connecte
        if ($ligne->panier->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['quantite' => 'required|integer|min:1']);

        if ($request->quantite > $ligne->puzzle->stock) {
            return back()->with('erreur', 'Stock insuffisant.');
        }

        $ligne->update(['quantite' => $request->quantite]);
        $this->recalculerTotal($ligne->panier);

        return back()->with('succes', 'Quantite mise a jour.');
    }

    // Supprime une ligne du panier
    public function remove(LignePanier $ligne)
    {
        // Securite : la ligne doit appartenir au panier de l'utilisateur connecte
        if ($ligne->panier->user_id !== Auth::id()) {
            abort(403);
        }

        $panier = $ligne->panier;
        $ligne->delete();
        $this->recalculerTotal($panier);

        return back()->with('succes', 'Puzzle retire du panier.');
    }

    // Methode privee : recalcule et sauvegarde le total du panier
    private function recalculerTotal(Panier $panier): void
    {
        $total = $panier->lignes()->with('puzzle')->get()
            ->sum(fn($l) => $l->puzzle->prix * $l->quantite);

        $panier->update(['total' => $total]);
    }
}