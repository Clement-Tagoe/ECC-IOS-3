<?php

namespace Database\Seeders;

use App\Models\CallLog;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CallLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CallLog::create([
            'incoming_calls' => 35000,
            'total_calls_received' => 26000,
            'valid_calls' => 500,
            'prank_calls' => 28000,
            'unanswered_calls' => 3000,
            'status' => 'in_review',
            'shift' => 'Morning',
            'start_time' => '07:00:00',
            'end_time' => '19:00:00',
            'date' => Carbon::now(),
        ]);

        CallLog::create([
            'incoming_calls' => 42000,
            'total_calls_received' => 31500,
            'valid_calls' => 820,
            'prank_calls' => 29800,
            'unanswered_calls' => 4200,
            'status' => 'in_review',
            'shift' => 'Morning',
            'start_time' => '07:00:00',
            'end_time' => '19:00:00',
            'date' => Carbon::now()->subDays(1)
        ]);

        CallLog::create([
            'incoming_calls' => 38000,
            'total_calls_received' => 27400,
            'valid_calls' => 450,
            'prank_calls' => 25500,
            'unanswered_calls' => 4600,
            'status' => 'reviewed',
            'shift' => 'Night',
            'start_time' => '19:00:00',
            'end_time' => '07:00:00',
            'date' => Carbon::now()->subDays(2)
        ]);

        CallLog::create([
            'incoming_calls' => 29500,
            'total_calls_received' => 21800,
            'valid_calls' => 620,
            'prank_calls' => 19800,
            'unanswered_calls' => 1700,
            'status' => 'in_review',
            'shift' => 'Morning',
            'start_time' => '07:00:00',
            'end_time' => '19:00:00',
            'date' => Carbon::now()->subDays(3)
        ]);

        CallLog::create([
            'incoming_calls' => 48500,
            'total_calls_received' => 36200,
            'valid_calls' => 980,
            'prank_calls' => 33500,
            'unanswered_calls' => 6800,
            'status' => 'reviewed',
            'shift' => 'Night',
            'start_time' => '19:00:00',
            'end_time' => '07:00:00',
            'date' => Carbon::now()->subDays(4)
        ]);

        CallLog::create([
            'incoming_calls' => 31000,
            'total_calls_received' => 23500,
            'valid_calls' => 410,
            'prank_calls' => 22000,
            'unanswered_calls' => 2500,
            'status' => 'in_review',
            'shift' => 'Morning',
            'start_time' => '07:00:00',
            'end_time' => '19:00:00',
            'date' => Carbon::now()->subDays(5)
        ]);

        CallLog::create([
            'incoming_calls' => 44500,
            'total_calls_received' => 32800,
            'valid_calls' => 750,
            'prank_calls' => 30500,
            'unanswered_calls' => 5150,
            'status' => 'reviewed',
            'shift' => 'Night',
            'start_time' => '19:00:00',
            'end_time' => '07:00:00',
            'date' => Carbon::now()->subDays(6)
        ]);

        CallLog::create([
            'incoming_calls' => 36500,
            'total_calls_received' => 27100,
            'valid_calls' => 590,
            'prank_calls' => 24800,
            'unanswered_calls' => 3600,
            'status' => 'in_review',
            'shift' => 'Morning',
            'start_time' => '07:00:00',
            'end_time' => '19:00:00',
            'date' => Carbon::now()->subDays(7)
        ]);

        CallLog::create([
            'incoming_calls' => 52000,
            'total_calls_received' => 39500,
            'valid_calls' => 1100,
            'prank_calls' => 36800,
            'unanswered_calls' => 7500,
            'status' => 'reviewed',
            'shift' => 'Night',
            'start_time' => '19:00:00',
            'end_time' => '07:00:00',
            'date' => Carbon::now()->subDays(8)
        ]);

        CallLog::create([
            'incoming_calls' => 33200,
            'total_calls_received' => 24600,
            'valid_calls' => 680,
            'prank_calls' => 22800,
            'unanswered_calls' => 2800,
            'status' => 'in_review',
            'shift' => 'Morning',
            'start_time' => '07:00:00',
            'end_time' => '19:00:00',
            'date' => Carbon::now()->subDays(9)
        ]);

        CallLog::create([
            'incoming_calls' => 40800,
            'total_calls_received' => 30200,
            'valid_calls' => 870,
            'prank_calls' => 27800,
            'unanswered_calls' => 5400,
            'status' => 'reviewed',
            'shift' => 'Night',
            'start_time' => '19:00:00',
            'end_time' => '07:00:00',
            'date' => Carbon::now()->subDays(10)
        ]);
    }
}
