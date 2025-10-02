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
        Schema::create('sentences', function (Blueprint $table) {
            $table->id('id_sentence');                           // ID auto-incrementable
            $table->integer('number_sentence');                  // Número de la oración
            $table->text('text_sentence');                       // Texto de la oración
            $table->enum('state_sentence', ['active', 'inactive'])
                ->default('active');                           // Estado
            $table->timestamps();                                // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sentences');
    }
};
