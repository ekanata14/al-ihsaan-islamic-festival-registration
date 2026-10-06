<?php

namespace Tests\Feature;

use App\Models\CheckIn;
use App\Models\Child;
use App\Models\Participant;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class WaliExperienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_messages_are_in_indonesian_with_friendly_labels(): void
    {
        app()->setLocale('id');

        $validator = Validator::make(
            ['participants' => [['name' => 'Ani']]],
            ['participants.*.photo_url' => 'required|file|mimes:jpeg,png,pdf|max:20480']
        );

        $this->assertStringContainsStringIgnoringCase(
            'Foto peserta wajib diisi.',
            $validator->errors()->first('participants.0.photo_url')
        );
    }

    public function test_wrong_file_type_message_is_human_friendly(): void
    {
        app()->setLocale('id');

        $validator = Validator::make(
            ['participants' => [['photo_url' => UploadedFile::fake()->create('salah.txt', 10)]]],
            ['participants.*.photo_url' => 'file|mimes:jpeg,png,pdf']
        );

        $this->assertStringContainsStringIgnoringCase(
            'Foto peserta harus berupa berkas dengan tipe',
            $validator->errors()->first('participants.0.photo_url')
        );
    }

    public function test_oversize_upload_message_uses_friendly_label(): void
    {
        app()->setLocale('id');

        $validator = Validator::make(
            ['proof' => UploadedFile::fake()->create('bukti.jpg', 30000)],
            ['proof' => 'file|max:20480']
        );

        $this->assertStringContainsStringIgnoringCase(
            'tidak boleh lebih dari 20480 kilobyte',
            $validator->errors()->first('proof')
        );
    }

    public function test_wali_dashboard_shows_unpaid_participants_and_cart(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $child = Child::factory()->create(['pic_id' => $user->id, 'name' => 'Anak Belum Bayar']);
        $registration = Registration::factory()->create(['pic_id' => $user->id]);
        Participant::factory()->create([
            'registration_id' => $registration->id,
            'child_id' => $child->id,
        ]);
        Payment::factory()->create([
            'pic_id' => $user->id,
            'status' => Payment::STATUS_BELUM_BAYAR,
            'total_amount' => 10000,
        ]);

        $response = $this->actingAs($user)->get(route('user.dashboard'));

        $response->assertOk();
        $response->assertSee('Peserta Belum Dibayar');
        $response->assertSee('Anak Belum Bayar');
        $response->assertSee('Bayar Sekarang');
    }

    public function test_cart_hidden_when_payment_verified(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $child = Child::factory()->create(['pic_id' => $user->id]);
        $registration = Registration::factory()->create(['pic_id' => $user->id]);
        Participant::factory()->create([
            'registration_id' => $registration->id,
            'child_id' => $child->id,
        ]);
        Payment::factory()->create([
            'pic_id' => $user->id,
            'status' => Payment::STATUS_TERVERIFIKASI,
        ]);

        $this->actingAs($user)->get(route('user.dashboard'))
            ->assertOk()
            ->assertDontSee('Peserta Belum Dibayar');
    }

    public function test_bottom_nav_renders_for_user(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('user.dashboard'));

        $response->assertOk();
        $response->assertSee('Pembayaran');
        $response->assertSee('Akun');
    }

    public function test_mobile_bottom_nav_renders_announcement_menu_for_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Registrasi');
    }

    public function test_account_settings_page_renders_and_updates_profile(): void
    {
        $user = User::factory()->create(['role' => 'user', 'phone_number' => '0800000000']);

        $this->actingAs($user)->get(route('profile.edit'))
            ->assertOk()
            ->assertSee('Pengaturan Akun')
            ->assertSee('Informasi Profil')
            ->assertSee('Ubah Kata Sandi');

        $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'Nama Baru',
            'email' => $user->email,
            'phone_number' => '081234567890',
        ])->assertRedirect(route('profile.edit'));

        $this->assertSame('081234567890', $user->fresh()->phone_number);
    }

    public function test_participants_page_uses_cards_not_a_table(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $registration = Registration::factory()->create(['pic_id' => $user->id]);
        Participant::factory()->create([
            'registration_id' => $registration->id,
            'name' => 'Peserta Kartu',
        ]);

        $response = $this->actingAs($user)->get(route('user.participants'));

        $response->assertOk();
        $response->assertSee('Peserta Kartu');
        $response->assertSee('Detail');
        $response->assertDontSee('<table', false);
    }

    public function test_participants_card_shows_queue_number_after_check_in(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $registration = Registration::factory()->create(['pic_id' => $user->id, 'status' => 'checkin']);
        $participant = Participant::factory()->create([
            'registration_id' => $registration->id,
            'name' => 'Peserta Antri',
        ]);

        CheckIn::create([
            'participant_number' => 5,
            'pic_id' => $user->id,
            'participant_id' => $participant->id,
            'registration_id' => $registration->id,
            'competition_id' => $registration->competition_id,
        ]);

        $this->actingAs($user)->get(route('user.participants'))
            ->assertOk()
            ->assertSee('Nomor Urut: 5');
    }

    public function test_dashboard_shows_competition_progress_and_two_column_grid(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $registration = Registration::factory()->create(['pic_id' => $user->id, 'status' => 'checkin']);
        $participant = Participant::factory()->create(['registration_id' => $registration->id]);

        CheckIn::create([
            'participant_number' => 7,
            'pic_id' => $user->id,
            'participant_id' => $participant->id,
            'registration_id' => $registration->id,
            'competition_id' => $registration->competition_id,
        ]);

        $response = $this->actingAs($user)->get(route('user.dashboard'));

        $response->assertOk();
        $response->assertSee('Alur Perlombaan');
        $response->assertSee('Sedang Berlangsung');
        $response->assertSee('Nomor urut peserta Anda');
        $response->assertSee('grid-cols-2', false);
    }
}
