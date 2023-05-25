<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Band;

class BandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Band::create([
            'name' => 'The Foo Fighters', //Taylor Hawkins, Dave Grohl.
        ]);
        Band::create([
            'name' => 'Middle Green', // Sid Brinkmans
        ]);
        Band::create([
            'name' => 'ACDC', //Phil Rudd
        ]);
    }
}
