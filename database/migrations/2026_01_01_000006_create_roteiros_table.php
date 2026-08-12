<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roteiros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('descricao');
            $table->integer('duracao_estimada_horas')->default(1);
            $table->string('nivel_dificuldade')->default('facil');
            $table->json('atrativos_ids')->nullable();
            $table->string('perfil_publico_alvo')->nullable();
            $table->boolean('gerado_por_ia')->default(false);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roteiros');
    }
};
