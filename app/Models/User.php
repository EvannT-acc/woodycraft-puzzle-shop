<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'role',
        'telephone',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // Retourne "Prenom Nom" en un seul appel : $user->nom_complet
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    // Un utilisateur a une seule adresse de livraison
    public function adresse()
    {
        return $this->hasOne(Adresse::class);
    }

    // Un utilisateur a plusieurs paniers (historique des commandes)
    public function paniers()
    {
        return $this->hasMany(Panier::class);
    }

    // Un utilisateur peut laisser plusieurs avis
    public function avis()
    {
        return $this->hasMany(Avis::class);
    }
}