<?php

namespace Tests\Feature\Payment;

use App\Models\Payment;
use App\Models\PaymentProof;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PaymentUploadTest extends TestCase
{
    use RefreshDatabase;

    private function pic(): User
    {
        return User::factory()->create(['role' => 'user']);
    }

    public function test_valid_image_sets_waiting_verification_status(): void
    {
        Storage::fake('local');
        $pic = $this->pic();

        $response = $this->actingAs($pic)->post(route('user.payment.proof.store'), [
            'sender_name' => 'Budi Santoso',
            'transfer_date' => now()->toDateString(),
            'claimed_amount' => 10000,
            'proof' => UploadedFile::fake()->image('bukti.jpg'),
        ]);

        $response->assertRedirect(route('user.payment'));
        $response->assertSessionHasNoErrors();

        $payment = Payment::where('pic_id', $pic->id)->first();
        $this->assertNotNull($payment);
        $this->assertSame(Payment::STATUS_MENUNGGU_VERIFIKASI, $payment->status);

        $proof = PaymentProof::where('payment_id', $payment->id)->first();
        $this->assertNotNull($proof);
        Storage::disk('local')->assertExists($proof->file_path);
    }

    public function test_invalid_file_type_is_rejected(): void
    {
        Storage::fake('local');
        $pic = $this->pic();

        $response = $this->actingAs($pic)
            ->from(route('user.payment'))
            ->post(route('user.payment.proof.store'), [
                'sender_name' => 'Budi',
                'transfer_date' => now()->toDateString(),
                'proof' => UploadedFile::fake()->create('bukti.txt', 10, 'text/plain'),
            ]);

        $response->assertSessionHasErrors('proof');
        $this->assertSame(0, PaymentProof::count());
    }

    public function test_oversized_file_is_rejected(): void
    {
        Storage::fake('local');
        $pic = $this->pic();

        $response = $this->actingAs($pic)
            ->from(route('user.payment'))
            ->post(route('user.payment.proof.store'), [
                'sender_name' => 'Budi',
                'transfer_date' => now()->toDateString(),
                'proof' => UploadedFile::fake()->create('bukti.pdf', 4000, 'application/pdf'),
            ]);

        $response->assertSessionHasErrors('proof');
        $this->assertSame(0, PaymentProof::count());
    }

    public function test_stored_filename_is_obfuscated(): void
    {
        Storage::fake('local');
        $pic = $this->pic();

        $this->actingAs($pic)->post(route('user.payment.proof.store'), [
            'sender_name' => 'Budi',
            'transfer_date' => now()->toDateString(),
            'proof' => UploadedFile::fake()->image('nama-asli-anak.jpg'),
        ]);

        $proof = PaymentProof::first();
        $this->assertNotNull($proof);
        $this->assertStringNotContainsString('nama-asli', $proof->file_path);
        $this->assertStringEndsWith('.jpg', $proof->file_path);
    }

    public function test_guest_cannot_upload_proof(): void
    {
        $response = $this->post(route('user.payment.proof.store'), []);

        $response->assertRedirect(route('login'));
    }
}
