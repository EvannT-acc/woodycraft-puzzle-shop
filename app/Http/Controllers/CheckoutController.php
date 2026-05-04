<?php

namespace App\Http\Controllers;

use App\Models\Adresse;
use App\Models\LignePanier;
use App\Models\Panier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Affiche la page de validation de commande
    public function index()
    {
        // On recupere le panier en cours, sinon erreur 404
        $panier  = Panier::where('user_id', Auth::id())->where('status', 0)->firstOrFail();
        $lignes  = $panier->lignes()->with('puzzle')->get();
        $adresse = Adresse::where('user_id', Auth::id())->first();

        return view('checkout.index', compact('panier', 'lignes', 'adresse'));
    }

    // Valide la commande et traite le paiement
    public function valider(Request $request)
    {
        $request->validate([
            'mode_paiement' => 'required|in:cheque,paypal,carte',
            'numero'        => 'required|string|max:50',
            'rue'           => 'required|string|max:150',
            'ville'         => 'required|string|max:100',
            'code_postal'   => 'required|string|max:20',
            'pays'          => 'required|string|max:100',
        ]);

        $user   = Auth::user();
        $panier = Panier::where('user_id', $user->id)->where('status', 0)->firstOrFail();
        $lignes = $panier->lignes()->with('puzzle')->get();

        if ($lignes->isEmpty()) {
            return back()->with('erreur', 'Votre panier est vide.');
        }

        // Sauvegarder ou mettre a jour l'adresse de livraison
        Adresse::updateOrCreate(
            ['user_id' => $user->id],
            $request->only('numero', 'rue', 'ville', 'code_postal', 'pays')
        );

        // Calculer le total et marquer le panier comme paye (status = 1)
        $total = $lignes->sum(fn($l) => $l->puzzle->prix * $l->quantite);
        $panier->update([
            'status'        => 1,
            'total'         => $total,
            'mode_paiement' => $request->mode_paiement,
        ]);

        // Creer un nouveau panier vide pour les prochains achats
        Panier::create(['user_id' => $user->id, 'status' => 0, 'total' => 0]);

        // Redirection selon le mode de paiement choisi
        if ($request->mode_paiement === 'cheque') {
            // Generer et telecharger la facture PDF
            $adresse = Adresse::where('user_id', $user->id)->first();
            $pdf     = Pdf::loadView('pdf.facture', compact('user', 'panier', 'lignes', 'adresse'));

            return $pdf->download('facture_' . $panier->id . '.pdf');
        }

        if ($request->mode_paiement === 'paypal') {
            return redirect()->away('https://www.paypal.com');
        }

        // Paiement par carte : redirection vers le dashboard avec message
        return redirect()->route('dashboard')->with('succes', 'Paiement par carte effectue avec succes.');
    }
}