<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::create([
            'name' => 'Fleet Alpha',
            'registration_number' => 'GR-4821-23',
            'vehicle_make' => 'Toyota',
            'model' => 'Land Cruiser',
            'year' => 2021,
            'category' => 'suv',
            'status' => 'active',
            'availability' => 'available',
            'assigned_driver' => 'Kwame Mensah',
            'location' => 'Accra Central Depot',
            'last_service_date' => '2025-03-15',
            'mileage' => 54000,
            'next_service_date' => '2026-06-30',
            'notes' => 'Scheduled for tire rotation next month.',
        ]);

        Vehicle::create([
            'name' => 'Fleet Bravo',
            'registration_number' => 'AS-1147-22',
            'vehicle_make' => 'Ford',
            'model' => 'Ranger',
            'year' => 2020,
            'category' => 'pickup truck',
            'status' => 'active',
            'availability' => 'in-use',
            'assigned_driver' => 'Abena Owusu',
            'location' => 'Kumasi Branch',
            'last_service_date' => '2025-01-20',
            'mileage' => 35000,
            'next_service_date' => '2026-08-30',
            'notes' => 'Used for regional supply runs.',
        ]);

        Vehicle::create([
            'name' => 'Fleet Charlie',
            'registration_number' => 'BA-3305-21',
            'vehicle_make' => 'Hyundai',
            'model' => 'H-1',
            'year' => 2019,
            'category' => 'van',
            'status' => 'maintenance',
            'availability' => 'unavailable',
            'assigned_driver' => null,
            'location' => 'Tamale Service Centre',
            'last_service_date' => '2025-05-02',
            'mileage' => 29050,
            'next_service_date' => '2026-07-15',
            'notes' => 'Engine overhaul in progress. Expected back in 2 weeks.',
        ]);

        Vehicle::create([
            'name' => 'Fleet Delta',
            'registration_number' => 'WR-7760-23',
            'vehicle_make' => 'Isuzu',
            'model' => 'D-Max',
            'year' => 2022,
            'category' => 'pickup truck',
            'status' => 'active',
            'availability' => 'available',
            'assigned_driver' => 'Kofi Asante',
            'location' => 'Takoradi Depot',
            'last_service_date' => '2025-04-10',
            'mileage' => 43900,
            'next_service_date' => '2026-09-03',
        ]);

        Vehicle::create([
            'name' => 'Fleet Echo',
            'registration_number' => 'EP-9934-20',
            'vehicle_make' => 'Mercedes-Benz',
            'model' => 'Sprinter',
            'year' => 2018,
            'category' => 'van',
            'status' => 'retired',
            'availability' => 'unavailable',
            'assigned_driver' => null,
            'location' => 'Accra Central Depot',
            'last_service_date' => '2024-11-30',
            'mileage' => 36000,
            'next_service_date' => '2026-07-14',
            'notes' => 'Decommissioned pending disposal approval.',
        ]);
    }
}
