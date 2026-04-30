<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('puzzles', function (Blueprint $table) {
            $table->id();

            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->decimal('prix', 10, 2);
            $table->integer('stock')->default(0);

            // 🔗 Catégorie (FK)
            $table->foreignId('categorie_id')
                  ->constrained('categories')
                  ->onDelete('cascade');

            // 🔗 Fournisseur (FK)
            $table->foreignId('fournisseur_id')
                  ->nullable()
                  ->constrained('fournisseurs')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('puzzles');
    }
};