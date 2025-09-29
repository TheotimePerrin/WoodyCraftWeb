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
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

}
