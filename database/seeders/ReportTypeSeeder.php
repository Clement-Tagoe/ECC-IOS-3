<?php

namespace Database\Seeders;

use App\Models\ReportType;
use Illuminate\Database\Seeder;

class ReportTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReportType::create([
            'name' => 'General'
        ]);

        ReportType::create([
            'name' => 'Monitoring'
        ]);

        ReportType::create([
            'name' => 'Incident'
        ]);

        ReportType::create([
            'name' => 'Analysis'
        ]);

        ReportType::create([
            'name' => 'Field'
        ]);

        ReportType::create([
            'name' => 'Evaluation'
        ]);

        ReportType::create([
            'name' => 'Situational'
        ]);

        ReportType::create([
            'name' => 'Briefing'
        ]);
    }
}
