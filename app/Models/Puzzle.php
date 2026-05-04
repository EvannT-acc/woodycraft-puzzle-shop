<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'image',
        'prix',
        'stock',
        'categorie_id',
    ];

    // Un puzzle appartient a une categorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    // Un puzzle peut avoir plusieurs avis
    public function avis()
    {
        return $this->hasMany(Avis::class);
    }
}