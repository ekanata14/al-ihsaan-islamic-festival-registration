<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Buat satu tagihan `belum_bayar` untuk setiap PIC yang sudah punya
     * pendaftaran lomba. Idempotent: PIC yang sudah punya tagihan dilewati.
     */
    public function up(): void
    {
        $mode = config('festival.fee.mode', 'per_anak');
        $amount = (int) config('festival.fee.amount', 10000);

        $picIds = DB::table('registrations')->distinct()->pluck('pic_id');

        foreach ($picIds as $picId) {
            if (DB::table('payments')->where('pic_id', $picId)->exists()) {
                continue;
            }

            $lombaCount = DB::table('registrations')->where('pic_id', $picId)->count();
            $childCount = DB::table('children')->where('pic_id', $picId)->count();

            $unitCount = $mode === 'per_lomba' ? $lombaCount : $childCount;
            $total = $unitCount * $amount;

            DB::table('payments')->insert([
                'pic_id' => $picId,
                'invoice_number' => 'INV-AIIF-' . now()->format('dmY') . '-' . strtoupper(Str::random(6)),
                'mode' => $mode,
                'unit_amount' => $amount,
                'child_count' => $childCount,
                'lomba_count' => $lombaCount,
                'total_amount' => $total,
                'status' => 'belum_bayar',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('payments')->delete();
    }
};
