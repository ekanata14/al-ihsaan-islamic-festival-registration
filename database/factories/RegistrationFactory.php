<?php

namespace Database\Factories;

use App\Models\Competition;
use App\Models\Group;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

    public function definition(): array
    {
        return [
            'registration_number' => 'AIIF-' . fake()->unique()->numerify('############'),
            'pic_id' => User::factory(),
            'competition_id' => Competition::factory(),
            'group_id' => Group::factory(),
            'total_participants' => '1',
            'status' => 'registered',
        ];
    }
}
