<?php

namespace App\Exports;

use App\Models\Child;
use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VerifiedParticipantsExport implements FromCollection, WithHeadings
{
    /**
     * Daftar anak yang pembayarannya sudah terverifikasi.
     */
    public function collection()
    {
        return Child::query()
            ->with(['participants.registration.competition.category', 'pic.group'])
            ->whereHas('pic.payment', function ($q) {
                $q->where('status', Payment::STATUS_TERVERIFIKASI);
            })
            ->whereHas('participants')
            ->get()
            ->map(function (Child $child) {
                $lomba = $child->participants
                    ->map(fn ($participant) => $participant->registration?->competition?->name)
                    ->filter()
                    ->unique()
                    ->implode(', ');

                return [
                    'nama_anak' => $child->name,
                    'nik' => $child->nik,
                    'lomba' => $lomba,
                    'tpg_asal' => $child->pic?->group?->name ?? '-',
                    'wali_pic' => $child->pic?->name ?? '-',
                    'status_bayar' => 'LUNAS',
                    'kupon_makan' => (int) config('festival.coupon_per_child', 1),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Anak',
            'NIK',
            'Lomba',
            'TPG / Asal',
            'Wali / PIC',
            'Status Bayar',
            'Jumlah Kupon Makan',
        ];
    }
}
