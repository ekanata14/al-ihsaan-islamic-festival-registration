<?php

namespace Tests\Feature\Payment;

use App\Models\Child;
use App\Models\Competition;
use App\Models\Participant;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\User;
use App\Support\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PaymentVerificationTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function pic(): User
    {
        return User::factory()->create(['role' => 'user', 'group_id' => \App\Models\Group::factory()]);
    }

    private function waitingPayment(User $pic): Payment
    {
        return Payment::factory()->create([
            'pic_id' => $pic->id,
            'status' => Payment::STATUS_MENUNGGU_VERIFIKASI,
            'child_count' => 1,
            'lomba_count' => 1,
            'total_amount' => 10000,
        ]);
    }

    private function registerChild(User $pic, Competition $competition, string $nik): Child
    {
        $child = Child::firstOrCreate(
            ['pic_id' => $pic->id, 'nik' => $nik],
            ['name' => 'Anak ' . substr($nik, -3), 'age' => '10', 'birth_place' => 'Denpasar', 'birth_date' => '2015-01-01']
        );

        $registration = Registration::factory()->create([
            'pic_id' => $pic->id,
            'competition_id' => $competition->id,
            'group_id' => $pic->group_id,
        ]);

        Participant::factory()->create([
            'registration_id' => $registration->id,
            'child_id' => $child->id,
            'nik' => $nik,
        ]);

        return $child;
    }

    public function test_admin_can_verify_waiting_payment(): void
    {
        $pic = $this->pic();
        $admin = $this->admin();
        $payment = $this->waitingPayment($pic);

        $response = $this->actingAs($admin)->post(route('admin.dashboard.payment.verify', $payment->id));

        $response->assertRedirect();
        $payment->refresh();

        $this->assertSame(Payment::STATUS_TERVERIFIKASI, $payment->status);
        $this->assertSame($admin->id, $payment->verified_by);
        $this->assertNotNull($payment->verified_at);
        $this->assertSame($payment->total_amount, $payment->verified_amount);
        $this->assertDatabaseHas('payment_status_histories', [
            'payment_id' => $payment->id,
            'status' => Payment::STATUS_TERVERIFIKASI,
        ]);
    }

    public function test_cannot_verify_a_payment_that_is_not_waiting(): void
    {
        $pic = $this->pic();
        $admin = $this->admin();
        $payment = Payment::factory()->create(['pic_id' => $pic->id, 'status' => Payment::STATUS_BELUM_BAYAR]);

        $response = $this->actingAs($admin)
            ->from(route('admin.dashboard.payment.detail', $payment->id))
            ->post(route('admin.dashboard.payment.verify', $payment->id));

        $response->assertRedirect(route('admin.dashboard.payment.detail', $payment->id));
        $response->assertSessionHas('error');
        $this->assertSame(Payment::STATUS_BELUM_BAYAR, $payment->fresh()->status);
    }

    public function test_reject_requires_a_reason(): void
    {
        $pic = $this->pic();
        $admin = $this->admin();
        $payment = $this->waitingPayment($pic);

        $response = $this->actingAs($admin)
            ->from(route('admin.dashboard.payment.detail', $payment->id))
            ->post(route('admin.dashboard.payment.reject', $payment->id), ['reason' => '']);

        $response->assertSessionHasErrors('reason');
        $this->assertSame(Payment::STATUS_MENUNGGU_VERIFIKASI, $payment->fresh()->status);
    }

    public function test_reject_with_reason_records_it(): void
    {
        $pic = $this->pic();
        $admin = $this->admin();
        $payment = $this->waitingPayment($pic);

        $response = $this->actingAs($admin)
            ->post(route('admin.dashboard.payment.reject', $payment->id), ['reason' => 'Nominal tidak sesuai']);

        $response->assertRedirect();
        $payment->refresh();

        $this->assertSame(Payment::STATUS_DITOLAK, $payment->status);
        $this->assertSame('Nominal tidak sesuai', $payment->rejection_reason);
        $this->assertDatabaseHas('payment_status_histories', [
            'payment_id' => $payment->id,
            'status' => Payment::STATUS_DITOLAK,
            'reason' => 'Nominal tidak sesuai',
        ]);
    }

    public function test_wali_can_reupload_after_rejection(): void
    {
        Storage::fake('local');
        $pic = $this->pic();
        $payment = Payment::factory()->create([
            'pic_id' => $pic->id,
            'status' => Payment::STATUS_DITOLAK,
            'rejection_reason' => 'Bukti tidak jelas',
        ]);

        $response = $this->actingAs($pic)->post(route('user.payment.proof.store'), [
            'sender_name' => 'Budi',
            'transfer_date' => now()->toDateString(),
            'proof' => UploadedFile::fake()->image('bukti-baru.png'),
        ]);

        $response->assertSessionHasNoErrors();
        $payment->refresh();

        $this->assertSame(Payment::STATUS_MENUNGGU_VERIFIKASI, $payment->status);
        $this->assertNull($payment->rejection_reason);
    }

    public function test_changing_child_count_after_verification_shows_difference_without_overwriting(): void
    {
        config(['festival.fee.amount' => 10000, 'festival.fee.mode' => 'per_anak']);

        $pic = $this->pic();
        $competition = Competition::factory()->create();

        $this->registerChild($pic, $competition, '1111111111111111');

        $payment = app(PaymentService::class)->getOrCreateFor($pic);
        $payment->forceFill([
            'status' => Payment::STATUS_TERVERIFIKASI,
            'verified_by' => $this->admin()->id,
            'verified_at' => now(),
            'verified_amount' => 10000,
        ])->save();

        // Tambah anak kedua setelah verifikasi.
        $this->registerChild($pic, $competition, '2222222222222222');

        $payment = app(PaymentService::class)->sync($payment->fresh());

        $this->assertSame(20000, $payment->total_amount);
        $this->assertSame(10000, $payment->verified_amount);
        $this->assertSame(10000, $payment->difference());
        $this->assertTrue($payment->needsAdjustment());
    }
}
