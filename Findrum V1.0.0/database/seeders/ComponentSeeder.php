<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Drummer;
use App\Models\Component;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Component::create([
        //     'brand_id' => 2,
        //     'drummer_id' => 1,
        //     'name' => 'floor tom',
        //     'diameter' => '6.2',
        // ]);
        // Component::create([
        //     'brand_id' => 2,
        //     'drummer_id' => 1,
        //     'name' => 'High-hat',
        //     'diameter' => '6.4',
        // ]);
        // Component::create([
        //     'brand_id' => 1,
        //     'drummer_id' => 2,
        //     'name' => 'Crash bekken',
        //     'diameter' => '6.2',
        // ]);
        // Component::create([
        //     'brand_id' => 1,
        //     'drummer_id' => 2,
        //     'name' => 'Snair',
        //     'diameter' => '6.5',
        // ]);
        // Component::create([
        //     'brand_id' => 3,
        //     'drummer_id' => 3,
        //     'name' => 'Ride bekken',
        //     'diameter' => '6.2',
        // ]);
        // Component::create([
        //     'brand_id' => 1,
        //     'drummer_id' => 3,
        //     'name' => 'Tom',
        //     'diameter' => '4',
        // ]);
        // Component::create([
        //     'brand_id' => 3,
        //     'drummer_id' => 4,
        //     'name' => 'Tom',
        //     'diameter' => '10.6',
        // ]);
        // Component::create([
        //     'brand_id' => 3,
        //     'drummer_id' => 4,
        //     'name' => 'Kick',
        //     'diameter' => '15.7',
        // ]);
        Component::create([
            'brand_id' => 2,
            'name' => 'floor tom',
            'diameter' => '6.2',
        ]);
        Component::find(1)->drummers()->attach(Drummer::find(1));
        Component::find(1)->drummers()->attach(Drummer::find(2));
        Component::find(1)->drummers()->attach(Drummer::find(3));

        Component::create([
            'brand_id' => 2,
            'name' => 'High-hat',
            'diameter' => '6.4',
        ]);
        Component::find(2)->drummers()->attach(Drummer::find(2));
        Component::find(2)->drummers()->attach(Drummer::find(3));
        Component::find(2)->drummers()->attach(Drummer::find(4));

        Component::create([
            'brand_id' => 1,
            'name' => 'Crash bekken',
            'diameter' => '6.2',
        ]);
        Component::find(3)->drummers()->attach(Drummer::find(1));
        Component::find(3)->drummers()->attach(Drummer::find(3));
        Component::find(3)->drummers()->attach(Drummer::find(4));

        Component::create([
            'brand_id' => 1,
            'name' => 'Snair',
            'diameter' => '6.5',
        ]);
        Component::find(4)->drummers()->attach(Drummer::find(1));
        Component::find(4)->drummers()->attach(Drummer::find(2));
        Component::find(4)->drummers()->attach(Drummer::find(4));

        Component::create([
            'brand_id' => 3,
            'name' => 'Ride bekken',
            'diameter' => '6.2',
        ]);
        Component::find(5)->drummers()->attach(Drummer::find(1));
        Component::find(5)->drummers()->attach(Drummer::find(2));
        Component::find(5)->drummers()->attach(Drummer::find(3));

        Component::create([
            'brand_id' => 1,
            'name' => 'Tom',
            'diameter' => '4',
        ]);
        Component::find(6)->drummers()->attach(Drummer::find(2));
        Component::find(6)->drummers()->attach(Drummer::find(3));
        Component::find(6)->drummers()->attach(Drummer::find(4));

        Component::create([
            'brand_id' => 3,
            'name' => 'Tom',
            'diameter' => '10.6',
        ]);
        Component::find(7)->drummers()->attach(Drummer::find(1));
        Component::find(7)->drummers()->attach(Drummer::find(3));
        Component::find(7)->drummers()->attach(Drummer::find(4));

        Component::create([
            'brand_id' => 3,
            'name' => 'Kick',
            'diameter' => '15.7',
        ]);
        Component::find(8)->drummers()->attach(Drummer::find(1));
        Component::find(8)->drummers()->attach(Drummer::find(2));
        Component::find(8)->drummers()->attach(Drummer::find(4));
    }
}
