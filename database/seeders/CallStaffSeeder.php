<?php

namespace Database\Seeders;

use App\Models\CallStaff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CallStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CallStaff::create([
            'name' => 'Martha Stewart',
            'call_staff_group_id' => 1,
        ]);

        CallStaff::create([
            'name' => 'James Mensah',
            'call_staff_group_id' => 1,
        ]);

        CallStaff::create([
            'name' => 'Mercy Tawiah',
            'call_staff_group_id' => 1,
        ]);

        CallStaff::create([
            'name' => 'Joyce Johnson',
            'call_staff_group_id' => 2,
        ]);

        CallStaff::create([
            'name' => 'Richard Tay',
            'call_staff_group_id' => 2,
        ]);

        CallStaff::create([
            'name' => 'Rodney Grey',
            'call_staff_group_id' => 2,
        ]);

        CallStaff::create([
            'name' => 'Ben Addo',
            'call_staff_group_id' => 3,
        ]);

        CallStaff::create([
            'name' => 'Grace Opoku',
            'call_staff_group_id' => 3,
        ]);

        CallStaff::create([
            'name' => 'Daniel Green',
            'call_staff_group_id' => 3,
        ]);

        CallStaff::create([
            'name' => 'Alice Ahinkrah',
            'call_staff_group_id' => 4,
        ]);

        CallStaff::create([
            'name' => 'Reece James',
            'call_staff_group_id' => 4,
        ]);

        CallStaff::create([
            'name' => 'Carl Bagbin',
            'call_staff_group_id' => 4,
        ]);

        CallStaff::create([
            'name' => 'Patience Benson',
            'call_staff_group_id' => 4,
        ]);

        CallStaff::create([
            'name' => 'Kate Henshaw',
            'call_staff_group_id' => 1,
        ]);

        CallStaff::create([
            'name' => 'Mohammed Muniru',
            'call_staff_group_id' => 1,
        ]);

        CallStaff::create([
            'name' => 'Steven Gyamfi',
            'call_staff_group_id' => 2,
        ]);

        CallStaff::create([
            'name' => 'Rejoice Essuman',
            'call_staff_group_id' => 3,
        ]);
    }
}
