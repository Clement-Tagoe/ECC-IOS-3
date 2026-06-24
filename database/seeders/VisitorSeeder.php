<?php

namespace Database\Seeders;

use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Visitor::create([
            'date'          => Carbon::today(),
            'name'          => 'Kwame Boateng',
            'contact'       => '0244123456',
            'nationality'   => 'Ghanaian',
            'officer_sought' => 'Insp. Samuel Ofori',
            'department_id' => 1,
            'purpose'       => 'Submission of complaint report',
            'sex'           => 'Male',
            'status'        => 'Visitor',
            'card_number'   => '001',
            'time_in'       => '09:15:00',
            'time_out'      => '10:02:00',
            'remarks'       => 'Visitor was calm and cooperative. Complaint form collected and forwarded to the duty officer.',
        ]);

        Visitor::create([
            'date'          => Carbon::today(),
            'name'          => 'Abena Mensah',
            'contact'       => '0507891234',
            'nationality'   => 'Ghanaian',
            'officer_sought' => 'DSP Grace Acheampong',
            'department_id' => 2,
            'purpose'       => 'Follow-up on pending investigation',
            'sex'           => 'Female',
            'status'        => 'Staff',
            'card_number'   => '002',
            'time_in'       => '10:30:00',
            'time_out'      => '11:45:00',
            'remarks'       => 'Visitor met with DSP Acheampong. Case update provided. Visitor to return in two weeks.',
        ]);

        Visitor::create([
            'date'          => Carbon::today(),
            'name'          => 'James Osei Bonsu',
            'contact'       => '0261456789',
            'nationality'   => 'Ghanaian',
            'officer_sought' => 'ACP Michael Darko',
            'department_id' => 1,
            'purpose'       => 'Official meeting — procurement discussion',
            'sex'           => 'Male',
            'status'        => 'Staff',
            'card_number'   => '003',
            'time_in'       => '08:45:00',
            'time_out'      => '09:30:00',
            'remarks'       => 'Pre-scheduled meeting. Visitor escorted to ACP\'s office by duty officer.',
        ]);

        Visitor::create([
            'date'          => Carbon::today(),
            'name'          => 'Fatima Al-Hassan',
            'contact'       => '0203678901',
            'nationality'   => 'Nigerian',
            'officer_sought' => 'Insp. Ama Owusu',
            'department_id' => 3,
            'purpose'       => 'Document verification and collection',
            'sex'           => 'Female',
            'status'        => 'Visitor',
            'card_number'   => '004',
            'time_in'       => '13:00:00',
            'time_out'      => '13:35:00',
            'remarks'       => 'Visitor presented valid passport for identification. Documents verified and handed over.',
        ]);

        Visitor::create([
            'date'          => Carbon::today(),
            'name'          => 'Emmanuel Tetteh',
            'contact'       => '0244987654',
            'nationality'   => 'Ghanaian',
            'officer_sought' => 'Sgt. Kofi Asante',
            'department_id' => 2,
            'purpose'       => 'Bail processing for detained relative',
            'sex'           => 'Male',
            'status'        => 'Visitor',
            'card_number'   => '005',
            'time_in'       => '14:20:00',
            'time_out'      => null,
            'remarks'       => 'Visitor awaiting Sgt. Asante who is currently attending to another matter.',
        ]);


        Visitor::create([
            'date'          => Carbon::now()->subDays(1),
            'name'          => 'Yaw Darko',
            'contact'       => '0551234987',
            'nationality'   => 'Ghanaian',
            'officer_sought' => 'Chief Supt. Esi Quaye',
            'department_id' => null,
            'purpose'       => 'General enquiry regarding lost property',
            'sex'           => 'Male',
            'status'        => 'Visitor',
            'card_number'   => '006',
            'time_in'       => '11:05:00',
            'time_out'      => '11:20:00',
            'remarks'       => 'Visitor directed to the lost and found unit. No card issued as visit was brief.',
        ]);

        Visitor::create([
            'date'          => Carbon::now()->subDays(1),
            'name'          => 'Priscilla Nkrumah',
            'contact'       => '0278456123',
            'nationality'   => 'Ghanaian',
            'officer_sought' => 'DSP Grace Acheampong',
            'department_id' => 2,
            'purpose'       => 'Witness statement recording',
            'sex'           => 'Female',
            'status'        => 'Visitor',
            'card_number'   => '007',
            'time_in'       => '09:50:00',
            'time_out'      => null,
            'remarks'       => 'Visitor currently inside with DSP Acheampong for statement recording. Session ongoing.',
        ]);

    }
}
