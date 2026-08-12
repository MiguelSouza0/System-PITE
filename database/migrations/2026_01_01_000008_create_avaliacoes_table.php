<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atrativo_id')->constrained('atrativos')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('nota');
            $table->text('comentario')->nullable();
            $table->date('visitado_em')->nullable();
            $table->string('comprovante_visita_path')->nullable();
            $table->string('status_verificacao')->default('pendente');
            $table->string('origem_turista')->default('nacional');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
