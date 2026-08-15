<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roteiros', function (Blueprint $table) {
            $table->string('ponto_partida')->nullable()->after('descricao');
            $table->string('ponto_chegada')->nullable()->after('ponto_partida');
            $table->decimal('distancia_total_km', 8, 2)->default(0)->after('duracao_estimada_horas');
            $table->string('meio_transporte')->default('a_pe')->after('nivel_dificuldade'); // a_pe, bicicleta, carro, transporte_publico, misto
            $table->boolean('acessivel_pne')->default(false)->after('meio_transporte');
            $table->string('faixa_etaria')->default('livre')->after('acessivel_pne'); // livre, criancas, jovens, adultos, melhor_idade
            $table->string('orcamento_nivel')->default('gratuito')->after('faixa_etaria'); // gratuito, economico, moderado, premium
            $table->string('tema')->default('cultural')->after('orcamento_nivel'); // ecoturismo, historico, gastronomia, religioso, aventura, compras, cultural, misto
            $table->json('caracteristicas_percurso')->nullable()->after('tema'); // relevo, pavimentacao, sombra
            $table->json('servicos_disponiveis')->nullable()->after('caracteristicas_percurso'); // pontos_agua, banheiros, alimentacao, postos_saude, apoio_turista
            $table->json('orientacoes_seguranca')->nullable()->after('servicos_disponiveis'); // vestuario, hidratacao, protetor_solar, contatos_emergencia
            $table->json('polylines_coordenadas')->nullable()->after('orientacoes_seguranca');
            $table->foreignId('validado_por_user_id')->nullable()->constrained('users')->nullOnDelete()->after('gerado_por_ia');
            $table->text('resumo_ia')->nullable()->after('validado_por_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('roteiros', function (Blueprint $table) {
            $table->dropForeign(['validado_por_user_id']);
            $table->dropColumn([
                'ponto_partida',
                'ponto_chegada',
                'distancia_total_km',
                'meio_transporte',
                'acessivel_pne',
                'faixa_etaria',
                'orcamento_nivel',
                'tema',
                'caracteristicas_percurso',
                'servicos_disponiveis',
                'orientacoes_seguranca',
                'polylines_coordenadas',
                'validado_por_user_id',
                'resumo_ia'
            ]);
        });
    }
};
