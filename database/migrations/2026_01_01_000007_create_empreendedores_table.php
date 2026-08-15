<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empreendedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('razao_social');
            $table->string('nome_fantasia')->nullable();
            $table->string('cnpj_cpf');
            $table->string('tipo_servico');
            $table->text('descricao')->nullable();
            $table->string('endereco')->nullable();
            $table->string('bairro')->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('status_aprovacao')->default('pendente');
            $table->boolean('selo_validado')->default(false);
            $table->date('vencimento_documentos')->nullable();
            $table->text('observacoes_admin')->nullable();
            $table->foreignId('aprovado_por_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empreendedores');
    }
};
