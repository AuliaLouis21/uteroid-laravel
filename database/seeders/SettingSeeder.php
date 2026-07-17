<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'PT. Utero Kreatif Indonesia'],
            ['key' => 'site_description', 'value' => 'Advertising, Digital Printing & Creative Agency'],
            ['key' => 'site_email', 'value' => 'marketingutero@gmail.com'],
            ['key' => 'site_phone', 'value' => '0341 408408'],
            ['key' => 'site_whatsapp', 'value' => '081 999 900 900'],
            ['key' => 'site_address', 'value' => 'Jalan Bantaran 1 No. 25, Tulusrejo, Kec. Lowokwaru, Malang, Jawa Timur 65141'],
            ['key' => 'site_instagram', 'value' => '@uteroindonesia'],
            ['key' => 'google_analytics_id', 'value' => ''],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
