<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'app_name',
                'value' => 'LMS Platform',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'app_description',
                'value' => 'Learning Management System',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'app_email',
                'value' => 'admin@lms.com',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'app_phone',
                'value' => '+62 812-3456-7890',
                'type' => 'text',
                'group' => 'general',
            ],

            // Regional Settings
            [
                'key' => 'timezone',
                'value' => 'Asia/Jakarta',
                'type' => 'text',
                'group' => 'regional',
            ],
            [
                'key' => 'locale',
                'value' => 'id_ID',
                'type' => 'text',
                'group' => 'regional',
            ],
            [
                'key' => 'country',
                'value' => 'Indonesia',
                'type' => 'text',
                'group' => 'regional',
            ],
            [
                'key' => 'province',
                'value' => 'DKI Jakarta',
                'type' => 'text',
                'group' => 'regional',
            ],
            [
                'key' => 'city',
                'value' => 'Jakarta Pusat',
                'type' => 'text',
                'group' => 'regional',
            ],
            [
                'key' => 'address',
                'value' => 'Jl. Sudirman No. 123',
                'type' => 'text',
                'group' => 'regional',
            ],
            [
                'key' => 'postal_code',
                'value' => '10110',
                'type' => 'text',
                'group' => 'regional',
            ],

            // Currency Settings
            [
                'key' => 'currency',
                'value' => 'IDR',
                'type' => 'text',
                'group' => 'currency',
            ],
            [
                'key' => 'currency_symbol',
                'value' => 'Rp',
                'type' => 'text',
                'group' => 'currency',
            ],
            [
                'key' => 'currency_position',
                'value' => 'before', // before or after
                'type' => 'text',
                'group' => 'currency',
            ],
            [
                'key' => 'decimal_separator',
                'value' => ',',
                'type' => 'text',
                'group' => 'currency',
            ],
            [
                'key' => 'thousand_separator',
                'value' => '.',
                'type' => 'text',
                'group' => 'currency',
            ],
            [
                'key' => 'decimal_places',
                'value' => '0',
                'type' => 'number',
                'group' => 'currency',
            ],

            // Payment Settings
            [
                'key' => 'tax_percentage',
                'value' => '11',
                'type' => 'number',
                'group' => 'payment',
            ],
            [
                'key' => 'tax_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'payment',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Settings seeded successfully!');
    }
}
