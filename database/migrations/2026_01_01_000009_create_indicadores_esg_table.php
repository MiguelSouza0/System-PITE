<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indicadores_esg', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atrativo_id')->nullable()->constrained('atrativos')->cascadeOnDelete();
            $table->string('pilar');
            $table->string('metrica');
            $table->decimal('valor', 12, 2);
            $table->string('unidade_medida');
            $table->integer('ano_referencia');
            $table->string('evidencia_url')->nullable();
            $table->string('status_auditoria')->default('rascunho');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indicadores_esg');
    }
};
