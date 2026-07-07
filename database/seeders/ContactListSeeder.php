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
            'agency_id' => 1,
            'location_id' => 1,
            'region_id' => 1
        ]);

        ContactList::create([
            'name' => 'Patricia Lomotey',
            'contact' => '0205123787',
            'agency_id' => 2,
            'location_id' => 1,
            'region_id' => 1
        ]);

        ContactList::create([
            'name' => 'Matthew Addo',
            'contact' => '027321452',
            'agency_id' => 3,
            'location_id' => 1,
            'region_id' => 1
        ]);
    }
}
