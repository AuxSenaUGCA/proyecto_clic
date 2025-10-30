<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            // Primero eliminamos la antigua clave foránea (si existe)
            $table->dropForeign(['id_profe']);

            // Luego volvemos a crearla apuntando a la tabla teachers
            $table->foreign('id_profe')
                  ->references('id')
                  ->on('teachers')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            // Revertimos el cambio: eliminamos la relación con teachers
            $table->dropForeign(['id_profe']);

            // Y la restauramos apuntando nuevamente a users
            $table->foreign('id_profe')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }
};
