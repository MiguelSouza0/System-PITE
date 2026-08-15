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
            $table->string('ponto_partida')->nullable();
            $table->string('ponto_chegada')->nullable();
            $table->integer('duracao_estimada_horas')->default(1);
            $table->decimal('distancia_total_km', 8, 2)->default(0);
            $table->string('nivel_dificuldade')->default('facil');
            $table->string('meio_transporte')->default('a_pe');
            $table->boolean('acessivel_pne')->default(false);
            $table->string('faixa_etaria')->default('livre');
            $table->string('orcamento_nivel')->default('gratuito');
            $table->string('tema')->default('cultural');
            $table->json('caracteristicas_percurso')->nullable();
            $table->json('servicos_disponiveis')->nullable();
            $table->json('orientacoes_seguranca')->nullable();
            $table->json('polylines_coordenadas')->nullable();
            $table->json('atrativos_ids')->nullable();
            $table->string('perfil_publico_alvo')->nullable();
            $table->boolean('gerado_por_ia')->default(false);
            $table->foreignId('validado_por_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('resumo_ia')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roteiros');
    }
};
