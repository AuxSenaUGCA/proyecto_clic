<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sentences', function (Blueprint $table) {
            $table->string('note_sentence', 200)->nullable()->after('state_sentence');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->string('note_section', 200)->nullable()->after('state_section');
        });
    }

    public function down(): void
    {
        Schema::table('sentences', function (Blueprint $table) {
            $table->dropColumn('note_sentence');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('note_section');
        });
    }
};
