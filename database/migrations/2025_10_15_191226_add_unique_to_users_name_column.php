<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega la restricción única al campo 'name'
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo agrega la restricción si no existe aún
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->unique()->after('id');
            } else {
                $table->unique('name');
            }
        });
    }

    /**
     * Revierte el cambio
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });
    }
};
