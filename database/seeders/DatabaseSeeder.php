<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\Models\User;
use App\Models\Group;
use App\Models\Category;
use App\Models\Competition;
use App\Models\Registration;
use App\Models\Participant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Create Admin User
        User::create([
            "name" => "Admin",
            "email" => "admin@festival.alihsaan-sanur.org",
            'phone_number' => '00000000000000',
            "password" => bcrypt("adminFestival123#21"),
            "role" => 'admin',
        ]);

        // 2. Create Groups
        $groups = [
            Group::create(['name' => 'TPQ Ar-Rahman']),
            Group::create(['name' => 'TPQ Al-Ihsaan']),
            Group::create(['name' => 'TPQ Miftahul Falah']),
            Group::create(['name' => 'TPQ Miftahur Rohmah']),
        ];

        // 3. Create Categories
        $categories = [
            Category::create(['name' => '4 - 6 Tahun']),
            Category::create(['name' => '7 - 9 Tahun']),
            Category::create(['name' => '10 - 12 Tahun']),
            Category::create(['name' => '13 - 15 Tahun']),
            Category::create(['name' => '10 - 15 Tahun']),
            Category::create(['name' => 'Umum']),
        ];

        // 4. Create Competitions
        $competitions = [
            Competition::create(['name' => 'Adzan', 'description' => 'Adzan', 'image_url' => 'images/logo_only.jpg', 'type' => 'Individual', 'category_id' => 3, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
            Competition::create(['name' => 'Adzan', 'description' => 'Adzan', 'image_url' => 'images/logo_only.jpg', 'type' => 'Individual', 'category_id' => 4, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
            Competition::create(['name' => 'Hafalan Juz 30', 'description' => 'Hafalan Juz 30', 'image_url' => 'images/logo_only.jpg', 'type' => 'Individual', 'category_id' => 2, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
            Competition::create(['name' => 'Hafalan Juz 30', 'description' => 'Hafalan Juz 30', 'image_url' => 'images/logo_only.jpg', 'type' => 'Individual', 'category_id' => 3, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
            Competition::create(['name' => 'Hafalan Juz 30', 'description' => 'Hafalan Juz 30', 'image_url' => 'images/logo_only.jpg', 'type' => 'Individual', 'category_id' => 4, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
            Competition::create(['name' => 'Fashion Show', 'description' => 'Fashion Show', 'image_url' => 'images/logo_only.jpg', 'type' => 'Individual', 'category_id' => 1, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
            Competition::create(['name' => 'Fashion Show', 'description' => 'Fashion Show', 'image_url' => 'images/logo_only.jpg', 'type' => 'Individual', 'category_id' => 2, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
            Competition::create(['name' => 'Story Telling', 'description' => 'Story Telling', 'image_url' => 'images/logo_only.jpg', 'type' => 'Individual', 'category_id' => 3, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
            Competition::create(['name' => 'Story Telling', 'description' => 'Story Telling', 'image_url' => 'images/logo_only.jpg', 'type' => 'Individual', 'category_id' => 4, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
            Competition::create(['name' => 'Hadrah', 'description' => 'Hadrah', 'image_url' => 'images/logo_only.jpg', 'type' => 'Group', 'category_id' => 6, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
            Competition::create(['name' => 'Doa Harian', 'description' => 'Doa Harian', 'image_url' => 'images/logo_only.jpg', 'type' => 'Individual', 'category_id' => 1, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
            Competition::create(['name' => 'Cerdas Cermat', 'description' => 'Cerdas Cermat', 'image_url' => 'images/logo_only.jpg', 'type' => 'Group', 'category_id' => 5, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
            Competition::create(['name' => 'Mewarnai', 'description' => 'Mewarnai', 'image_url' => 'images/logo_only.jpg', 'type' => 'Individual', 'category_id' => 1, 'registration_start' => '2025-05-05', 'registration_end' => '2025-06-07', 'status' => 'Open']),
        ];

        // 5. Create PICs (Users) for Registrations
        $picUsers = [];
        for ($i = 0; $i < 15; $i++) {
            $picUsers[] = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'password' => bcrypt('password123'),
                'group_id' => $faker->numberBetween(1, count($groups)),
                'role' => 'user',
            ]);
        }

        // 6. Create 100 Registrations with Participants
        $registrationStatuses = ['Pending', 'Approved', 'Rejected'];

        for ($i = 1; $i <= 100; $i++) {
            // Pick a random competition and PIC
            $competition = $faker->randomElement($competitions);
            $pic = $faker->randomElement($picUsers);

            // Determine total participants based on competition type
            $isGroup = $competition->type === 'Group';
            $totalParticipants = $isGroup ? $faker->numberBetween(3, 5) : 1;

            // Generate Registration Number (e.g., REG-20250505-0001)
            $regNumber = 'REG-' . date('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT);

            // Create Registration
            $registration = Registration::create([
                'registration_number' => $regNumber,
                'pic_id' => $pic->id,
                'competition_id' => $competition->id,
                'group_id' => $pic->group_id, // Inheriting the PIC's group
                'total_participants' => (string) $totalParticipants,
                'status' => $faker->randomElement($registrationStatuses),
            ]);

            // Create Participants for this Registration
            for ($j = 0; $j < $totalParticipants; $j++) {
                Participant::create([
                    'registration_id' => $registration->id,
                    'name' => $faker->name,
                    'age' => (string) $faker->numberBetween(4, 15), // Mock age between 4 and 15
                    'birth_place' => $faker->city,
                    'birth_date' => $faker->date('Y-m-d', '2015-12-31'),
                    'nik' => $faker->numerify('35##############'), // 16 digits NIK mock (35 is East Java prefix)
                    'photo_url' => 'images/participants/default_photo.jpg',
                    'certificate_url' => 'images/participants/default_certificate.jpg',
                ]);
            }
        }
    }
}
