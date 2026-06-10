<?php

namespace Database\Seeders;

use App\Models\MonitoringTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonitoringTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $observations = [
            'Heavy traffic congestion observed near the main junction during peak hours.',
            'Illegal mining activities spotted close to the river bank.',
            'Refuse piling up at the roadside, no signs of recent collection.',
            'Suspected commercial sex workers loitering around the hotel area.',
            'Group of youth suspected to be involved in substance abuse behind the market.',
            'Large outdoor concert taking place, crowd management needed.',
            'Market congestion causing road blockage on the main street.',
            'ECC cameras at sector 4 appear offline and unresponsive.',
            'Traffic lights at the central roundabout completely non-functional.',
            'Road markings on the highway are severely faded and barely visible.',
            'Several beggars stationed at traffic intersections harassing motorists.',
            'Street hawkers blocking pedestrian walkways along the commercial area.',
            'Unusual gathering of individuals near the abandoned warehouse.',
            'Vehicles parked on double yellow lines blocking emergency access.',
            'Flooding on low-lying road after heavy rainfall, traffic diverted.',
            'Bumper-to-bumper traffic on the ring road stretching over 2km.',
            'Open defecation observed along the railway corridor.',
            'Unregistered vehicles operating as commercial transport near the terminal.',
            'Broken street lights creating blind spots on the highway.',
            'Loud disturbance reported near residential area, source unconfirmed.',
            'Illegal structures being erected on a waterway buffer zone.',
            'Potholes causing accidents on the feeder road to the estate.',
            'Waste dumped indiscriminately near the school premises.',
            'Market encroachment onto the main road reducing lanes to one.',
            'Minors spotted engaging in hawking activities during school hours.',
            'Waterlogging on the main road after overnight rain.',
            'Road signs completely missing on the highway interchange.',
            'Suspicious movement of individuals near the fuel depot at night.',
            'Overcrowding at the lorry station causing safety concerns.',
            'Blocked drainage channels observed contributing to flooding risk.',
        ];

        $recommendations = [
            'Deploy traffic personnel to decongest the area immediately.',
            'Report to environmental protection agency for investigation.',
            'Notify sanitation authority for immediate cleanup exercise.',
            'Increase police visibility and patrol in the area.',
            'Engage community leaders and refer to youth intervention programs.',
            'Coordinate with event organizers to ensure crowd control.',
            'Work with market authorities to enforce trading boundaries.',
            'Dispatch technical team to inspect and restore ECC equipment.',
            'Notify road safety authority to repair traffic light system.',
            'Recommend urgent road marking exercise by highway authority.',
            'Engage social welfare department for rehabilitation of beggars.',
            'Enforce street hawking regulations with support of city guards.',
            'Increase surveillance and notify police for follow-up.',
            'Tow illegally parked vehicles and increase enforcement patrols.',
            'Alert drainage authority and erect road diversion signage.',
            'Investigate root cause and consider alternate route advisories.',
            'Report to WASH authorities and engage community leaders.',
            'Notify transport authority to clamp down on unlicensed operators.',
            'Report to electricity company for urgent street light repairs.',
            'Increase night patrols and notify community watch groups.',
            'Report to town planning authority for enforcement action.',
            'Notify district roads department for pothole patching.',
            'Issue citation to responsible party and arrange cleanup.',
            'Engage market management to enforce trading zone compliance.',
            'Refer to child protection services and notify school authorities.',
            'Clear drainage around the road and monitor water levels.',
            'Report to Ghana Highway Authority for signage replacement.',
            'Increase security presence and notify police intelligence unit.',
            'Engage GPRTU to manage lorry station capacity.',
            'Report to drainage authority for immediate desilting exercise.',
        ];

        $topicGroups = [
            [3],           // Traffic
            [2],           // Galamsey
            [3],           // Sanitation
            [4],           // Prostitution
            [5],           // Drug Related
            [6],           // Special Events
            [7],           // Markets
            [8],           // ECC Monitoring
            [9],           // Non-Functioning Traffic Light
            [10],          // Faded Road Sign
            [11],          // Beggars
            [12],          // Street Hawkers
            [13],          // Unusual Behavior
            [14],          // Unlawful Car Parking
            [15],          // Flood
            [16],          // Traffic
            [3, 15],       // Sanitation + Flood
            [14, 16],      // Unlawful Parking + Traffic
            [9, 10],       // Traffic Light + Road Sign
            [13, 5],       // Unusual Behavior + Drug
            [2, 15],       // Galamsey + Flood
            [1, 16],       // Bad Roads + Traffic
            [3, 7],        // Sanitation + Markets
            [7, 16],       // Markets + Traffic
            [12, 7],       // Street Hawkers + Markets
            [15, 1],       // Flood + Bad Roads
            [10, 1],       // Faded Road Sign + Bad Roads
            [13, 14],      // Unusual Behavior + Unlawful Parking
            [16, 6],       // Traffic + Special Events
            [3, 15, 1],    // Sanitation + Flood + Bad Roads
        ];

        $dates = [
            '2026-06-01', '2026-06-02', '2026-06-03', '2026-06-04', '2026-06-05',
            '2026-06-06', '2026-06-07', '2026-06-08', '2026-06-09', '2026-06-10',
            '2026-06-11', '2026-06-12', '2026-06-13', '2026-06-14', '2026-06-15',
            '2026-06-16', '2026-06-17', '2026-06-18', '2026-06-19', '2026-06-20',
            '2026-06-21', '2026-06-22', '2026-06-23', '2026-06-24', '2026-06-25',
            '2026-06-26', '2026-06-27', '2026-06-28', '2026-06-29', '2026-06-30',
        ];

        $shifts     = ['day', 'night'];
        $statuses   = ['in_review', 'reviewed'];
        $times      = ['06:00:00', '08:30:00', '10:00:00', '14:00:00', '20:00:00', '22:30:00', '00:00:00'];
        $regionIds  = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
        $locationIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];

        for ($i = 0; $i < 30; $i++) {
            $task = MonitoringTask::create([
                'date'           => $dates[$i],
                'time'           => $times[$i % count($times)],
                'shift'          => $shifts[$i % 2],
                'status'         => $statuses[$i % 2 === 0 ? ($i % 3 === 0 ? 0 : 1) : ($i % 3 === 0 ? 1 : 0)],
                'observation'    => $observations[$i],
                'region_id'      => $regionIds[$i % count($regionIds)],
                'location_id'    => $locationIds[$i % count($locationIds)],
                'recommendation' => $recommendations[$i],
            ]);

            $task->topics()->attach($topicGroups[$i]);
        }
    }
}
