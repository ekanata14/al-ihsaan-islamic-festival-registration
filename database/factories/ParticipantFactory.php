<?php

namespace Database\Factories;

use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participant>
 */
class ParticipantFactory extends Factory
{
    protected $model = Participant::class;

    public function definition(): array
    {
        return [
            'registration_id' => Registration::factory(),
            'child_id' => null,
            'name' => fake()->name(),
            'age' => (string) fake()->numberBetween(5, 15),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->date('Y-m-d', '-5 years'),
            'nik' => fake()->unique()->numerify('################'),
            'photo_url' => 'participants/dummy.jpg',
            'certificate_url' => 'certificates/dummy.jpg',
        ];
    }
}
