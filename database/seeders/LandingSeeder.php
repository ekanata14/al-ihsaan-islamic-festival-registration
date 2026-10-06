<?php

namespace Database\Seeders;

use App\Models\ContactPerson;
use App\Models\LandingBlock;
use App\Models\LandingSetting;
use App\Support\LandingBlockTypes;
use Illuminate\Database\Seeder;

class LandingSeeder extends Seeder
{
    /**
     * Isi awal konten landing page. Idempotent: aman dijalankan berulang.
     */
    public function run(): void
    {
        $blocks = [
            [
                'type' => 'hero',
                'name' => 'Hero / Coming Soon',
                'overrides' => [
                    'resources' => [
                        ['label' => 'Guidebook', 'url' => 'https://drive.google.com/file/d/1ajDBWL_DAIumTEOYH-y14BM6e_PAsibM/view?usp=sharing'],
                        ['label' => 'Tutorial Daftar', 'url' => 'https://drive.google.com/drive/folders/1Ct5P53QnEDxNWS4Rj2QNLCIMDIQJY8Mr?usp=drive_link'],
                    ],
                ],
            ],
            [
                'type' => 'info_acara',
                'name' => 'Informasi Acara',
                'overrides' => [],
            ],
            [
                'type' => 'competitions',
                'name' => 'Daftar Lomba',
                'overrides' => [],
            ],
            [
                'type' => 'sponsors',
                'name' => 'Sponsor',
                'overrides' => [],
            ],
            [
                'type' => 'contact',
                'name' => 'Kontak Person',
                'overrides' => [
                    'groups' => [
                        ['label' => 'Grup WA Lomba', 'url' => 'https://chat.whatsapp.com/Hi9IYZYEknYCMpF5mXayuN', 'style' => 'primary'],
                        ['label' => 'Grup WA Khitan', 'url' => 'https://chat.whatsapp.com/By2POmbv4pzGFrgm304VSj', 'style' => 'accent'],
                    ],
                ],
            ],
        ];

        foreach ($blocks as $index => $definition) {
            $content = array_merge(
                LandingBlockTypes::defaultContent($definition['type']),
                $definition['overrides']
            );

            LandingBlock::firstOrCreate(
                ['type' => $definition['type']],
                [
                    'name' => $definition['name'],
                    'content' => $content,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        $contacts = [
            ['name' => 'Fauzan', 'label' => 'Narahubung', 'whatsapp' => '+6281952476416', 'sort_order' => 1],
            ['name' => 'Atha', 'label' => 'Narahubung', 'whatsapp' => '+6287858741020', 'sort_order' => 2],
            ['name' => 'Syawala', 'label' => 'Narahubung', 'whatsapp' => '+6281237495718', 'sort_order' => 3],
        ];

        foreach ($contacts as $contact) {
            ContactPerson::firstOrCreate(
                ['name' => $contact['name']],
                $contact + ['is_active' => true]
            );
        }

        $settings = [
            'site_name' => 'Al Ihsaan Islamic Festival',
            'meta_title' => 'Al Ihsaan Islamic Festival',
            'meta_description' => 'Al Ihsaan Islamic Festival: lomba-lomba Islami, sunatan massal, dan donor darah. Merajut ukhuwah, menggapai berkah.',
            'logo' => 'assets/images/logo_only.png',
            'favicon' => 'assets/images/logo_only.png',
            'primary_color' => '#1D6594',
            'accent_color' => '#E9AA14',
            'event_date' => '2025-06-15 07:00',
            'footer_show' => '1',
            'footer_about' => 'Al Ihsaan Islamic Festival adalah rangkaian kegiatan untuk merajut ukhuwah dan menggapai berkah melalui lomba Islami, sunatan massal, dan donor darah.',
            'footer_address' => 'Masjid Al Ihsaan Sanur, Jl. Hang Tuah, Sanur, Denpasar',
            'footer_email' => '',
            'footer_phone' => '+6282340786912',
            'footer_copyright' => 'Al Ihsaan Islamic Festival. Seluruh hak cipta dilindungi.',
            'navbar_links' => json_encode([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Lomba', 'url' => '#lomba'],
                ['label' => 'Sponsorship', 'url' => '#sponsorship'],
                ['label' => 'Contact Us', 'url' => '#contact-us'],
            ]),
            'footer_quick_links' => json_encode([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Lomba', 'url' => '#lomba'],
                ['label' => 'Sponsorship', 'url' => '#sponsorship'],
                ['label' => 'Hubungi Kami', 'url' => '#contact-us'],
            ]),
            'footer_socials' => json_encode([
                ['label' => 'Instagram', 'url' => ''],
                ['label' => 'WhatsApp', 'url' => 'https://wa.me/+6282340786912'],
            ]),
        ];

        foreach ($settings as $key => $value) {
            LandingSetting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        LandingBlock::flushCache();
        LandingSetting::flushCache();
    }
}
