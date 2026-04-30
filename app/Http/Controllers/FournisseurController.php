<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    // 📄 Liste fournisseurs
    public function index()
    {
        $fournisseurs = Fournisseur::all();

        return view('fournisseurs.index', compact('fournisseurs'));
    }

    // ➕ Formulaire
    public function create()
    {
        return view('fournisseurs.create');
    }

    // 💾 Stocker
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required'
        ]);

        Fournisseur::create($request->all());

        return redirect()->route('fournisseurs.index');
    }

    // ❌ Supprimer
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();

        return redirect()->route('fournisseurs.index');
    }
}