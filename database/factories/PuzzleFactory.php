<?php
namespace Database\Factories;

use App\Models\Puzzle;
use App\Models\Categorie; // 👈 manquait
use Illuminate\Database\Eloquent\Factories\Factory;

class PuzzleFactory extends Factory
{
    protected $model = Puzzle::class;

    public function definition()
    {
        return [
            'nom'          => $this->faker->word,
            'categorie_id' => Categorie::factory(),
            'description'  => $this->faker->sentence,
            'prix'         => $this->faker->randomFloat(2, 1, 99),
            'image'        => 'test_image.png',
            'stock'        => $this->faker->numberBetween(1, 99),
        ];
    }
}