<?php

namespace App\Exports;

use App\Models\KhitanRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KhitanRegistrationExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return KhitanRegistration::with('pic')->get()->map(function ($item) {
            return [
                'registration_number' => $item->registration_number,
                'wali' => $item->pic->name ?? '-',
                'nomor_wali' => $item->pic->phone_number ?? '-',
                'nama_anak' => $item->name,
                'domisili' => $item->domicile,
                'is_sanur' => $item->is_sanur ? 'Yes' : 'No',
                'status' => $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Registration Number',
            'Wali',
            'Nomor Wali',
            'Nama Anak',
            'Domisili',
            'Sanur?',
            'Status',
        ];
    }
}
