<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LignePanier extends Model
{
    use HasFactory;

    // Laravel genere "ligne_paniers" automatiquement depuis LignePanier
    protected $table = 'ligne_paniers';

    protected $fillable = [
        'panier_id',
        'puzzle_id',
        'quantite',
    ];

    // Une ligne appartient a un panier
    public function panier()
    {
        return $this->belongsTo(Panier::class);
    }

    // Une ligne contient un puzzle
    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class);
    }
}