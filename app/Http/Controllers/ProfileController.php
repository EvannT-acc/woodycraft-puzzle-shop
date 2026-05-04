<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Affiche le formulaire de profil de l'utilisateur
    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    // Met a jour les informations du profil
    public function update(Request $request)
    {
        $donnees = $request->validate([
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,' . Auth::id(),
            'telephone' => 'nullable|string|max:20',
        ]);

        $request->user()->update($donnees);

        return back()->with('succes', 'Profil mis a jour.');
    }

    // Supprime le compte de l'utilisateur
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}