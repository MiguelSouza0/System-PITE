<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria as tabelas para persistência do Guia PITE IA:
     * - ai_conversas: histórico de mensagens do chat (por sessão)
     * - ai_planos_turismo: planos de turismo gerados pela IA e editáveis pelo turista
     */
    public function up(): void
    {
        // Conversas do Guia PITE IA (sessões de chat persistentes)
        Schema::create('ai_conversas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('sessao_id', 64)->index(); // UUID da sessão do chat
            $table->enum('remetente', ['user', 'bot']); // quem enviou
            $table->text('mensagem'); // texto da mensagem
            $table->json('dados_extras')->nullable(); // cards, sugestoes, etc.
            $table->string('idioma', 5)->default('pt');
            $table->timestamps();

            $table->index(['user_id', 'sessao_id']);
        });

        // Planos de Turismo Personalizados (gerados pela IA + editáveis)
        Schema::create('ai_planos_turismo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('titulo', 255);
            $table->text('descricao')->nullable();
            $table->unsignedTinyInteger('dias')->default(1); // duração em dias
            $table->json('itens'); // array de { dia, ordem, tipo, item_id, nome, notas }
            $table->json('preferencias')->nullable(); // filtros usados na geração
            $table->enum('status', ['rascunho', 'ativo', 'concluido', 'arquivado'])->default('rascunho');
            $table->string('sessao_chat_id', 64)->nullable(); // vincula ao chat que gerou
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_planos_turismo');
        Schema::dropIfExists('ai_conversas');
    }
};
