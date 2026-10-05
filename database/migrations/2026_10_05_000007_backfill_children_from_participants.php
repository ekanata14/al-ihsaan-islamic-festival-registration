<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Backfill tabel `children` dari data `participants` lama dan tautkan
     * kolom `participants.child_id`. Idempotent: aman dijalankan berulang.
     */
    public function up(): void
    {
        DB::table('participants')
            ->join('registrations', 'participants.registration_id', '=', 'registrations.id')
            ->select(
                'participants.id as participant_id',
                'participants.name',
                'participants.age',
                'participants.birth_place',
                'participants.birth_date',
                'participants.nik',
                'registrations.pic_id'
            )
            ->orderBy('participants.id')
            ->chunk(500, function ($rows) {
                /** @var array<string, int> $cache */
                $cache = [];

                foreach ($rows as $row) {
                    // Lewati bila sudah tertaut (idempotent).
                    $childId = DB::table('participants')
                        ->where('id', $row->participant_id)
                        ->value('child_id');

                    if ($childId) {
                        continue;
                    }

                    $key = $row->pic_id . '|' . $row->nik;

                    if (! isset($cache[$key])) {
                        $existing = DB::table('children')
                            ->where('pic_id', $row->pic_id)
                            ->where('nik', $row->nik)
                            ->value('id');

                        if ($existing) {
                            $cache[$key] = $existing;
                        } else {
                            $cache[$key] = DB::table('children')->insertGetId([
                                'pic_id' => $row->pic_id,
                                'name' => $row->name,
                                'age' => $row->age,
                                'birth_place' => $row->birth_place,
                                'birth_date' => $row->birth_date,
                                'nik' => $row->nik,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }

                    DB::table('participants')
                        ->where('id', $row->participant_id)
                        ->update(['child_id' => $cache[$key]]);
                }
            });
    }

    public function down(): void
    {
        DB::table('participants')->update(['child_id' => null]);
        DB::table('children')->delete();
    }
};
