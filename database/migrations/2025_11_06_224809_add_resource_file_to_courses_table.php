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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('resource_file')->nullable()->after('preview_video_url'); // File resource untuk student (zip, pdf, dll)
            $table->string('resource_file_name')->nullable()->after('resource_file'); // Nama asli file
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['resource_file', 'resource_file_name']);
        });
    }
};
