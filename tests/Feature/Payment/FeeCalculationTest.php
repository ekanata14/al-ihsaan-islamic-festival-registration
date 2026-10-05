<?php

namespace Tests\Feature\Payment;

use App\Models\Child;
use App\Models\Competition;
use App\Models\Group;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\User;
use App\Support\FeeCalculator;
use App\Support\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeeCalculationTest extends TestCase
{
    use RefreshDatabase;

    private function pic(): User
    {
        return User::factory()->create(['role' => 'user', 'group_id' => Group::factory()]);
    }

    private function registerChild(User $pic, Competition $competition, string $nik, int $age = 10): Child
    {
        $child = Child::firstOrCreate(
            ['pic_id' => $pic->id, 'nik' => $nik],
            ['name' => 'Anak ' . substr($nik, -3), 'age' => (string) $age, 'birth_place' => 'Denpasar', 'birth_date' => '2015-01-01']
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
            'age' => (string) $age,
        ]);

        return $child;
    }

    public function test_zero_children_costs_zero(): void
    {
        config(['festival.fee.amount' => 10000, 'festival.fee.mode' => 'per_anak']);

        $summary = app(FeeCalculator::class)->forPic($this->pic());

        $this->assertSame(0, $summary['child_count']);
        $this->assertSame(0, $summary['total']);
    }

    public function test_one_child_in_two_competitions_is_charged_once(): void
    {
        config(['festival.fee.amount' => 10000, 'festival.fee.mode' => 'per_anak']);

        $pic = $this->pic();
        $c1 = Competition::factory()->create();
        $c2 = Competition::factory()->create();

        $this->registerChild($pic, $c1, '1111111111111111');
        $this->registerChild($pic, $c2, '1111111111111111');

        $summary = app(FeeCalculator::class)->forPic($pic);

        $this->assertSame(1, $summary['child_count']);
        $this->assertSame(2, $summary['lomba_count']);
        $this->assertSame(10000, $summary['total']);
    }

    public function test_multiple_children_are_summed(): void
    {
        config(['festival.fee.amount' => 10000, 'festival.fee.mode' => 'per_anak']);

        $pic = $this->pic();
        $competition = Competition::factory()->create();

        $this->registerChild($pic, $competition, '1111111111111111');
        $this->registerChild($pic, $competition, '2222222222222222');
        $this->registerChild($pic, $competition, '3333333333333333');

        $summary = app(FeeCalculator::class)->forPic($pic);

        $this->assertSame(3, $summary['child_count']);
        $this->assertSame(30000, $summary['total']);
    }

    public function test_per_lomba_mode_counts_registrations(): void
    {
        config(['festival.fee.mode' => 'per_lomba', 'festival.fee.amount' => 10000]);

        $pic = $this->pic();
        $c1 = Competition::factory()->create();
        $c2 = Competition::factory()->create();

        $this->registerChild($pic, $c1, '1111111111111111');
        $this->registerChild($pic, $c2, '1111111111111111');

        $summary = app(FeeCalculator::class)->forPic($pic);

        $this->assertSame(2, $summary['lomba_count']);
        $this->assertSame(20000, $summary['total']);
    }

    public function test_payment_total_is_recomputed_on_the_server(): void
    {
        config(['festival.fee.amount' => 10000, 'festival.fee.mode' => 'per_anak']);

        $pic = $this->pic();
        $competition = Competition::factory()->create();

        $this->registerChild($pic, $competition, '1111111111111111');

        $payment = app(PaymentService::class)->getOrCreateFor($pic);
        $this->assertSame(10000, $payment->total_amount);
        $this->assertSame(1, $payment->child_count);

        // Tambah anak kedua lalu hitung ulang.
        $this->registerChild($pic, $competition, '2222222222222222');

        $payment = app(PaymentService::class)->getOrCreateFor($pic);
        $this->assertSame(20000, $payment->total_amount);
        $this->assertSame(2, $payment->child_count);
    }
}
