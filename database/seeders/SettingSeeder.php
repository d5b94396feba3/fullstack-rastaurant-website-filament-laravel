<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'SAVOR Fine Dining',
            'hero_title' => 'Taste Perfection in Every Dish.',
            'hero_subtitle' => 'Fresh ingredients sourced daily, prepared by master chefs.',
            'announcement_text' => 'Get 15% off your first delivery order!',
            'doordash_url' => 'https://www.doordash.com',
            'ubereats_url' => 'https://www.ubereats.com',
            'grubhub_url' => 'https://www.grubhub.com',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}