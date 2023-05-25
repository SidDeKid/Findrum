<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Band_DrummerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('band_drummer')->insert([
            'band_id' => 1,
            'drummer_id' => 1,
        ]);
        DB::table('band_drummer')->insert([
            'band_id' => 1,
            'drummer_id' => 2,
        ]);
        DB::table('band_drummer')->insert([
            'band_id' => 2,
            'drummer_id' => 3,
        ]);
        DB::table('band_drummer')->insert([
            'band_id' => 3,
            'drummer_id' => 4,
        ]);
    }
}
