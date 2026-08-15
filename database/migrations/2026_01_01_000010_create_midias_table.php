<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('midias', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // foto, video, 360, audio, documento
            $table->string('url');
            $table->string('thumbnail')->nullable();
            $table->string('titulo')->nullable();
            $table->text('descricao_alt')->nullable(); // acessibilidade — alt text
            $table->string('autoria')->nullable();
            $table->boolean('autorizado')->default(false);
            $table->morphs('entidade'); // entidade_id + entidade_type (Atrativo, Evento, Empreendedor)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('midias');
    }
};
