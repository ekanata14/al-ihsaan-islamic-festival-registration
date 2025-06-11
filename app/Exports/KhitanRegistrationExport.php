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
                'pic_id' => $item->pic_id,
                'wali' => $item->pic->name ?? '-',
                'nomor_wali' => $item->pic->phone_number ?? '-',
                'name' => $item->name,
                'age' => $item->age,
                'birth_place' => $item->birth_place,
                'birth_date' => $item->birth_date,
                'nik' => $item->nik,
                'domicile' => $item->domicile,
                'is_sanur' => $item->is_sanur ? 'Yes' : 'No',
                'photo_url' => "https://festival.alihsaan-sanur.org/storage/" . $item->photo_url,
                'certificate_url' => "https://festival.alihsaan-sanur.org/storage/" . $item->certificate_url,
                'family_card_url' => "https://festival.alihsaan-sanur.org/storage/" . $item->familyCard->family_card_url ?? '-',
                'status' => $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Registration Number',
            'PIC ID',
            'Wali',
            'Nomor Wali',
            'Nama Anak',
            'Umur',
            'Tempat Lahir',
            'Tanggal Lahir',
            'NIK',
            'Domisili',
            'Sanur?',
            'Foto Anak',
            'Certificate URL',
            'Kartu Keluarga',
            'Status',
        ];
    }
}
