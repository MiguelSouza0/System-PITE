<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atrativos', function (Blueprint $table) {
            $table->string('cep', 10)->nullable()->after('endereco');
            $table->string('numero', 20)->nullable()->after('cep');
            $table->string('bairro')->nullable()->after('numero');
            $table->string('cidade')->nullable()->after('bairro');
            $table->string('uf', 2)->nullable()->after('cidade');
        });
    }

    public function down(): void
    {
        Schema::table('atrativos', function (Blueprint $table) {
            $table->dropColumn(['cep', 'numero', 'bairro', 'cidade', 'uf']);
        });
    }
};
