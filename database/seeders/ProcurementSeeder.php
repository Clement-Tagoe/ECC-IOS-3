<?php

namespace Database\Seeders;

use App\Models\Procurement;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Procurement::create([
            'date' => Carbon::today(),
            'item' => 'Tiles',
            'quantity' => 15,
            'unit' => 'boxes',
            'priority' => 'medium',
        ]);

         Procurement::create([
            'date' => Carbon::today(),
            'item' => 'Washroom Sink',
            'quantity' => 2,
            'unit' => 'sets',
            'priority' => 'medium',
        ]);
    }
}
