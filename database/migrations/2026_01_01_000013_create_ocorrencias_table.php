<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ocorrencias', function (Blueprint $table) {
            $table->id();
            $table->string('local');
            $table->string('categoria'); // acidente, furto, emergencia_medica, risco_ambiental
            $table->date('data');
            $table->string('gravidade'); // baixa, media, alta, critica
            $table->string('situacao')->default('aberta'); // aberta, em_atendimento, resolvida
            $table->text('descricao');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->foreignId('registrado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ocorrencias');
    }
};
