<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('mensagem');
            $table->string('tipo'); // alerta, informacao, emergencia, campanha
            $table->json('criterio_envio')->nullable(); // localizacao, idioma, interesse, evento
            $table->timestamp('enviado_em')->nullable();
            $table->foreignId('criado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacoes');
    }
};
