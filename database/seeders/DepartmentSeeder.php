<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create(['name' => 'Administration']);
        Department::create(['name' => 'IT']);
        Department::create(['name' => 'Call-Center']);
        Department::create(['name' => 'Monitoring']);
        Department::create(['name' => 'Analysis & Intelligence']);
        Department::create(['name' => 'Forensics']);
        Department::create(['name' => 'Estate & Logistics']);
        Department::create(['name' => 'Transport']);
        Department::create(['name' => 'General']);
        Department::create(['name' => 'FrontDesk']);
    }
}
