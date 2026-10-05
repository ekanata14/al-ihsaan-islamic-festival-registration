<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Competition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Competition>
 */
class CompetitionFactory extends Factory
{
    protected $model = Competition::class;

    public function definition(): array
    {
        return [
            'name' => 'Lomba ' . fake()->unique()->bothify('##??'),
            'description' => fake()->sentence(),
            'image_url' => 'competitions/dummy.jpg',
            'type' => 'single',
            'category_id' => Category::factory(),
            'min_age' => null,
            'max_age' => null,
            'time_slot' => null,
            'registration_start' => now()->subDay()->toDateString(),
            'registration_end' => now()->addDays(10)->toDateString(),
            'status' => 'open',
        ];
    }

    public function timeSlot(string $slot): static
    {
        return $this->state(fn () => ['time_slot' => $slot]);
    }

    public function ages(?int $min, ?int $max): static
    {
        return $this->state(fn () => ['min_age' => $min, 'max_age' => $max]);
    }
}
