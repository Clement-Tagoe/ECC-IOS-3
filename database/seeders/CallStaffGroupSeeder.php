<?php

namespace Database\Seeders;

use App\Models\CallStaffGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CallStaffGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CallStaffGroup::create([
            'name' => 'Delta'
        ]);

        CallStaffGroup::create([
            'name' => 'Force'
        ]);

        CallStaffGroup::create([
            'name' => 'Tango'
        ]);

        CallStaffGroup::create([
            'name' => 'Bravo'
        ]);
    }
}
