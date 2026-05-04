<?php

use App\Http\Controllers\AvisController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PuzzleController;
use Illuminate\Support\Facades\Route;

// Page d'accueil : redirige vers le dashboard
Route::get('/', fn() => redirect()->route('dashboard'))->name('home');

// Dashboard : affiche la liste des categories
Route::get('/dashboard', [PuzzleController::class, 'dashboard'])->name('dashboard');

// Categories : affiche les puzzles d'une categorie
Route::get('/categories/{categorie}', [CategorieController::class, 'show'])->name('categories.show');

// Puzzles : pages de lecture accessibles a tous
Route::get('/puzzles', [PuzzleController::class, 'index'])->name('puzzles.index');
Route::get('/puzzles/export-pdf', [PuzzleController::class, 'exportPdf'])->name('puzzles.export-pdf');

// Puzzles : creation et modification (auth obligatoire, verif admin dans le controller)
Route::middleware('auth')->group(function () {
    Route::get('/puzzles/creer', [PuzzleController::class, 'create'])->name('puzzles.create');
    Route::post('/puzzles', [PuzzleController::class, 'store'])->name('puzzles.store');
    Route::get('/puzzles/{puzzle}/modifier', [PuzzleController::class, 'edit'])->name('puzzles.edit');
    Route::put('/puzzles/{puzzle}', [PuzzleController::class, 'update'])->name('puzzles.update');
    Route::delete('/puzzles/{puzzle}', [PuzzleController::class, 'destroy'])->name('puzzles.destroy');
});

// IMPORTANT : cette route doit etre apres les routes fixes /puzzles/creer et /puzzles/export-pdf
Route::get('/puzzles/{puzzle}', [PuzzleController::class, 'show'])->name('puzzles.show');

// Panier : connexion obligatoire
Route::middleware('auth')->group(function () {
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/panier/{puzzle}', [PanierController::class, 'add'])->name('panier.add');
    Route::patch('/panier/ligne/{ligne}', [PanierController::class, 'update'])->name('panier.update');
    Route::delete('/panier/ligne/{ligne}', [PanierController::class, 'remove'])->name('panier.remove');
});

// Checkout : connexion obligatoire
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'valider'])->name('checkout.valider');
});

// Profil : connexion obligatoire
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Avis : connexion obligatoire
Route::middleware('auth')->group(function () {
    Route::post('/puzzles/{puzzle}/avis', [AvisController::class, 'store'])->name('avis.store');
    Route::delete('/avis/{avis}', [AvisController::class, 'destroy'])->name('avis.destroy');
});

// Routes d'authentification generees automatiquement par Breeze (login, register, etc.)
require __DIR__ . '/auth.php';