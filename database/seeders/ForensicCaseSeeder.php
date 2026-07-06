<?php

namespace Database\Seeders;

use App\Models\ForensicCase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForensicCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ForensicCase::create([
            'user_id' => 1,
            'case_title'   => 'Unauthorised Data Exfiltration — Acme Corporation',
            'reference_id' => 'DFI-2024-001',
            'location'     => 'Accra, Greater Accra Region',
            'status'       =>  'open',
            'review_status' => 'reviewed',
            'description'  => 'A former employee of Acme Corporation was suspected of copying proprietary client data to a personal USB storage device prior to resignation. Forensic examination of the assigned Dell Latitude laptop confirmed that 4.7 GB of confidential files were transferred to an external USB device on 2024-02-28 between 17:42 and 18:05. Browser history further revealed access to a personal cloud storage account immediately following the transfer. The investigation concluded with sufficient evidence to support civil and criminal proceedings against the former employee.',
        ])->receivers()->attach([2, 3]);

        ForensicCase::create([
            'user_id' => 1,
            'case_title'   => 'Business Email Compromise — Zenith Financial Services',
            'reference_id' => 'DFI-2024-002',
            'location'     => 'Kumasi, Ashanti Region',
            'status'       =>  'open',
            'review_status'                => 'reviewed',
            'description'  => 'Zenith Financial Services reported a fraudulent wire transfer of GHS 420,000 following a suspected business email compromise. Investigation revealed that the CFO\'s Microsoft 365 account was accessed by a threat actor from an IP address geolocated in Lagos, Nigeria, after credentials were harvested via a phishing page visited on 2024-05-01. A malicious inbox rule was created to intercept finance-related correspondence and forward it to an external ProtonMail address. A spoofed payment instruction email was subsequently sent to the accounts team, resulting in the fraudulent transfer. The case is currently under review pending cloud account disclosure orders.',
        ])->receivers()->attach([2, 3]);

        ForensicCase::create([
            'user_id' => 1,
            'case_title'   => 'Ransomware Incident — Korle Bu Teaching Hospital',
            'reference_id' => 'DFI-2024-003',
            'location'     => 'Accra, Greater Accra Region',
            'status'       =>  'open',
            'review_status'  => 'in_review',
            'description'  => 'Korle Bu Teaching Hospital experienced a ransomware attack that encrypted critical patient records and administrative systems across 47 networked workstations. Initial entry is believed to have occurred through a phishing email attachment opened by a staff member on the administrative network. Forensic examination is focused on identifying patient zero, mapping lateral movement across the network, recovering encrypted data where possible, and determining whether patient data was exfiltrated prior to encryption. The investigation is ongoing with network traffic logs and endpoint telemetry under active analysis.',
        ])->receivers()->attach([2, 3]);

        ForensicCase::create([
            'user_id' => 1,
            'case_title'   => 'Social Media Fraud & Identity Theft — Victim: M. Asante',
            'reference_id' => 'DFI-2024-004',
            'location'     => 'Takoradi, Western Region',
            'status'       =>  'open',
            'review_status' => 'reviewed',
            'description'  => 'The complainant reported that an unknown individual created fraudulent social media profiles impersonating her and used them to solicit funds from her contacts, resulting in financial losses exceeding GHS 85,000 across multiple victims. Forensic examination of the complainant\'s mobile device and account logs identified the attack vector as a SIM swap executed against her mobile network provider. The suspect\'s device was subsequently seized under warrant; analysis of messaging applications and call logs identified the perpetrator. Evidence was handed to the Ghana Police Service for prosecution. The case was concluded with a formal arrest.',
        ])->receivers()->attach([2, 3]);

        ForensicCase::create([
            'user_id' => 1,
            'case_title'   => 'Insider Threat — Ghana Revenue Authority',
            'reference_id' => 'DFI-2024-005',
            'location'     => 'Accra, Greater Accra Region',
            'status'       =>  'open',
            'review_status' => 'reviewed',
            'description'  => 'The Ghana Revenue Authority initiated an internal investigation following anomalies detected in the tax assessment system, suggesting deliberate manipulation of records by an internal user. Audit log analysis identified a staff account responsible for a series of unauthorised modifications to tax liability records across 312 taxpayer files, reducing assessed amounts without corresponding approvals. The forensic investigation is in the preliminary evidence collection phase. Devices assigned to the suspect have been secured pending a formal examination order from the High Court. No examination of digital evidence has commenced at this stage.',
        ])->receivers()->attach([2, 3]);
;
    }
}
