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
        Schema::create('cubes', function (Blueprint $table) {
            $table->id('id_cube');                    // ID auto-incrementable
            $table->integer('number_cube');           // Número del cubo
            $table->text('text_cube');                // Texto del cubo
            $table->enum('state_cube', ['active', 'inactive'])->default('active'); // Estado
            $table->timestamps();                     // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cubes');
    }
};
