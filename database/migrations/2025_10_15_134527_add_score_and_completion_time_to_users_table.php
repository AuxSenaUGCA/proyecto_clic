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
        Schema::table('users', function (Blueprint $table) {
            // Campo de puntuación
            if (!Schema::hasColumn('users', 'score')) {
                $table->integer('score')->default(0)->after('avatar');
            }

            // Campo de tiempo de completado (en segundos)
            if (!Schema::hasColumn('users', 'completion_time')) {
                $table->integer('completion_time')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'score')) {
                $table->dropColumn('score');
            }

            if (Schema::hasColumn('users', 'completion_time')) {
                $table->dropColumn('completion_time');
            }
        });
    }
};
