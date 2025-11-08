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
        Schema::create('welcome_settings', function (Blueprint $table) {
            $table->id();

            // Hero Section
            $table->string('hero_title')->default('Belajar Tanpa Batas');
            $table->string('hero_subtitle')->default('Platform LMS Modern');
            $table->text('hero_description')->nullable();

            // Stats
            $table->string('stats_students')->default('50K+');
            $table->string('stats_courses')->default('150+');
            $table->string('stats_rating')->default('4.9★');

            // Features
            $table->string('feature_1_title')->default('Belajar Fleksibel');
            $table->text('feature_1_description')->nullable();
            $table->string('feature_1_icon')->default('clock');

            $table->string('feature_2_title')->default('Sertifikat Resmi');
            $table->text('feature_2_description')->nullable();
            $table->string('feature_2_icon')->default('certificate');

            $table->string('feature_3_title')->default('Instruktur Profesional');
            $table->text('feature_3_description')->nullable();
            $table->string('feature_3_icon')->default('users');

            // CTA Section
            $table->string('cta_title')->default('Siap Memulai Perjalanan Belajar Anda?');
            $table->text('cta_description')->nullable();
            $table->string('cta_button_text')->default('Mulai Sekarang');

            // Contact & Social
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welcome_settings');
    }
};
