<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Group;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            "name" => "Admin",
            "email"=> "admin@admin.com",
            'phone_number'=> '00000000000000',
            "password"=> bcrypt("password"),
            "role" => 'admin',
        ]);

        Group::create([
            'name'=> 'TPQ Ar-Rahman',
        ]);

        Group::create([
            'name'=> 'TPQ Al-Ihsaan',
        ]);

        Group::create([
            'name'=> 'TPQ Miftahul Falah',
        ]);

        Group::create([
            'name'=> 'TPQ Miftahur Rohmah',
        ]);


    }
}
