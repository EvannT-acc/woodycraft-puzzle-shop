<?php

namespace App\Http\Controllers;

use App\Models\Puzzle;
use App\Models\Categorie;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PuzzleController extends Controller
{
    // Page d'accueil : affiche toutes les categories
    public function dashboard()
    {
        $categories = Categorie::withCount('puzzles')->get();

        return view('dashboard', compact('categories'));
    }

    // Liste tous les puzzles avec recherche et filtre par categorie
    public function index(Request $request)
    {
        $query = Puzzle::with('categorie');

        if ($request->filled('q')) {
            $query->where('nom', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        $puzzles    = $query->latest()->paginate(12)->withQueryString();
        $categories = Categorie::orderBy('nom')->get();

        return view('puzzles.index', compact('puzzles', 'categories'));
    }

    // Affiche le detail d'un puzzle
    public function show(Puzzle $puzzle)
    {
        // On charge uniquement la categorie, plus d'avis affiches
        $puzzle->load('categorie');

        return view('puzzles.show', compact('puzzle'));
    }

    // Formulaire de creation (admin seulement)
    public function create()
    {
        $this->verifierAdmin();

        $categories = Categorie::orderBy('nom')->get();

        return view('puzzles.create', compact('categories'));
    }

    // Enregistre un nouveau puzzle
    public function store(Request $request)
    {
        $this->verifierAdmin();

        $donnees = $request->validate([
            'nom'          => 'required|string|max:150',
            'description'  => 'nullable|string|max:2000',
            'prix'         => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $donnees['image'] = $request->file('image')->store('puzzles', 'public');
        }

        $puzzle = Puzzle::create($donnees);

        return redirect()->route('puzzles.show', $puzzle)->with('succes', 'Puzzle cree avec succes.');
    }

    // Formulaire de modification (admin seulement)
    public function edit(Puzzle $puzzle)
    {
        $this->verifierAdmin();

        $categories = Categorie::orderBy('nom')->get();

        return view('puzzles.edit', compact('puzzle', 'categories'));
    }

    // Enregistre les modifications
    public function update(Request $request, Puzzle $puzzle)
    {
        $this->verifierAdmin();

        $donnees = $request->validate([
            'nom'          => 'required|string|max:150',
            'description'  => 'nullable|string|max:2000',
            'prix'         => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $donnees['image'] = $request->file('image')->store('puzzles', 'public');
        }

        $puzzle->update($donnees);

        return redirect()->route('puzzles.show', $puzzle)->with('succes', 'Puzzle modifie.');
    }

    // Supprime un puzzle
    public function destroy(Puzzle $puzzle)
    {
        $this->verifierAdmin();

        $puzzle->delete();

        return redirect()->route('puzzles.index')->with('succes', 'Puzzle supprime.');
    }

    // Exporte la liste des puzzles en PDF
    public function exportPdf()
    {
        $puzzles = Puzzle::with('categorie')->orderBy('nom')->get();
        $pdf     = Pdf::loadView('puzzles.pdf', compact('puzzles'));

        return $pdf->download('puzzles.pdf');
    }

    // Verifie que l'utilisateur connecte est bien admin
    private function verifierAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acces reserve aux administrateurs.');
        }
    }
}