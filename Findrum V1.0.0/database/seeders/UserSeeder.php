<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => "root",
            'password' => bcrypt("-2c@BPJ8:WmFfSk5JF+$(/R5e-GEfph,cVWjM8X8"), //Temporary
            'email' => 'root@development.com'
        ]);
        User::create([
            'name' => "Test",
            'password' => bcrypt("T3st"), //Temporary
            'email' => 'test@test.test'
        ]);
    }
}
