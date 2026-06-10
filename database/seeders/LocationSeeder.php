<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create(['name' => 'Accra', 'region_id' => 1]);
        Location::create(['name' => 'Tema', 'region_id' => 1]);

        Location::create(['name' => 'Kumasi', 'region_id' => 2]);
        Location::create(['name' => 'Obuasi', 'region_id' => 2]);

        Location::create(['name' => 'Takoradi', 'region_id' => 3]);
        Location::create(['name' => 'Tarkwa', 'region_id' => 3]);

        Location::create(['name' => 'Cape Coast', 'region_id' => 4]);
        Location::create(['name' => 'Kasoa', 'region_id' => 4]);

        Location::create(['name' => 'Koforidua', 'region_id' => 5]);
        Location::create(['name' => 'Nkawkaw', 'region_id' => 5]);

        Location::create(['name' => 'Ho', 'region_id' => 6]);
        Location::create(['name' => 'Keta', 'region_id' => 6]);

        Location::create(['name' => 'Tamale', 'region_id' => 7]);
        Location::create(['name' => 'Yendi', 'region_id' => 7]);

        Location::create(['name' => 'Bolgatanga', 'region_id' => 8]);
        Location::create(['name' => 'Navrongo', 'region_id' => 8]);

        Location::create(['name' => 'Wa', 'region_id' => 9]);
        Location::create(['name' => 'Jirapa', 'region_id' => 9]);

        Location::create(['name' => 'Sunyani', 'region_id' => 10]);
        Location::create(['name' => 'Berekum', 'region_id' => 10]);

        Location::create(['name' => 'Techiman', 'region_id' => 11]);
        Location::create(['name' => 'Kintampo', 'region_id' => 11]);

        Location::create(['name' => 'Goaso', 'region_id' => 12]);
        Location::create(['name' => 'Kukuom', 'region_id' => 12]);

        Location::create(['name' => 'Damongo', 'region_id' => 13]);
        Location::create(['name' => 'Bole', 'region_id' => 13]);

        Location::create(['name' => 'Nalerigu', 'region_id' => 14]);
        Location::create(['name' => 'Walewale', 'region_id' => 14]);

        Location::create(['name' => 'Dambai', 'region_id' => 15]);
        Location::create(['name' => 'Jasikan', 'region_id' => 15]);

        Location::create(['name' => 'Sefwi Wiawso', 'region_id' => 16]);
        Location::create(['name' => 'Bibiani', 'region_id' => 16]);
    }
}
