<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_visitas', function (Blueprint $table) {
            $table->id();
            $table->string('ip_hash', 64)->nullable()->index(); // Hash anonimizado para LGPD
            $table->string('url', 255)->default('/');
            $table->string('metodo', 10)->default('GET');
            $table->string('dispositivo', 50)->default('desktop'); // mobile, desktop, tablet
            $table->string('navegador', 50)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('data_visita')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_visitas');
    }
};
