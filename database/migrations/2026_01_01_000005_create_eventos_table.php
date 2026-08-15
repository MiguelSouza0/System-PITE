<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('descricao');
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim');
            $table->string('local');
            $table->foreignId('atrativo_id')->nullable()->constrained('atrativos')->nullOnDelete();
            $table->decimal('preco_ingresso', 10, 2)->default(0.00);
            $table->string('organizador')->nullable();
            $table->boolean('gratuito')->default(true);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
