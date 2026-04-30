<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Puzzle;
use  App\Models\Panier;
use  App\Models\Fournisseur;

class PuzzleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $puzzles = Puzzle::all();
        return view('puzzles.index', compact('puzzles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('puzzles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request ->validate([
            'nom' => 'required|max:100',
            'categorie_id' => 'required|numeric|between:0,99.99',
            'description' => 'required|max:500',
            'image' => 'required|max:100',
            'prix' => 'required|numeric|between:0,99.99',
            'stock'=> 'required|numeric|between:1,99',
            'fk_fournisseur' => 'required|numeric|between:0,99.99'
        ]);

        $puzzle = new Puzzle();
        $puzzle->nom = $request->nom;
        $puzzle->categorie_id = $request->categorie_id;
        $puzzle->description = $request->description;
        $puzzle->image = $request->image;
        $puzzle->prix = $request->prix;
        $puzzle->stock = $request->stock;
        $puzzle->fk_fournisseur = $request->fk_fournisseur;
        $puzzle->save();
        return back()->with('message', "Le puzzle a bien été crée !");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $puzzle = Puzzle::findOrFail($id);
        return view('puzzles.show', compact('puzzle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $puzzle = Puzzle::findOrFail($id); 
        return view('puzzles.edit', compact('puzzle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Puzzle $puzzle)
    {
        $data = $request->validate([
            'nom' => 'required|max:100',
            'categorie_id' => 'required|exists:categories,id',
            'description' => 'required|max:500',
            'prix' => 'required|numeric|between:0,99.99',
            'fk_fournisseur' => 'required|exists:fournisseur,id',
        ]);

        $puzzle->nom = $data['nom'];
        $puzzle->categorie_id = $data['categorie_id'];
        $puzzle->description = $data['description'];
        $puzzle->prix = $data['prix'];
        $puzzle->fk_fournisseur = $data['fk_fournisseur'];


        $puzzle->save();

        return redirect()->route('puzzles.edit', $puzzle->id)
                        ->with('message', 'Le puzzle a bien été mis à jour !');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Puzzle $puzzle)
    {
        $puzzle->delete();
        
        return redirect()->route('puzzles.index')
                         ->with('message', 'Le puzzle a été supprimé avec succès.');
    }

    public function ajouterAuPanier($id)
    {
        $user = Auth::user();

        // Récupère le panier "en cours" ou le crée
        $panier = Panier::firstOrCreate(
            ['user_id' => $user->id, 'statut' => 'en cours'],
            ['total' => 0, 'mode_paiement' => null]
        );

        // Récupère le puzzle à ajouter
        $puzzle = Puzzle::findOrFail($id);

        // Ajoute le puzzle au panier
        // Si le puzzle existe déjà dans le panier, incrémente la quantité
        if ($panier->puzzles()->where('puzzle_id', $id)->exists()) {
            $pivot = $panier->puzzles()->where('puzzle_id', $id)->first()->pivot;
            $pivot->quantite += 1;
            $pivot->save();
        } else {
            $panier->puzzles()->attach($id, ['quantite' => 1]);
        }

        // Met à jour le total du panier
        $panier->total = $panier->puzzles->sum(function ($p) {
            return $p->prix * $p->pivot->quantite;
        });
        $panier->save();

        return redirect()->route('paniers.index')->with('success', 'Puzzle ajouté au panier !');
    }

}
