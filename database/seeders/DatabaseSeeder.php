<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            DepartmentSeeder::class,
            RegionSeeder::class,
            LocationSeeder::class,
            UserSeeder::class,
            AgencySeeder::class,
            CallLogSeeder::class,
            ValidCaseNatureSeeder::class,
            ValidCaseSeeder::class,
            CallStaffSeeder::class,
            CallConsoleSeeder::class,
            CameraAuditSeeder::class,
            TopicSeeder::class,
            MonitoringStaffSeeder::class,
            MonitoringConsoleSeeder::class,
            ForensicCaseSeeder::class,
            ForensicReportSeeder::class,
            VisitorSeeder::class,
            SuspectSeeder::class,
            VehicleSeeder::class,
            MonitoringTaskSeeder::class,
            CallShiftReportSeeder::class,
            MonitoringShiftSeeder::class,
            EmergencyContactSeeder::class,
        ]);
    }
}
