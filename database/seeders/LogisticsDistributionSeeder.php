<?php

namespace Database\Seeders;

use App\Models\LogisticsDistribution;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogisticsDistributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LogisticsDistribution::create([
            'logistics_management_id' => 1,
            'department' => 'Head of ECC office',
            'quantity' => 5,
            'date' => Carbon::now(),
        ]);

        LogisticsDistribution::create([
            'logistics_management_id' => 1,
            'department' => 'Deputy Office',
            'quantity' => 3,
            'date' => Carbon::now(),
        ]);

        LogisticsDistribution::create([
            'logistics_management_id' => 1,
            'department' => 'Call Center',
            'quantity' => 2,
            'date' => Carbon::now(),
        ]);

        LogisticsDistribution::create([
            'logistics_management_id' => 2,
            'department' => 'Head of ECC office',
            'quantity' => 3,
            'date' => Carbon::now(),
        ]);

        LogisticsDistribution::create([
            'logistics_management_id' => 3,
            'department' => 'Deputy Office',
            'quantity' => 2,
            'date' => Carbon::now(),
        ]);

        LogisticsDistribution::create([
            'logistics_management_id' => 4,
            'department' => 'Call Center',
            'quantity' => 4,
            'date' => Carbon::now(),
        ]);
    }
}
