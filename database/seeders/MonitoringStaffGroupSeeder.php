<?php

namespace Database\Seeders;

use App\Models\MonitoringStaffGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonitoringStaffGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MonitoringStaffGroup::create([
            'name' => 'Delta'
        ]);

        MonitoringStaffGroup::create([
            'name' => 'Force'
        ]);

        MonitoringStaffGroup::create([
            'name' => 'Tango'
        ]);

        MonitoringStaffGroup::create([
            'name' => 'Bravo'
        ]);
    }
}
