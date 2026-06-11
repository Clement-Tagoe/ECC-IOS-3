<?php

namespace Database\Seeders;

use App\Models\MonitoringTask;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonitoringTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(5),
            'time' => '08:30:00',
            'shift' => 'day',
            'status' => 'reviewed',
            'observation' => 'Heavy traffic building up around the main market square due to unapproved parking.',
            'region_id' => 1,
            'location_id' => 1, // Accra
            'recommendation' => 'Deploy traffic wardens to clear the illegal parking spots immediately.',
        ])->topics()->attach([14, 16]); // Unlawful Car Parking, Traffic
        
        MonitoringTask::create([
            'date' => Carbon::now()->subDays(4),
            'time' => '14:15:00',
            'shift' => 'afternoon',
            'status' => 'in_review',
            'observation' => 'Potholes along the main highway are causing severe slowdowns and structural vehicle damage.',
            'region_id' => 1,
            'location_id' => 2, // Tema
            'recommendation' => 'Notify the urban roads department for immediate patching works.',
        ])->topics()->attach([1]);
        
        MonitoringTask::create([
            'date' => Carbon::now()->subDays(3),
            'time' => '21:00:00',
            'shift' => 'night',
            'status' => 'in_review',
            'observation' => 'Suspicious night gatherings observed near the abandoned warehouse district.',
            'region_id' => 2,
            'location_id' => 3, // Kumasi
            'recommendation' => 'Increase night patrols and improve street lighting in the sector.',
        ])->topics()->attach([5, 13]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(2),
            'time' => '09:45:00',
            'shift' => 'day',
            'status' => 'reviewed',
            'observation' => 'Illegal small-scale mining activities noticed near the river banks.',
            'region_id' => 2,
            'location_id' => 4, // Obuasi
            'recommendation' => 'Coordinate an enforcement task force raid with local authorities.',
        ])->topics()->attach([2]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(1),
            'time' => '11:00:00',
            'shift' => 'day',
            'status' => 'in_review',
            'observation' => 'Accumulation of plastic waste blocking major drainage channels.',
            'region_id' => 3,
            'location_id' => 5, // Takoradi
            'recommendation' => 'Organize an urgent desilting and sanitation cleanup drive.',
        ])->topics()->attach([3, 15]);

        MonitoringTask::create([
            'date' => Carbon::now(),
            'time' => '23:30:00',
            'shift' => 'night',
            'status' => 'in_review',
            'observation' => 'High incidence of commercial sex work activities observed along the street.',
            'region_id' => 3,
            'location_id' => 6, // Tarkwa
            'recommendation' => 'Engage social welfare services and step up community policing.',
        ])->topics()->attach([4]);


        MonitoringTask::create([
            'date' => Carbon::now()->subDays(6),
            'time' => '10:00:00',
            'shift' => 'day',
            'status' => 'reviewed',
            'observation' => 'Political rally and parade held successfully at the ceremonial grounds.',
            'region_id' => 4,
            'location_id' => 7, // Cape Coast
            'recommendation' => 'Maintain crowd control parameters until dispersal is fully finished.',
        ])->topics()->attach([6]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(7),
            'time' => '15:30:00',
            'shift' => 'afternoon',
            'status' => 'reviewed',
            'observation' => 'Overcrowding and unauthorized structures blocking pedestrian walkways.',
            'region_id' => 4,
            'location_id' => 8, // Kasoa
            'recommendation' => 'Conduct a structural audit and relocate illegal roadside vendors.',
        ])->topics()->attach([7, 12]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(2),
            'time' => '12:00:00',
            'shift' => 'afternoon',
            'status' => 'reviewed',
            'observation' => 'Routine inspection conducted at the emergency command center operations deck.',
            'region_id' => 5,
            'location_id' => 9, // Koforidua
            'recommendation' => 'Systems are functioning within normal parameters; no immediate actions.',
        ])->topics()->attach([8]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(8),
            'time' => '07:15:00',
            'shift' => 'day',
            'status' => 'in_review',
            'observation' => 'Traffic lights at the intersection have been dark since yesterday evening.',
            'region_id' => 5,
            'location_id' => 10, // Nkawkaw
            'recommendation' => 'Dispatch an electrical maintenance crew to resolve the power fault.',
        ])->topics()->attach([9, 16]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(9),
            'time' => '13:00:00',
            'shift' => 'afternoon',
            'status' => 'reviewed',
            'observation' => 'Zebra crossings and key regulatory road signs have faded completely.',
            'region_id' => 6,
            'location_id' => 11, // Ho
            'recommendation' => 'Schedule road marking repainting during the next off-peak maintenance window.',
        ])->topics()->attach([10]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(10),
            'time' => '16:45:00',
            'shift' => 'afternoon',
            'status' => 'in_review',
            'observation' => 'Increase in aggressive child begging activities noted at major intersections.',
            'region_id' => 6,
            'location_id' => 12, // Keta
            'recommendation' => 'Partner with Child Welfare departments to investigate and assist.',
        ])->topics()->attach([11]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(2),
            'time' => '11:20:00',
            'shift' => 'day',
            'status' => 'in_review',
            'observation' => 'Hawkers operating actively within active traffic lanes risking lives.',
            'region_id' => 7,
            'location_id' => 13, // Tamale
            'recommendation' => 'Enforce local bylaws barring trade on high-speed motorways.',
        ])->topics()->attach([12]);


        MonitoringTask::create([
            'date' => Carbon::now()->subDays(8),
            'time' => '22:00:00',
            'shift' => 'night',
            'status' => 'reviewed',
            'observation' => 'Unidentified individual loitering suspiciously behind municipal server rooms.',
            'region_id' => 7,
            'location_id' => 14, // Yendi
            'recommendation' => 'Deploy immediate security patrol units to check identity credentials.',
        ])->topics()->attach([13]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(3),
            'time' => '14:00:00',
            'shift' => 'afternoon',
            'status' => 'reviewed',
            'observation' => 'Vehicles parked haphazardly along narrow avenues restricting fire truck access.',
            'region_id' => 8,
            'location_id' => 15, // Bolgatanga
            'recommendation' => 'Issue parking tickets and initiate towing procedures for offenders.',
        ])->topics()->attach([14]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(4),
            'time' => '17:00:00',
            'shift' => 'afternoon',
            'status' => 'in_review',
            'observation' => 'Flash flooding triggered by sudden heavy downpours rendering streets impassable.',
            'region_id' => 8,
            'location_id' => 16, // Navrongo
            'recommendation' => 'Divert inbound traffic to high-ground secondary detour routes.',
        ])->topics()->attach([15, 16]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(5),
            'time' => '08:00:00',
            'shift' => 'day',
            'status' => 'reviewed',
            'observation' => 'Gridlock extending up to three kilometers caused by a broken-down haulage truck.',
            'region_id' => 9,
            'location_id' => 17, // Wa
            'recommendation' => 'Request a heavy-duty recovery tow truck to clear the blockages.',
        ])->topics()->attach([16]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(6),
            'time' => '10:30:00',
            'shift' => 'day',
            'status' => 'in_review',
            'observation' => 'Deep lateral cracks appearing along the freshly asphalted road corridors.',
            'region_id' => 9,
            'location_id' => 18, // Jirapa
            'recommendation' => 'Hold the civil works contractor accountable under the warranty clause.',
        ])->topics()->attach([1]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(1),
            'time' => '12:45:00',
            'shift' => 'afternoon',
            'status' => 'in_review',
            'observation' => 'Illegal open-pit mining operations escalating dangerously near structures.',
            'region_id' => 10,
            'location_id' => 19, // Sunyani
            'recommendation' => 'Engage environmental protection agencies for immediate containment.',
        ])->topics()->attach([2]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(10),
            'time' => '06:00:00',
            'shift' => 'day',
            'status' => 'reviewed',
            'observation' => 'Illegal dumping of industrial chemical refuse into municipal skips.',
            'region_id' => 10,
            'location_id' => 20, // Berekum
            'recommendation' => 'Review CCTV footage to identify the vehicle licensing numbers.',
        ])->topics()->attach([3]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(18),
            'time' => '23:45:00',
            'shift' => 'night',
            'status' => 'reviewed',
            'observation' => 'Brothel activities operating without standard commercial licenses.',
            'region_id' => 11,
            'location_id' => 21, // Techiman
            'recommendation' => 'Seal premises in coordination with municipal licensing boards.',
        ])->topics()->attach([4]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(8),
            'time' => '20:15:00',
            'shift' => 'night',
            'status' => 'in_review',
            'observation' => 'Open-air trade of illegal substances noticed under the overpass.',
            'region_id' => 11,
            'location_id' => 22, // Kintampo
            'recommendation' => 'Set up a permanent police visibility kiosk under the overpass infrastructure.',
        ])->topics()->attach([5]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(8),
            'time' => '09:00:00',
            'shift' => 'day',
            'status' => 'reviewed',
            'observation' => 'Preparations for the regional cultural festival causing minor pedestrian delays.',
            'region_id' => 12,
            'location_id' => 23, // Goaso
            'recommendation' => 'Ensure proper signage for alternative pedestrian walkways.',
        ])->topics()->attach([6]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(2),
            'time' => '13:30:00',
            'shift' => 'afternoon',
            'status' => 'reviewed',
            'observation' => 'Encroachment of market stalls onto the main carriage lanes.',
            'region_id' => 12,
            'location_id' => 24, // Kukuom
            'recommendation' => 'Enforce strict demarcations for market boundaries.',
        ])->topics()->attach([7, 12]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(2),
            'time' => '10:00:00',
            'shift' => 'day',
            'status' => 'in_review',
            'observation' => 'Performance evaluation of emergency response feeds and monitors.',
            'region_id' => 13,
            'location_id' => 25, // Damongo
            'recommendation' => 'Upgrade camera firmwares to improve low light visibility.',
        ])->topics()->attach([8]);

        MonitoringTask::create([
            'date' => Carbon::now()->subDays(5),
            'time' => '18:00:00',
            'shift' => 'afternoon',
            'status' => 'in_review',
            'observation' => 'The main intersection traffic light controller box appears vandalized.',
            'region_id' => 13,
            'location_id' => 26, // Bole
            'recommendation' => 'Replace the control unit components and install tamper locks.',
        ])->topics()->attach([9]);


        MonitoringTask::create([
            'date' => Carbon::now()->subDays(6),
            'time' => '07:45:00',
            'shift' => 'day',
            'status' => 'reviewed',
            'observation' => 'Warning signs near schools have deteriorated due to severe weathering.',
            'region_id' => 14,
            'location_id' => 27, // Nalerigu
            'recommendation' => 'Replace aged retroreflective sheets to guarantee nighttime visibility.',
        ])->topics()->attach([10]);

        MonitoringTask::create([
           'date' => Carbon::now()->subDays(7),
            'time' => '12:15:00',
            'shift' => 'afternoon',
            'status' => 'in_review',
            'observation' => 'Syndicates transporting and placing beggars at strategic points.',
            'region_id' => 14,
            'location_id' => 28, // Walewale
            'recommendation' => 'Initiate investigations into organized exploitation of minors.',
        ])->topics()->attach([11, 13]);

        MonitoringTask::create([
           'date' => Carbon::now()->subDays(1),
            'time' => '15:00:00',
            'shift' => 'afternoon',
            'status' => 'reviewed',
            'observation' => 'Heavy downpours caused river banks to overflow, cutting off minor access roads.',
            'region_id' => 15,
            'location_id' => 29, // Dambai
            'recommendation' => 'Deploy emergency drainage pumps and barricade the flooded sectors.',
        ])->topics()->attach([15]);

        MonitoringTask::create([
           'date' => Carbon::now()->subDays(8),
            'time' => '08:50:00',
            'shift' => 'day',
            'status' => 'reviewed',
            'observation' => 'Severe morning rush hour gridlocks caused by ongoing bridge works.',
            'region_id' => 15,
            'location_id' => 30, // Jasikan
            'recommendation' => 'Coordinate with contractors to run shifts overnight to speed up progress.',
        ])->topics()->attach([16]);
    }
}
