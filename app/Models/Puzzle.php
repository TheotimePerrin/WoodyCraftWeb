<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'categorie',
        'description',
        'prix',
        'image',
        'stock',
    ];

    // Relation avec la catégorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    // Relation avec Panier via la table pivot "appartient"
    public function paniers()
    {
        return $this->belongsToMany(Panier::class, 'appartient')
                    ->withPivot('quantite');
    }
}
