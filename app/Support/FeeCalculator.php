<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class FeeCalculator
{
    /**
     * Mode hitung aktif: "per_anak" (default) atau "per_lomba".
     */
    public function mode(): string
    {
        $mode = config('festival.fee.mode', 'per_anak');

        return in_array($mode, ['per_anak', 'per_lomba'], true) ? $mode : 'per_anak';
    }

    /**
     * Nominal biaya per unit (Rupiah).
     */
    public function unitAmount(): int
    {
        return (int) config('festival.fee.amount', 10000);
    }

    /**
     * Hitung ringkasan biaya seorang PIC (wali/koordinator).
     *
     * - per_anak : jumlah anak unik (lewat child_id) yang terdaftar oleh PIC.
     * - per_lomba: jumlah baris pendaftaran lomba (registrations) milik PIC.
     *
     * @return array{mode:string,unit_amount:int,child_count:int,lomba_count:int,total:int}
     */
    public function forPic(User $pic): array
    {
        $mode = $this->mode();
        $unit = $this->unitAmount();

        $childCount = DB::table('participants')
            ->join('registrations', 'participants.registration_id', '=', 'registrations.id')
            ->where('registrations.pic_id', $pic->id)
            ->whereNotNull('participants.child_id')
            ->distinct()
            ->count('participants.child_id');

        $lombaCount = DB::table('registrations')
            ->where('pic_id', $pic->id)
            ->count();

        $units = $mode === 'per_lomba' ? $lombaCount : $childCount;

        return [
            'mode' => $mode,
            'unit_amount' => $unit,
            'child_count' => (int) $childCount,
            'lomba_count' => (int) $lombaCount,
            'total' => (int) ($units * $unit),
        ];
    }

    public function totalForPic(User $pic): int
    {
        return $this->forPic($pic)['total'];
    }
}
