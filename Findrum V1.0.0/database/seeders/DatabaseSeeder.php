<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            BandSeeder::class,
            DrummerSeeder::class, 
            ComponentSeeder::class,
            Band_DrummerSeeder::class,
            Component_DrummerSeeder::class,
            UserSeeder::class,
        ]);
    }
}
