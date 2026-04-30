<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PuzzleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\AdresseController;
use App\Http\Controllers\FournisseurController;

Route::get('/', [CategorieController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD
    Route::resource('puzzles', PuzzleController::class);
    Route::resource('categories', CategorieController::class);
    Route::resource('fournisseurs', FournisseurController::class);
    Route::resource('adresses', AdresseController::class);
    Route::resource('paniers', PanierController::class);

    // actions spécifiques
    Route::get('/puzzle/add/{id}', [PuzzleController::class, 'ajouterAuPanier'])->name('puzzle.add');

    Route::get('/paiement', [PanierController::class, 'paiement'])->name('paniers.paiement');
    Route::post('/paiement', [PanierController::class, 'store'])->name('paiement.store');
    Route::get('/facture/pdf', [PanierController::class, 'facturePdf'])->name('facture.pdf');
});

require __DIR__.'/auth.php';