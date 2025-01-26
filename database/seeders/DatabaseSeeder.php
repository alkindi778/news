<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\NewsSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\PermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            PermissionSeeder::class,
            CategorySeeder::class,
            NewsSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
