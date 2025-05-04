<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Group;
use App\Models\Category;
use App\Models\Competition;

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
            "email" => "admin@admin.com",
            'phone_number' => '00000000000000',
            "password" => bcrypt("password"),
            "role" => 'admin',
        ]);

        Group::create([
            'name' => 'TPQ Ar-Rahman',
        ]);

        Group::create([
            'name' => 'TPQ Al-Ihsaan',
        ]);

        Group::create([
            'name' => 'TPQ Miftahul Falah',
        ]);

        Group::create([
            'name' => 'TPQ Miftahur Rohmah',
        ]);

        Category::create([
            'name' => '4 - 6 Tahun',
        ]);

        Category::create([
            'name' => '7 - 9 Tahun',
        ]);

        Category::create([
            'name' => '10 - 12 Tahun',
        ]);

        Category::create([
            'name' => '13 - 15 Tahun',
        ]);

        Category::create([
            'name' => '10 - 15 Tahun',
        ]);

        Category::create([
            'name' => 'Umum',
        ]);

        Competition::create([
            'name' => 'Lomba Adzan',
            'description' => 'Lomba Adzan',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Individual',
            'category_id' => 3,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);

        Competition::create([
            'name' => 'Lomba Adzan',
            'description' => 'Lomba Adzan',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Individual',
            'category_id' => 4,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);

        Competition::create([
            'name' => 'Lomba Hafalan Juz 30',
            'description' => 'Lomba Hafalan Juz 30',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Individual',
            'category_id' => 2,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);

        Competition::create([
            'name' => 'Lomba Hafalan Juz 30',
            'description' => 'Lomba Hafalan Juz 30',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Individual',
            'category_id' => 3,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);

        Competition::create([
            'name' => 'Lomba Hafalan Juz 30',
            'description' => 'Lomba Hafalan Juz 30',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Individual',
            'category_id' => 4,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);

        Competition::create([
            'name' => 'Lomba Fashion Show',
            'description' => 'Lomba Fashion Show',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Individual',
            'category_id' => 1,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);

        Competition::create([
            'name' => 'Lomba Fashion Show',
            'description' => 'Lomba Fashion Show',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Individual',
            'category_id' => 2,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);

        Competition::create([
            'name' => 'Lomba Story Telling',
            'description' => 'Lomba Story Telling',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Individual',
            'category_id' => 3,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);

        Competition::create([
            'name' => 'Lomba Story Telling',
            'description' => 'Lomba Story Telling',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Individual',
            'category_id' => 4,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);

        Competition::create([
            'name' => 'Lomba Hadroh',
            'description' => 'Lomba Hadroh',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Group',
            'category_id' => 6,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);

        Competition::create([
            'name' => 'Lomba Doa Harian',
            'description' => 'Lomba Doa Harian',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Individual',
            'category_id' => 1,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);

        Competition::create([
            'name' => 'Lomba Cerdas Cermat',
            'description' => 'Lomba Cerdas Cermat',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Group',
            'category_id' => 5,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);

        Competition::create([
            'name' => 'Lomba Mewarnai',
            'description' => 'Lomba Mewarnai',
            'image_url' => 'images/logo_only.jpg',
            'type' => 'Individual',
            'category_id' => 1,
            'registration_start' => '2025-05-05',
            'registration_end' => '2025-06-07',
            'status' => 'Open',
        ]);
    }
}
