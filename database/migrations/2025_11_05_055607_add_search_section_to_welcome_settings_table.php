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
        Schema::table('welcome_settings', function (Blueprint $table) {
            $table->string('search_title')->default('Temukan Kursus yang Tepat')->after('hero_image');
            $table->string('search_placeholder')->default('Cari kursus, topik, atau instruktur...')->after('search_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('welcome_settings', function (Blueprint $table) {
            $table->dropColumn(['search_title', 'search_placeholder']);
        });
    }
};
