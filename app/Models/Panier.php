<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',       // 0 = en cours, 1 = paye
        'total',
        'mode_paiement', // cheque, paypal ou carte
    ];

    // Un panier appartient a un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un panier contient plusieurs lignes (un produit par ligne)
    public function lignes()
    {
        return $this->hasMany(LignePanier::class);
    }
}