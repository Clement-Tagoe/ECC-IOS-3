<?php

namespace Database\Seeders;

use App\Models\ValidCaseNature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValidCaseNatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ValidCaseNature::create(['name' => 'Theft']);
        ValidCaseNature::create(['name' => 'Fire Outbreak']);
        ValidCaseNature::create(['name' => 'Assault']);
        ValidCaseNature::create(['name' => 'Nuisance']);
        ValidCaseNature::create(['name' => 'Dead Bodies/Unconscious']);
        ValidCaseNature::create(['name' => 'Accident & Traffic issue']);
        ValidCaseNature::create(['name' => 'Chaos, Fight, Threat']);
        ValidCaseNature::create(['name' => 'Illegal drugs, Missing persons']);
        ValidCaseNature::create(['name' => 'Market/Shops/School']);
        ValidCaseNature::create(['name' => 'Vehicles']);
        ValidCaseNature::create(['name' => 'Warehouse/office/Hospital']);
        ValidCaseNature::create(['name' => 'Accident']);
        ValidCaseNature::create(['name' => 'ECG Related']);
        ValidCaseNature::create(['name' => 'Patient Transfer']);
        ValidCaseNature::create(['name' => 'Sick Person']);
        ValidCaseNature::create(['name' => 'Dead Body']);
        ValidCaseNature::create(['name' => 'Damaged Vehicle']);
        ValidCaseNature::create(['name' => 'Collapsed building']);
        ValidCaseNature::create(['name' => 'Earth Tremor']);
        ValidCaseNature::create(['name' => 'Pipe Leakage']);
        ValidCaseNature::create(['name' => 'Terrorism']);
    }
}
