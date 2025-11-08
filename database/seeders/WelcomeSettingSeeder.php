<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WelcomeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\WelcomeSetting::create([
            'hero_title' => 'Belajar Tanpa Batas',
            'hero_subtitle' => 'Platform LMS Modern',
            'hero_description' => 'Tingkatkan skill Anda dengan ribuan kursus berkualitas dari instruktur profesional. Akses selamanya, belajar kapan saja, dimana saja.',

            'stats_students' => '50K+',
            'stats_courses' => '150+',
            'stats_rating' => '4.9★',

            'feature_1_title' => 'Belajar Fleksibel',
            'feature_1_description' => 'Akses kapan saja, dimana saja dengan berbagai perangkat. Belajar sesuai dengan kecepatan Anda sendiri.',
            'feature_1_icon' => 'clock',

            'feature_2_title' => 'Sertifikat Resmi',
            'feature_2_description' => 'Dapatkan sertifikat yang diakui industri setelah menyelesaikan kursus. Tingkatkan kredibilitas profesional Anda.',
            'feature_2_icon' => 'certificate',

            'feature_3_title' => 'Instruktur Profesional',
            'feature_3_description' => 'Belajar langsung dari para ahli di bidangnya. Instruktur berpengalaman dengan track record terbukti.',
            'feature_3_icon' => 'users',

            'cta_title' => 'Siap Memulai Perjalanan Belajar Anda?',
            'cta_description' => 'Bergabunglah dengan ribuan pelajar yang telah meningkatkan skill mereka dan raih karir impian Anda.',
            'cta_button_text' => 'Mulai Sekarang',

            'email' => 'info@lms-platform.com',
            'phone' => '+62 812-3456-7890',
            'address' => 'Jakarta, Indonesia',
        ]);
    }
}
