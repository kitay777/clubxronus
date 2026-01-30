<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// database/seeders/PointSettingSeeder.php
use App\Models\PointSetting;

class PointSettingSeeder extends Seeder
{
    public function run(): void
    {
        PointSetting::firstOrCreate([], [
            'base_rate'        => 1.0,
            'event_bonus_rate' => 0.0,
            'event_enabled'    => false,
        ]);
    }
}
