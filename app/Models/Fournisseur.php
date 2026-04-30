<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $table = 'fournisseur';

    protected $fillable = [
        'nom',
        'rue',
        'ville',
        'code_postal',
        'pays',
    ];

    /**
     * Relation : un fournisseur a plusieurs puzzles
     */
    public function puzzles()
    {
        return $this->hasMany(Puzzle::class, 'fournisseur_id');
    }
}