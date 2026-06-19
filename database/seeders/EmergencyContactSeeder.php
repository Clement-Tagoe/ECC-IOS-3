<?php

namespace Database\Seeders;

use App\Models\EmergencyContact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmergencyContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmergencyContact::create([
            'name' => 'Police',
            'contacts' => '0302 213 214/0302 568 457',
        ]);

        EmergencyContact::create([
            'name' => 'Fire',
            'contacts' => '0302 413 884/0302 568 457',
        ]);

        EmergencyContact::create([
            'name' => 'NADMO',
            'contacts' => '0302 423 884/0303 568 457',
        ]);

        EmergencyContact::create([
            'name' => 'Ambulance',
            'contacts' => '0302 423 884/0303 568 457',
        ]);
    }
}
