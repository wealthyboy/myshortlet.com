<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class SystemSettingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\SystemSetting::factory()->count(1)->create();
    }
}
