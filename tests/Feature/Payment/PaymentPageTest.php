<?php

namespace Tests\Feature\Payment;

use App\Models\Child;
use App\Models\Competition;
use App\Models\Group;
use App\Models\Participant;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentPageTest extends TestCase
{
    use RefreshDatabase;

    private function pic(): User
    {
        return User::factory()->create(['role' => 'user', 'group_id' => Group::factory()]);
    }

    public function test_wali_can_open_payment_page(): void
    {
        $response = $this->actingAs($this->pic())->get(route('user.payment'));

        $response->assertOk();
        $response->assertSee('Pembayaran Pendaftaran');
    }

    public function test_wali_can_open_receipt_when_verified(): void
    {
        $pic = $this->pic();
        Payment::factory()->create([
            'pic_id' => $pic->id,
            'status' => Payment::STATUS_TERVERIFIKASI,
            'verified_amount' => 10000,
            'total_amount' => 10000,
            'child_count' => 1,
            'verified_at' => now(),
        ]);

        $response = $this->actingAs($pic)->get(route('user.payment.receipt'));

        $response->assertOk();
        $response->assertSee('Bukti Pendaftaran');
    }

    public function test_wali_without_verification_cannot_open_receipt(): void
    {
        $pic = $this->pic();
        Payment::factory()->create(['pic_id' => $pic->id, 'status' => Payment::STATUS_BELUM_BAYAR]);

        $response = $this->actingAs($pic)->get(route('user.payment.receipt'));

        $response->assertForbidden();
    }

    public function test_admin_can_open_payment_detail(): void
    {
        $pic = $this->pic();
        $competition = Competition::factory()->create();
        $child = Child::factory()->create(['pic_id' => $pic->id]);

        $registration = Registration::factory()->create([
            'pic_id' => $pic->id,
            'competition_id' => $competition->id,
            'group_id' => $pic->group_id,
        ]);
        Participant::factory()->create([
            'registration_id' => $registration->id,
            'child_id' => $child->id,
            'nik' => $child->nik,
        ]);

        $payment = Payment::factory()->create(['pic_id' => $pic->id, 'child_count' => 1, 'total_amount' => 10000]);

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard.payment.detail', $payment->id));

        $response->assertOk();
        $response->assertSee('Detail Pembayaran');
        $response->assertSee($child->name);
    }

    public function test_admin_can_export_verified_participants(): void
    {
        $pic = $this->pic();
        $competition = Competition::factory()->create();
        $child = Child::factory()->create(['pic_id' => $pic->id]);

        $registration = Registration::factory()->create([
            'pic_id' => $pic->id,
            'competition_id' => $competition->id,
            'group_id' => $pic->group_id,
        ]);
        Participant::factory()->create([
            'registration_id' => $registration->id,
            'child_id' => $child->id,
            'nik' => $child->nik,
        ]);
        Payment::factory()->create(['pic_id' => $pic->id, 'status' => Payment::STATUS_TERVERIFIKASI]);

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('verified-participants.export'));

        $response->assertOk();
    }
}
