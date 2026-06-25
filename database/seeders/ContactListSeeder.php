<?php

namespace Database\Seeders;

use App\Models\ContactList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactList::create([
            'name' => 'Lawrence Atizigi',
            'contact' => '0244123457',
            'agency' => 'ECG',
            'location' => 'Tema Comm.11',
            'district' => 'Tema Central',
            'region' => 'Greater Accra Region'
        ]);

        ContactList::create([
            'name' => 'Patricia Lomotey',
            'contact' => '0205123787',
            'agency' => 'Fire Service',
            'location' => 'East Legon',
            'district' => 'Ayawaso West Wuguon',
            'region' => 'Greater Accra Region'
        ]);

        ContactList::create([
            'name' => 'Matthew Addo',
            'contact' => '027321452',
            'agency' => 'Ghana Police',
            'location' => 'Osu',
            'district' => 'Ledzokuku',
            'region' => 'Greater Accra Region'
        ]);
    }
}
