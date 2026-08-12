<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atrativos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->text('descricao');
            $table->text('descricao_curta')->nullable();
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('endereco')->nullable();
            $table->string('horario_funcionamento')->nullable();
            $table->decimal('preco_medio', 10, 2)->default(0.00);
            $table->json('niveis_acessibilidade')->nullable();
            $table->json('caracteristicas_esg')->nullable();
            $table->boolean('destaque')->default(false);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atrativos');
    }
};
