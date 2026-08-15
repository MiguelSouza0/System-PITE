<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->string('acao'); // criou, editou, publicou, desativou, excluiu
            $table->string('tabela'); // atrativos, eventos, empreendedores...
            $table->unsignedBigInteger('registro_id');
            $table->json('dados_antes')->nullable();
            $table->json('dados_depois')->nullable();
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditoria');
    }
};
