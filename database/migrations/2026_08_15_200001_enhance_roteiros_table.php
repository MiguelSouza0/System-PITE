<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roteiros', function (Blueprint $table) {
            if (!Schema::hasColumn('roteiros', 'ponto_partida')) {
                $table->string('ponto_partida')->nullable();
            }
            if (!Schema::hasColumn('roteiros', 'ponto_chegada')) {
                $table->string('ponto_chegada')->nullable();
            }
            if (!Schema::hasColumn('roteiros', 'distancia_total_km')) {
                $table->decimal('distancia_total_km', 8, 2)->default(0);
            }
            if (!Schema::hasColumn('roteiros', 'meio_transporte')) {
                $table->string('meio_transporte')->default('a_pe');
            }
            if (!Schema::hasColumn('roteiros', 'acessivel_pne')) {
                $table->boolean('acessivel_pne')->default(false);
            }
            if (!Schema::hasColumn('roteiros', 'faixa_etaria')) {
                $table->string('faixa_etaria')->default('livre');
            }
            if (!Schema::hasColumn('roteiros', 'orcamento_nivel')) {
                $table->string('orcamento_nivel')->default('gratuito');
            }
            if (!Schema::hasColumn('roteiros', 'tema')) {
                $table->string('tema')->default('cultural');
            }
            if (!Schema::hasColumn('roteiros', 'caracteristicas_percurso')) {
                $table->json('caracteristicas_percurso')->nullable();
            }
            if (!Schema::hasColumn('roteiros', 'servicos_disponiveis')) {
                $table->json('servicos_disponiveis')->nullable();
            }
            if (!Schema::hasColumn('roteiros', 'orientacoes_seguranca')) {
                $table->json('orientacoes_seguranca')->nullable();
            }
            if (!Schema::hasColumn('roteiros', 'polylines_coordenadas')) {
                $table->json('polylines_coordenadas')->nullable();
            }
            if (!Schema::hasColumn('roteiros', 'validado_por_user_id')) {
                $table->foreignId('validado_por_user_id')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('roteiros', 'resumo_ia')) {
                $table->text('resumo_ia')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Safe down
    }
};
