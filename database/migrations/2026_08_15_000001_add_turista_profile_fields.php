<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nacionalidade')->nullable()->after('ativo');
            $table->string('cep', 20)->nullable()->after('nacionalidade');
            $table->string('cidade_origem')->nullable()->after('cep');
            $table->string('estado_origem')->nullable()->after('cidade_origem');
            $table->string('pais_origem')->nullable()->default('Brasil')->after('estado_origem');
            $table->boolean('possui_conjuge')->nullable()->default(false)->after('pais_origem');
            $table->boolean('possui_filhos')->nullable()->default(false)->after('possui_conjuge');
            $table->unsignedInteger('quantidade_filhos')->nullable()->default(0)->after('possui_filhos');
            $table->json('interesses')->nullable()->after('quantidade_filhos');
            $table->json('necessidades_especiais')->nullable()->after('interesses');
            $table->string('avatar_url')->nullable()->after('necessidades_especiais');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nacionalidade',
                'cep',
                'cidade_origem',
                'estado_origem',
                'pais_origem',
                'possui_conjuge',
                'possui_filhos',
                'quantidade_filhos',
                'interesses',
                'necessidades_especiais',
                'avatar_url',
            ]);
        });
    }
};
