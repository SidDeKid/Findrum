<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Drummer;

class DrummerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Drummer::create([
            'first_name' => 'Taylor',
            'last_name' => 'Hawkins',
        ]);
        Drummer::create([
            'first_name' => 'Dave',
            'last_name' => 'Grohl',
        ]);
        Drummer::create([
            'first_name' => 'Sid',
            'last_name' => 'Brinkmans',
        ]);
        Drummer::create([
            'first_name' => 'Phil',
            'last_name' => 'Rudd',
        ]);
    }
}
