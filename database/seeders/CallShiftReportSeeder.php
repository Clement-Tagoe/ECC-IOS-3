<?php

namespace Database\Seeders;

use App\Models\CallShiftReport;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CallShiftReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CallShiftReport::create([
            'date' => Carbon::now(),
            'shift_type' => 'morning',
            'start_time' => '06:00:00',
            'end_time' => '13:00:00',
            'status' => 'in_review',
            'notes' => 'There are two unoccupied consoles because 1 console is faulty and 1 person is absent'
        ]);

        CallShiftReport::create([
            'date' => Carbon::now(),
            'shift_type' => 'afternoon',
            'start_time' => '13:00:00',
            'end_time' => '19:00:00',
            'status' => 'reviewed',
            'notes' => ''
        ]);

        CallShiftReport::create([
            'date' => Carbon::now(),
            'shift_type' => 'night',
            'start_time' => '19:00:00',
            'end_time' => '07:00:00',
            'status' => 'in_review',
            'notes' => ''
        ]);

        CallShiftReport::create([
            'date' => Carbon::now()->subDays(1),
            'shift_type' => 'morning',
            'start_time' => '06:00:00',
            'end_time' => '13:00:00',
            'status' => 'in_review',
            'notes' => ''
        ]);

        CallShiftReport::create([
            'date' => Carbon::now()->subDays(1),
            'shift_type' => 'afternoon',
            'start_time' => '13:00:00',
            'end_time' => '19:00:00',
            'status' => 'reviewed',
            'notes' => ''
        ]);
    }
}
