<?php

namespace Tests\Feature\Payment;

use App\Models\Payment;
use App\Models\PaymentProof;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PaymentAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function pic(): User
    {
        return User::factory()->create(['role' => 'user']);
    }

    public function test_other_wali_cannot_view_someone_else_proof(): void
    {
        $owner = $this->pic();
        $other = $this->pic();

        $payment = Payment::factory()->create([
            'pic_id' => $owner->id,
            'status' => Payment::STATUS_MENUNGGU_VERIFIKASI,
        ]);
        PaymentProof::factory()->create(['payment_id' => $payment->id]);

        $response = $this->actingAs($other)->get(route('user.payment.proof.show'));

        $response->assertNotFound();
    }

    public function test_owner_can_view_own_proof(): void
    {
        Storage::fake('local');
        $owner = $this->pic();

        $payment = Payment::factory()->create(['pic_id' => $owner->id]);
        $path = UploadedFile::fake()->image('bukti.jpg')->storeAs('payment-proofs', 'bukti.jpg', 'local');
        PaymentProof::factory()->create([
            'payment_id' => $payment->id,
            'file_path' => $path,
            'mime_type' => 'image/jpeg',
        ]);

        $response = $this->actingAs($owner)->get(route('user.payment.proof.show'));

        $response->assertOk();
    }

    public function test_non_admin_cannot_verify_payment(): void
    {
        $pic = $this->pic();
        $payment = Payment::factory()->create([
            'pic_id' => $pic->id,
            'status' => Payment::STATUS_MENUNGGU_VERIFIKASI,
        ]);

        $response = $this->actingAs($pic)->post(route('admin.dashboard.payment.verify', $payment->id));

        $response->assertForbidden();
        $this->assertSame(Payment::STATUS_MENUNGGU_VERIFIKASI, $payment->fresh()->status);
    }

    public function test_non_admin_cannot_view_payment_index(): void
    {
        $response = $this->actingAs($this->pic())->get(route('admin.dashboard.payment'));

        $response->assertForbidden();
    }

    public function test_admin_can_view_payment_index(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard.payment'));

        $response->assertOk();
    }
}
