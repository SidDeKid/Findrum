<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create([
            'name' => 'Pearl',
        ]);
        Brand::create([
            'name' => 'Sonor',
        ]);
        Brand::create([
            'name' => 'Adams',
        ]);
        Brand::create([
            'name' => 'Overige',
        ]);
    }
}
