<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::query()->delete();

        $settings = [
            ['key' => 'landing_theme', 'value' => 'aurora'],
            ['key' => 'landing_video_path', 'value' => null],
            [
                'key' => 'landing_theme_surfaces',
                'value' => json_encode([
                    'surface1' => 'linear-gradient(140deg, #0b1220 0%, #05060a 55%, #020205 100%)',
                    'surface2' => 'rgba(12,19,33,0.92)',
                    'surface3' => 'rgba(18,35,64,0.65)',
                    'accent' => '#38bdf8',
                    'accentSoft' => '#dbeafe',
                    'text_primary' => '#e2e8f0',
                    'text_secondary' => 'rgba(226, 232, 240, 0.75)',
                ]),
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}
