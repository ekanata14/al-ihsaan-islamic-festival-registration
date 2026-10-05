<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\PaymentProof;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentProof>
 */
class PaymentProofFactory extends Factory
{
    protected $model = PaymentProof::class;

    public function definition(): array
    {
        return [
            'payment_id' => Payment::factory(),
            'file_path' => 'payment-proofs/' . fake()->uuid() . '.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 1024,
            'sender_name' => fake()->name(),
            'transfer_date' => now()->toDateString(),
            'claimed_amount' => null,
            'uploaded_by' => null,
        ];
    }
}
