<?php

namespace Database\Seeders;

use App\Models\MonitoringStaff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonitoringStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MonitoringStaff::create([
            'name' => 'Catherine Mensah',
            'monitoring_staff_group_id' => 1,
        ]);

        MonitoringStaff::create([
            'name' => 'Fiifi Adoboli',
            'monitoring_staff_group_id' => 1,
        ]);

        MonitoringStaff::create([
            'name' => 'Theo Mendes',
            'monitoring_staff_group_id' => 1,
        ]);

        MonitoringStaff::create([
            'name' => 'Jennifer Lomotey',
            'monitoring_staff_group_id' => 1,
        ]);

        MonitoringStaff::create([
            'name' => 'Ricky Kabutey',
            'monitoring_staff_group_id' => 2,
        ]);

        MonitoringStaff::create([
            'name' => 'Eva Loco',
            'monitoring_staff_group_id' => 2,
        ]);

        MonitoringStaff::create([
            'name' => 'Michael Johnson',
            'monitoring_staff_group_id' => 2,
        ]);

        MonitoringStaff::create([
            'name' => 'Anita Twum',
            'monitoring_staff_group_id' => 2,
        ]);

        MonitoringStaff::create([
            'name' => 'Ricardo Tayson',
            'monitoring_staff_group_id' => 3,
        ]);

        MonitoringStaff::create([
            'name' => 'Lydia Hennessey',
            'monitoring_staff_group_id' => 3,
        ]);

        MonitoringStaff::create([
            'name' => 'Roy Chambers',
            'monitoring_staff_group_id' => 3,
        ]);

        MonitoringStaff::create([
            'name' => 'Lisa Koranteng',
            'monitoring_staff_group_id' => 3,
        ]);

        MonitoringStaff::create([
            'name' => 'John Adjei',
            'monitoring_staff_group_id' => 4,
        ]);

        MonitoringStaff::create([
            'name' => 'Monica Tetteh',
            'monitoring_staff_group_id' => 4,
        ]);

        MonitoringStaff::create([
            'name' => 'Hisham Olando',
            'monitoring_staff_group_id' => 4,
        ]);

        MonitoringStaff::create([
            'name' => 'Rudolf Benson',
            'monitoring_staff_group_id' => 4,
        ]);

        MonitoringStaff::create([
            'name' => 'Rose Grey',
            'monitoring_staff_group_id' => 4,
        ]);
    }
}
