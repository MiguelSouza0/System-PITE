<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->morphs('favoritavel'); // favoritavel_id + favoritavel_type
            $table->timestamps();

            $table->unique(['user_id', 'favoritavel_id', 'favoritavel_type'], 'favorito_unico');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
