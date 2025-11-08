<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'MyLMS',
                'type' => 'string',
                'group' => 'general',
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'string',
                'group' => 'general',
            ],
            [
                'key' => 'site_description',
                'value' => 'Platform Pembelajaran Online Terbaik',
                'type' => 'string',
                'group' => 'general',
            ],
            [
                'key' => 'logo_height',
                'value' => '40',
                'type' => 'number',
                'group' => 'general',
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
