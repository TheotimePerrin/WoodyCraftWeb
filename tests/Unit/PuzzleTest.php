<?php
namespace Tests\Unit;

use App\Models\Puzzle;
use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PuzzleTest extends TestCase
{
    use RefreshDatabase;

    // 👇 Helper réutilisable dans tous les tests
    private function getCategorieId(): int
    {
        return Categorie::factory()->create()->id;
    }

    public function test_puzzle_can_be_created()
    {
        $puzzle = Puzzle::factory()->create([
            'nom'          => 'Test Puzzle',
            'categorie_id' => $this->getCategorieId(),
            'description'  => 'Ceci est un puzzle de test.',
            'prix'         => 9.99,
            'image'        => 'test_image.png',
        ]);

        $this->assertDatabaseHas('puzzles', ['nom' => 'Test Puzzle']);
    }

    public function test_puzzle_creation_fails_with_missing_data()
    {
        $this->expectException(ValidationException::class);

        $validator = Validator::make(
            ['nom' => '', 'categorie_id' => '', 'description' => '', 'prix' => '', 'image' => ''],
            ['nom' => 'required', 'categorie_id' => 'required', 'description' => 'required', 'prix' => 'required|numeric', 'image' => 'required']
        );
        $validator->validate();
    }

    public function test_puzzle_creation_fails_with_invalid_data()
    {
        $this->expectException(ValidationException::class);

        $validator = Validator::make(
            ['nom' => str_repeat('A', 256), 'categorie_id' => 1, 'description' => 'desc', 'prix' => -5.99, 'image' => 'img.png'],
            ['nom' => 'required|max:255', 'categorie_id' => 'required', 'description' => 'required', 'prix' => 'required|numeric|min:0', 'image' => 'required']
        );
        $validator->validate();
    }

    public function test_puzzle_creation_fails_with_duplicate_data()
    {
        $categorieId = $this->getCategorieId();

        Puzzle::factory()->create(['nom' => 'Unique Puzzle', 'categorie_id' => $categorieId]);

        $this->expectException(ValidationException::class);

        $validator = Validator::make(
            ['nom' => 'Unique Puzzle', 'categorie_id' => $categorieId, 'description' => 'desc', 'prix' => 9.99, 'image' => 'img.png'],
            ['nom' => 'required|unique:puzzles,nom']
        );
        $validator->validate();
    }

    public function test_puzzle_can_be_read()
    {
        $puzzle = Puzzle::factory()->create(['nom' => 'Test Puzzle']);
        $found  = Puzzle::find($puzzle->id);

        $this->assertNotNull($found);
        $this->assertEquals('Test Puzzle', $found->nom);
    }

    public function test_puzzle_can_be_updated()
    {
        $puzzle = Puzzle::factory()->create();
        $puzzle->update(['nom' => 'Nom mis a jour']);

        $this->assertDatabaseHas('puzzles', ['nom' => 'Nom mis a jour']);
    }

    public function test_puzzle_can_be_deleted()
    {
        $puzzle = Puzzle::factory()->create();
        $puzzle->delete();

        $this->assertDatabaseMissing('puzzles', ['id' => $puzzle->id]);
    }
}