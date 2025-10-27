<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sentences', function (Blueprint $table) {
            // Eliminar el campo antiguo
            if (Schema::hasColumn('sentences', 'section')) {
                $table->dropColumn('section');
            }

            // Agregar nueva relación
            $table->unsignedBigInteger('id_section')->nullable()->after('level');

            $table->foreign('id_section')
                  ->references('id_section')
                  ->on('sections')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('sentences', function (Blueprint $table) {
            $table->dropForeign(['id_section']);
            $table->dropColumn('id_section');

            // Restaurar el campo anterior (por si haces rollback)
            $table->string('section')->nullable();
        });
    }
};
