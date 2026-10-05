<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Child>
 */
class ChildFactory extends Factory
{
    protected $model = Child::class;

    public function definition(): array
    {
        return [
            'pic_id' => User::factory(),
            'name' => fake()->name(),
            'age' => (string) fake()->numberBetween(5, 15),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->date('Y-m-d', '-5 years'),
            'nik' => fake()->unique()->numerify('################'),
        ];
    }
}
