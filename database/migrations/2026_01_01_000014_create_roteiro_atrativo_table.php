<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roteiro_atrativo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roteiro_id')->constrained('roteiros')->onDelete('cascade');
            $table->foreignId('atrativo_id')->constrained('atrativos')->onDelete('cascade');
            $table->unsignedSmallInteger('ordem')->default(0);
            $table->string('tempo_estimado')->nullable(); // "30min", "1h"
            $table->text('observacao')->nullable();
            $table->timestamps();

            $table->unique(['roteiro_id', 'atrativo_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roteiro_atrativo');
    }
};
