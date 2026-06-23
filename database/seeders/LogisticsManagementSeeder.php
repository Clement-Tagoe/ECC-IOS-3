<?php

namespace Database\Seeders;

use App\Models\LogisticsManagement;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LogisticsManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LogisticsManagement::create([
            'item' => 'Toilet roll',
            'quantity' => 30,
            'unit' => 'pcs',
            'date' => Carbon::now()
        ]);

        LogisticsManagement::create([
            'item' => 'Pen',
            'quantity' => 20,
            'unit' => 'pcs',
            'date' => Carbon::now()
        ]);

        LogisticsManagement::create([
            'item' => 'Tissue',
            'quantity' => 15,
            'unit' => 'pcs',
            'date' => Carbon::now()
        ]);

        LogisticsManagement::create([
            'item' => 'Air Refreshner',
            'quantity' => 15,
            'unit' => 'pcs',
            'date' => Carbon::now()
        ]);
    }
}
