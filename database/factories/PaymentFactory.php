<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'pic_id' => User::factory(),
            'invoice_number' => 'INV-AIIF-' . fake()->unique()->numerify('############'),
            'mode' => 'per_anak',
            'unit_amount' => 10000,
            'child_count' => 0,
            'lomba_count' => 0,
            'total_amount' => 0,
            'verified_amount' => null,
            'status' => Payment::STATUS_BELUM_BAYAR,
            'verified_by' => null,
            'verified_at' => null,
            'rejection_reason' => null,
        ];
    }
}
