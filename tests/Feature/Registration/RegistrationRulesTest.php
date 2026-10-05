<?php

namespace Tests\Feature\Registration;

use App\Models\Child;
use App\Models\Competition;
use App\Models\Group;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\User;
use App\Support\RegistrationRules;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RegistrationRulesTest extends TestCase
{
    use RefreshDatabase;

    private function pic(): User
    {
        return User::factory()->create(['role' => 'user']);
    }

    private function childWithCompetition(User $pic, Competition $competition, string $nik): Child
    {
        $child = Child::firstOrCreate(
            ['pic_id' => $pic->id, 'nik' => $nik],
            [
                'name' => 'Anak',
                'age' => '10',
                'birth_place' => 'Denpasar',
                'birth_date' => '2015-01-01',
            ]
        );

        $registration = Registration::create([
            'registration_number' => 'AIIF-' . uniqid(),
            'pic_id' => $pic->id,
            'competition_id' => $competition->id,
            'group_id' => Group::factory()->create()->id,
            'total_participants' => '1',
            'status' => 'registered',
        ]);

        Participant::create([
            'registration_id' => $registration->id,
            'child_id' => $child->id,
            'name' => 'Anak',
            'age' => '10',
            'birth_place' => 'Denpasar',
            'birth_date' => '2015-01-01',
            'nik' => $nik,
            'photo_url' => 'participants/x.jpg',
            'certificate_url' => 'certificates/x.jpg',
        ]);

        return $child;
    }

    public function test_duplicate_registration_in_same_competition_is_rejected(): void
    {
        $pic = $this->pic();
        $competition = Competition::factory()->create();
        $this->childWithCompetition($pic, $competition, '1111111111111111');

        $this->expectException(ValidationException::class);

        app(RegistrationRules::class)->validate($pic, $competition, [
            ['nik' => '1111111111111111', 'age' => 10],
        ]);
    }

    public function test_more_than_max_competitions_is_rejected(): void
    {
        $pic = $this->pic();
        $a = Competition::factory()->create();
        $b = Competition::factory()->create();
        $c = Competition::factory()->create();

        $this->childWithCompetition($pic, $a, '1111111111111111');
        $this->childWithCompetition($pic, $b, '1111111111111111');

        $this->expectException(ValidationException::class);

        app(RegistrationRules::class)->validate($pic, $c, [
            ['nik' => '1111111111111111', 'age' => 10],
        ]);
    }

    public function test_conflicting_time_slot_is_rejected(): void
    {
        $pic = $this->pic();
        $a = Competition::factory()->timeSlot('Hari 1 - Pagi')->create();
        $b = Competition::factory()->timeSlot('Hari 1 - Pagi')->create();

        $this->childWithCompetition($pic, $a, '1111111111111111');

        $this->expectException(ValidationException::class);

        app(RegistrationRules::class)->validate($pic, $b, [
            ['nik' => '1111111111111111', 'age' => 10],
        ]);
    }

    public function test_age_below_minimum_is_rejected(): void
    {
        $pic = $this->pic();
        $competition = Competition::factory()->ages(10, 15)->create();

        $this->expectException(ValidationException::class);

        app(RegistrationRules::class)->validate($pic, $competition, [
            ['nik' => '9999999999999999', 'age' => 8],
        ]);
    }

    public function test_valid_new_child_passes_all_rules(): void
    {
        $pic = $this->pic();
        $competition = Competition::factory()->ages(5, 15)->create();

        app(RegistrationRules::class)->validate($pic, $competition, [
            ['nik' => '9999999999999999', 'age' => 10],
        ]);

        $this->assertTrue(true);
    }
}
