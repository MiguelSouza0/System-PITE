<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // --- ATRATIVOS ---
        Schema::table('atrativos', function (Blueprint $table) {
            $table->string('status_aprovacao')->default('pendente')->after('ativo');
            $table->foreignId('aprovado_por_user_id')->nullable()->after('status_aprovacao')->constrained('users')->nullOnDelete();
            $table->text('observacoes_admin')->nullable()->after('aprovado_por_user_id');
        });

        // Migrar registros existentes para 'aprovado' (não quebrar visibilidade atual)
        DB::table('atrativos')->update(['status_aprovacao' => 'aprovado']);

        // --- EVENTOS ---
        Schema::table('eventos', function (Blueprint $table) {
            $table->string('status_aprovacao')->default('pendente')->after('ativo');
            $table->foreignId('aprovado_por_user_id')->nullable()->after('status_aprovacao')->constrained('users')->nullOnDelete();
            $table->text('observacoes_admin')->nullable()->after('aprovado_por_user_id');
        });

        // Migrar registros existentes para 'aprovado'
        DB::table('eventos')->update(['status_aprovacao' => 'aprovado']);
    }

    public function down(): void
    {
        Schema::table('atrativos', function (Blueprint $table) {
            $table->dropForeign(['aprovado_por_user_id']);
            $table->dropColumn(['status_aprovacao', 'aprovado_por_user_id', 'observacoes_admin']);
        });

        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign(['aprovado_por_user_id']);
            $table->dropColumn(['status_aprovacao', 'aprovado_por_user_id', 'observacoes_admin']);
        });
    }
};
