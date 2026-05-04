<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    // On precise le nom de la table car Laravel cherche "categories" par defaut
    protected $table = 'categories';

    protected $fillable = [
        'nom',
        'description',
        'image',
    ];

    // Une categorie contient plusieurs puzzles
    public function puzzles()
    {
        return $this->hasMany(Puzzle::class);
    }
}