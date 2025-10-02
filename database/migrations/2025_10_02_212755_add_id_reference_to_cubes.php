<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cubes', function (Blueprint $table) {
            // Agregar el campo id_sentence
            $table->unsignedBigInteger('id_sentence')->nullable()->after('state_cube');

            // Definir la relación con sentences
            $table->foreign('id_sentence')
                ->references('id_sentence')
                ->on('sentences')
                ->onDelete('cascade');
            // O cascade si quieres que al borrar la sentence se borre el cube
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cubes', function (Blueprint $table) {
            // Primero eliminar la FK
            $table->dropForeign(['id_sentence']);
            // Luego eliminar el campo
            $table->dropColumn('id_sentence');
        });
    }
};
