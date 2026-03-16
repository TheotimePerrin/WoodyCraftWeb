<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Puzzle;

class PuzzleController extends Controller
{
    // GET /api/puzzles
    public function index()
    {
        return response()->json(Puzzle::all());
    }

    // POST /api/puzzles
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|max:100',
            'categorie_id' => 'required|integer',
            'description' => 'required|max:500',
            'image' => 'required|max:255',
            'prix' => 'required|numeric|between:0,99.99',
            'stock'=> 'required|integer|between:1,99'
        ]);

        $puzzle = Puzzle::create($validated);

        return response()->json([
            'message' => 'Puzzle créé avec succès',
            'data' => $puzzle
        ], 201);
    }

    // GET /api/puzzles/{id}
    public function show(string $id)
{
    $puzzle = Puzzle::select(
        'id',
        'nom',
        'description',
        'image',
        'prix',
        'stock'
    )->findOrFail($id);

    return response()->json($puzzle);
}

    // PUT /api/puzzles/{id}
    public function update(Request $request, string $id)
    {
        $puzzle = Puzzle::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|max:100',
            'categorie_id' => 'required|integer',
            'description' => 'required|max:500',
            'image' => 'required|max:255',
            'prix' => 'required|numeric|between:0,99.99',
            'stock'=> 'required|integer|between:1,99'
        ]);

        $puzzle->update($validated);

        return response()->json([
            'message' => 'Puzzle mis à jour',
            'data' => $puzzle
        ]);
    }

    // DELETE /api/puzzles/{id}
    public function destroy(string $id)
    {
        $puzzle = Puzzle::findOrFail($id);
        $puzzle->delete();

        return response()->json([
            'message' => 'Puzzle supprimé'
        ]);
    }
}