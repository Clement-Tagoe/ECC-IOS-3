<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agency::create([
            'name' => 'Ghana Police Service',
            'contact' => '+233 302 773906, +233 302 787373',
            'email' => 'hq.pro@police.gov.gh',
            'location' => 'Ring Road East, Cantonment, Ghana',
            'website' => 'https://police.gov.gh/en'
            ]);
        Agency::create([
            'name' => 'Ghana National Fire Service',
            'contact' => '+233 302 2772446, 0299340383',
            'email' => 'info@gnfs.gov.gh',
            'location' => 'Ring Road East, Cantonment, Ghana',
            'website' => 'https://gnfs.gov.gh/'
            ]);
        Agency::create([
            'name' => 'Ghana Ambulance Service',
            'contact' => '+233 50 5982870',
            'email' => 'info@nas.gov.gh',
            'location' => 'Atta Mills High Street, Opposite Art Center, Accra Central',
            'website' => 'https://nas.gov.gh'
            ]);
        Agency::create([
            'name' => 'NADMO',
            'contact' => '0302 964 882, 0302 964 884',
            'email' => 'info@nadmo.gov.gh',
            'location' => 'Plot 3, Brigade, East Kanda',
            'website' => 'https://nadmo.gov.gh/'
            ]);
        Agency::create([
            'name' => 'NSB/GIFEC',
            'contact' => '999',
            'email' => 'mail.nsbnc.org',
            'location' => 'Digital Address: GA-111-5377',
            'website' => 'nsbnc.org'
            ]);
    }
}
