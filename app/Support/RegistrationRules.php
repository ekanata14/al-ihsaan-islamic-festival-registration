<?php

namespace App\Support;

use App\Models\Child;
use App\Models\Competition;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class RegistrationRules
{
    public function maxPerChild(): int
    {
        return (int) config('festival.max_competitions_per_child', 2);
    }

    /**
     * Cari atau buat identitas anak milik PIC berdasarkan NIK.
     */
    public function resolveChild(User $pic, array $data): Child
    {
        return Child::firstOrCreate(
            ['pic_id' => $pic->id, 'nik' => $data['nik']],
            [
                'name' => $data['name'] ?? '',
                'age' => (string) ($data['age'] ?? ''),
                'birth_place' => $data['birth_place'] ?? '',
                'birth_date' => $data['birth_date'] ?? '',
            ]
        );
    }

    /**
     * Validasi aturan bisnis pendaftaran lomba untuk sekumpulan peserta.
     *
     * @param  array<int,array{nik:string,age:int|string,mixed}>  $participants
     *
     * @throws ValidationException
     */
    public function validate(User $pic, Competition $competition, array $participants): void
    {
        $max = $this->maxPerChild();

        // Cegah NIK ganda dalam satu kiriman.
        $duplicates = collect($participants)->pluck('nik')->filter()->duplicates();

        if ($duplicates->isNotEmpty()) {
            throw ValidationException::withMessages([
                'participants' => 'Terdapat NIK ganda dalam satu pendaftaran: ' . $duplicates->implode(', ') . '.',
            ]);
        }

        foreach ($participants as $index => $p) {
            $nik = (string) ($p['nik'] ?? '');
            $child = Child::where('pic_id', $pic->id)->where('nik', $nik)->first();

            if ($child) {
                // Cegah pendaftaran ganda pada lomba yang sama.
                $alreadyInCompetition = Participant::where('child_id', $child->id)
                    ->whereHas('registration', function ($q) use ($competition) {
                        $q->where('competition_id', $competition->id);
                    })
                    ->exists();

                if ($alreadyInCompetition) {
                    throw ValidationException::withMessages([
                        "participants.{$index}.nik" => "Peserta dengan NIK {$nik} sudah terdaftar pada lomba {$competition->name}.",
                    ]);
                }

                $registeredCompetitionIds = Participant::where('child_id', $child->id)
                    ->join('registrations', 'participants.registration_id', '=', 'registrations.id')
                    ->distinct()
                    ->pluck('registrations.competition_id');

                // Batas maksimal lomba per anak.
                if ($registeredCompetitionIds->count() >= $max) {
                    throw ValidationException::withMessages([
                        "participants.{$index}.nik" => "Peserta dengan NIK {$nik} sudah mengikuti {$max} lomba (maksimal {$max} lomba per anak).",
                    ]);
                }

                // Cegah bentrok jadwal (slot waktu yang sama).
                if ($competition->time_slot) {
                    $conflict = Competition::whereIn('id', $registeredCompetitionIds)
                        ->where('time_slot', $competition->time_slot)
                        ->first();

                    if ($conflict) {
                        throw ValidationException::withMessages([
                            "participants.{$index}.nik" => "Peserta dengan NIK {$nik} terdaftar di lomba {$conflict->name} pada jadwal yang sama ({$competition->time_slot}).",
                        ]);
                    }
                }
            }

            // Batas umur lomba.
            $age = (int) ($p['age'] ?? 0);

            if ($competition->min_age !== null && $age < (int) $competition->min_age) {
                throw ValidationException::withMessages([
                    "participants.{$index}.age" => "Umur peserta minimal {$competition->min_age} tahun untuk lomba {$competition->name}.",
                ]);
            }

            if ($competition->max_age !== null && $age > (int) $competition->max_age) {
                throw ValidationException::withMessages([
                    "participants.{$index}.age" => "Umur peserta maksimal {$competition->max_age} tahun untuk lomba {$competition->name}.",
                ]);
            }
        }
    }
}
