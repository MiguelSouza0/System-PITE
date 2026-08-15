<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historico_visitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('atrativo_id')->constrained('atrativos')->cascadeOnDelete();
            $table->date('visitado_em');
            $table->integer('tempo_permanencia_min')->nullable();
            $table->text('notas_pessoais')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'atrativo_id', 'visitado_em'], 'visita_unica_por_dia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historico_visitas');
    }
};
