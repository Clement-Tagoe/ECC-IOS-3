<?php

namespace Database\Seeders;

use App\Models\CameraLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CameraLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CameraLocation::create([
            'name' => 'Junction'
        ]);

        CameraLocation::create([
            'name' => 'Tower Surveillance'
        ]);

        CameraLocation::create([
            'name' => 'Border'
        ]);


        CameraLocation::create([
            'name' => 'Court'
        ]);

        CameraLocation::create([
            'name' => 'Sub Station'
        ]);

        CameraLocation::create([
            'name' => 'Public Area'
        ]);

        CameraLocation::create([
            'name' => 'Airport/Terminal 2/Indoor'
        ]);

        CameraLocation::create([
            'name' => 'Airport/Terminal 1/Outdoor'
        ]);

        CameraLocation::create([
            'name' => 'Airport/Terminal 1'
        ]);

        CameraLocation::create([
            'name' => 'Airport/Terminal 2'
        ]);

        CameraLocation::create([
            'name' => 'Airport/Airside'
        ]);

        CameraLocation::create([
            'name' => 'AICC'
        ]);

        CameraLocation::create([
            'name' => 'GAEC'
        ]);

        CameraLocation::create([
            'name' => 'GAF CEMETARY'
        ]);

        CameraLocation::create([
            'name' => 'Golden Jubilee Terminal'
        ]);

        CameraLocation::create([
            'name' => 'Parliament House'
        ]);

        CameraLocation::create([
            'name' => 'Hospital'
        ]);

        CameraLocation::create([
            'name' => 'Panoramic'
        ]);

        CameraLocation::create([
            'name' => 'Public Areas'
        ]);

        CameraLocation::create([
            'name' => 'Stadium'
        ]);

        CameraLocation::create([
            'name' => 'UG Legon'
        ]);
    }
}
