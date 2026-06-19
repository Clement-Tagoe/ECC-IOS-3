<?php

namespace Database\Seeders;

use App\Models\MonitoringShiftReport;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonitoringShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       MonitoringShiftReport::create([
            'date' => Carbon::now(),
            'shift_type' => 'morning',
            'start_time' => '06:00:00',
            'end_time' => '13:00:00',
            'status' => 'reviewed',
            'expected_attendance' => 15,
            'present' => 13,
            'absent' => 2,
            'absent_with_permission' => 1,
            'occupied_consoles' => 13,
            'unoccupied_consoles' => 2,
            'notes' => 'There are two unoccupied consoles because 1 console is faulty and 1 person is absent'
        ]);

        MonitoringShiftReport::create([
            'date' => Carbon::now(),
            'shift_type' => 'afternoon',
            'start_time' => '13:00:00',
            'end_time' => '19:00:00',
            'status' => 'in_review',
            'expected_attendance' => 14,
            'present' => 13,
            'absent' => 0,
            'absent_with_permission' => 0,
            'occupied_consoles' => 13,
            'unoccupied_consoles' => 1,
            'notes' => ''
        ]);

        MonitoringShiftReport::create([
            'date' => Carbon::now(),
            'shift_type' => 'night',
            'start_time' => '19:00:00',
            'end_time' => '07:00:00',
            'status' => 'in_review',
            'expected_attendance' => 8,
            'present' => 7,
            'absent' => 1,
            'absent_with_permission' => 1,
            'occupied_consoles' => 8,
            'unoccupied_consoles' => 1,
            'notes' => ''
        ]);

        MonitoringShiftReport::create([
            'date' => Carbon::now()->subDays(1),
            'shift_type' => 'morning',
             'start_time' => '06:00:00',
            'end_time' => '13:00:00',
            'status' => 'in_review',
            'expected_attendance' => 15,
            'present' => 13,
            'absent' => 2,
            'absent_with_permission' => 2,
            'occupied_consoles' => 13,
            'unoccupied_consoles' => 2,
            'notes' => ''
        ]);

        MonitoringShiftReport::create([
            'date' => Carbon::now()->subDays(1),
            'shift_type' => 'afternoon',
            'start_time' => '13:00:00',
            'end_time' => '19:00:00',
            'status' => 'reviewed',
            'expected_attendance' => 15,
            'present' => 13,
            'absent' => 2,
            'absent_with_permission' => 2,
            'occupied_consoles' => 13,
            'unoccupied_consoles' => 2,
            'notes' => ''
        ]);
    }
}
