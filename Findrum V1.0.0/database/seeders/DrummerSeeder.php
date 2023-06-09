<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Drummer;
use App\Models\Band;

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
        Drummer::find(1)->bands()->attach(Band::find(1));

        Drummer::create([
            'first_name' => 'Dave',
            'last_name' => 'Grohl',
        ]);
        Drummer::find(2)->bands()->attach(Band::find(1));

        Drummer::create([
            'first_name' => 'Sid',
            'last_name' => 'Brinkmans',
        ]);
        Drummer::find(3)->bands()->attach(Band::find(2));

        Drummer::create([
            'first_name' => 'Phil',
            'last_name' => 'Rudd',
        ]);
        Drummer::find(3)->bands()->attach(Band::find(3));
    }
}
