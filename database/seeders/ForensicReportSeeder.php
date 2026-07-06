<?php

namespace Database\Seeders;

use App\Models\ForensicReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForensicReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ForensicReport::create([
                'user_id' => 1,
            // 1. Case Information
                'case_reference_number' => 'DFI-2024-001',
                'investigation_title'   => 'Unauthorized Data Exfiltration — Acme Corp',
                'requesting_agency'     => 'Acme Corporation Legal Department',
                'lead_examiner'         => 'Dr. Samuel Osei',
                'court_jurisdiction'    => 'High Court, Accra — Commercial Division',
                'date_of_examination'   => '2024-03-10',
                'status'                =>  'open',
                'review_status'                => 'reviewed',
 
                // 2. Declaration
                'certification_of_evidence_integrity' => 'I certify that the evidence was acquired using forensically sound methods and has not been altered in any way during the examination process.',
                'confirmation_of_methodologies'       => 'Examination was conducted in accordance with ACPO Good Practice Guide for Digital Evidence and ISO/IEC 27037:2012 guidelines.',
                'examiner_signature'                  => 'Dr. Samuel Osei',
                'signature_date'                      => '2024-03-15',
 
                // 3. Executive Summary
                'purpose_of_investigation' => 'To determine whether a former employee unlawfully copied and transferred proprietary client data to an external storage device prior to resignation.',
                'summary_of_findings'      => 'Forensic examination of the subject laptop confirmed that 4.7 GB of confidential client files were copied to a USB device on 2024-02-28 between 17:42 and 18:05. Browser history showed access to a personal cloud storage account immediately afterward.',
                'summary_of_conclusions'   => 'Evidence strongly supports deliberate and unauthorised exfiltration of proprietary data by the former employee.',
 
                // 4. Scope of Examination
                'devices_examined'        => 'Dell Latitude 5520 laptop (S/N: DL552098XZ) assigned to the subject employee.',
                'evidence_sources'        => 'NTFS file system image, Windows Event Logs, browser history (Chrome), USB device connection logs, and Prefetch files.',
                'investigation_objectives'=> 'Identify any unauthorised data transfer activities; recover artefacts indicating USB usage; reconstruct user activity timeline around the date of resignation.',
 
                // 5. Legal Authority
                'search_warrant_details'      => null,
                'court_order_references'      => null,
                'consent_authorization'       => 'Written consent obtained from Acme Corporation IT Director on 2024-03-08. Reference: ACME-CONSENT-2024-003.',
                'applicable_legal_framework'  => 'Computer Misuse Act (Ghana), Data Protection Act 2012 (Act 843), Employment contract clause 14(b) — Confidentiality.',
 
                // 6. Evidence Received
                'evidence_inventory'        => '1x Dell Latitude 5520 laptop sealed in anti-static evidence bag, evidence tag #EV-001.',
                'condition_of_evidence'     => 'Device received powered off, in good physical condition, with no visible damage. Tamper-evident seal intact.',
                'hash_algorithm'            => 'SHA-256',
                'hash_verification_details' => 'Forensic image hash: A3F1C2D94E7B506891A2C3D4E5F60718293A4B5C6D7E8F9001234567890ABCDEF. Verified post-acquisition hash matches source.',
 
                // 7. Chain of Custody
                'evidence_transfer_records' => 'Evidence received from Acme Corp IT Director (J. Mensah) by Dr. S. Osei on 2024-03-08 at 10:30 AM. Transfer receipt signed by both parties.',
                'storage_records'           => 'Stored in locked evidence locker #L4 at Digital Forensics Lab, Accra. Access restricted to assigned examiner.',
                'custodian_signatures'      => 'J. Mensah (submitting custodian), Dr. S. Osei (receiving examiner).',
 
                // 8. Methodology
                'methodology_identification' => 'Device identified, labelled, and photographed upon receipt. Serial number and asset tag recorded.',
                'methodology_preservation'   => 'Device kept powered off. Stored in static-free environment. No changes made to original media.',
                'methodology_acquisition'    => 'Forensic image acquired using Tableau TX1 write blocker and FTK Imager v4.7. Full disk image (E01 format) created.',
                'methodology_examination'    => 'Image mounted read-only in Autopsy 4.21. File system parsed; deleted files recovered; artefact categories filtered.',
                'methodology_analysis'       => 'USB connection artefacts correlated with file access timestamps. Browser history exported and analysed for cloud upload activity.',
                'methodology_reporting'      => 'Findings documented with supporting screenshots and timeline. Report prepared in accordance with court evidentiary standards.',
 
                // 9. Forensic Environment
                'workstation_specifications'    => 'Dell Precision 7560, Intel Core i9, 64 GB RAM, Windows 11 Pro — forensic workstation, air-gapped.',
                'write_blockers_used'           => 'Tableau TX1 Forensic Imager (firmware v3.2.1).',
                'forensic_tools_and_versions'   => 'FTK Imager v4.7.1, Autopsy v4.21.0, Eric Zimmerman Tools (LECmd v1.5, JLECmd v1.5), Volatility 3.',
 
                // 10. Examination Procedures
                'imaging_procedures'      => 'Full physical disk image acquired via SATA interface through write blocker. Image verified with MD5 and SHA-256 hashes.',
                'verification_methods'    => 'Hash comparison pre- and post-acquisition confirmed image integrity. No discrepancies found.',
                'artifact_analysis'       => 'Prefetch files, LNK files, jump lists, and Windows registry (USBSTOR hive) analysed for USB device history.',
                'timeline_reconstruction' => 'Super timeline created using log2timeline/Plaso; events filtered to 2024-02-25 through 2024-03-01.',
 
                // 11. Findings and Analysis
                'user_activity_analysis'   => 'Subject logged in at 17:38 on 2024-02-28. File Explorer activity shows navigation to client data directories. Last logged off at 18:12.',
                'file_system_analysis'     => '4.7 GB of files from D:\\ClientData\\ copied between 17:42–18:05. $MFT records confirm file access and copy operations.',
                'browser_history'          => 'Google Chrome history shows access to drive.google.com at 18:07 on 2024-02-28. Session lasted 22 minutes with multiple file upload events detected.',
                'email_analysis'           => 'No anomalous email activity identified within the investigation window.',
                'usb_analysis'             => 'USBSTOR registry key shows a SanDisk Ultra 32 GB (S/N: 4C530001231012121342) first connected on 2024-02-28 at 17:41. LNK artefacts confirm file interaction.',
                'mobile_device_analysis'   => null,
 
                // 12. Timeline of Events
                'chronological_reconstruction'     => "17:38 — User login detected.\n17:41 — USB device (SanDisk Ultra 32 GB) connected.\n17:42–18:05 — 4.7 GB of client files copied to USB.\n18:07 — Browser session opened to drive.google.com.\n18:29 — Browser session closed.\n18:12 — User logoff recorded.",
                'correlation_of_evidence_sources'  => 'USB registry artefacts, $MFT timestamps, Prefetch files, LNK files, and browser history all corroborate the same sequence of events.',
 
                // 13. Conclusion
                'investigation_conclusions' => 'The subject deliberately copied 4.7 GB of proprietary client data to a personal USB drive and subsequently uploaded files to a personal cloud storage account on the day prior to resignation.',
                'evidentiary_significance'  => 'The convergence of multiple independent artefact categories provides high confidence in the findings. Evidence is suitable for civil and criminal proceedings.',
 
                // 14. Expert Opinion
                'professional_opinion'                     => 'In my professional opinion, the digital evidence clearly demonstrates intentional and unauthorised data exfiltration by the subject employee.',
                'reasonable_degree_of_forensic_certainty'  => 'I hold these conclusions to a reasonable degree of forensic certainty based on established methodologies and corroborating artefacts.',
 
                // 15. Limitations
                'scope_limitations'         => 'Examination limited to the device provided. Personal devices or cloud storage accounts were not within scope.',
                'potential_data_gaps'       => 'Contents of the USB drive were not available for examination. Cloud upload volume could not be independently verified.',
                'timestamp_considerations'  => 'All timestamps are in GMT+0. Device clock was verified against NTP logs and found to be accurate.',
 
                // 16. Recommendations
                'security_improvements'           => 'Implement endpoint DLP (Data Loss Prevention) solution. Disable USB ports by policy for non-authorised staff.',
                'further_investigative_actions'   => 'Obtain court order to compel disclosure of Google Drive account contents. Examine subject\'s personal devices if legally permissible.',
                'policy_recommendations'          => 'Revise offboarding procedures to include immediate device recovery upon resignation notice. Strengthen data classification and access control policies.',
 
                // 17. Appendices
                'hash_values'          => "Forensic image (EV-001.E01): SHA-256 — A3F1C2D94E7B506891A2C3D4E5F60718293A4B5C6D7E8F9001234567890ABCDEF",
                'screenshots'          => json_encode(['appendices/case001/usb_registry.png', 'appendices/case001/browser_history.png', 'appendices/case001/mft_entries.png']),
                'tool_logs'            => 'FTK Imager acquisition log attached. Autopsy case export log attached.',
                'evidence_photographs' => json_encode(['photos/case001/device_front.jpg', 'photos/case001/evidence_tag.jpg']),
                'glossary_of_terms'    => "MFT — Master File Table: NTFS structure recording metadata for every file on the volume.\nLNK — Shell Link file: Windows shortcut artefact recording recently accessed files.\nPrefetch — Windows artefact recording application execution history.\nUSBSTOR — Windows registry hive recording USB storage device connection history.",
        ])->receivers()->attach([3, 4]);

    ForensicReport::create([
                'user_id' => 1,
        // 1. Case Information
                'case_reference_number' => 'DFI-2024-002',
                'investigation_title'   => 'Business Email Compromise — Zenith Financial Services',
                'requesting_agency'     => 'Ghana Police Service — Cybercrime Unit',
                'lead_examiner'         => 'Insp. Abena Kyei',
                'court_jurisdiction'    => 'District Court, Kumasi',
                'date_of_examination'   => '2024-05-20',
                'status'                =>  'open',
                'review_status'                => 'reviewed',
 
                // 2. Declaration
                'certification_of_evidence_integrity' => 'I certify that all digital evidence was handled and examined in a forensically sound manner, preserving its integrity throughout.',
                'confirmation_of_methodologies'       => 'Examination conducted in accordance with NIST SP 800-86 and Ghana Police Service Digital Evidence Handling Procedures v2.1.',
                'examiner_signature'                  => 'Insp. Abena Kyei',
                'signature_date'                      => '2024-05-28',
 
                // 3. Executive Summary
                'purpose_of_investigation' => 'To investigate a business email compromise incident resulting in an unauthorised wire transfer of GHS 420,000 from Zenith Financial Services.',
                'summary_of_findings'      => 'Email header analysis revealed spoofed sender addresses originating from IP ranges associated with a known threat actor group. Malicious inbox rules were found redirecting CFO correspondence. A fraudulent payment instruction was traced to a compromised email thread.',
                'summary_of_conclusions'   => 'The organisation was targeted by a sophisticated BEC attack. The fraudulent transfer was facilitated by email account compromise and social engineering.',
 
                // 4. Scope of Examination
                'devices_examined'         => 'HP EliteBook 840 G8 (CFO workstation, S/N: HP840GH2031); Microsoft 365 mailbox export for CFO account (cfo@zenithfinancial.gh).',
                'evidence_sources'         => 'Microsoft 365 mailbox export (PST), email headers, Windows Event Logs, Active Directory logs, Azure AD sign-in logs.',
                'investigation_objectives' => 'Identify the attack vector; establish timeline of account compromise; recover fraudulent email communications; identify perpetrator IP addresses.',
 
                // 5. Legal Authority
                'search_warrant_details'     => 'Search Warrant No. KUM-CYB-2024-047 issued by Kumasi District Court on 2024-05-18, authorising examination of company devices and email records.',
                'court_order_references'     => 'Case No. KUM/CR/0412/2024.',
                'consent_authorization'      => 'Corporate consent provided by Zenith Financial Services CEO on 2024-05-17.',
                'applicable_legal_framework' => 'Electronic Transactions Act 2008 (Act 772), Criminal Offences Act (as amended), Cybersecurity Act 2020 (Act 1038).',
 
                // 6. Evidence Received
                'evidence_inventory'        => "1x HP EliteBook 840 G8 laptop (evidence tag #EV-002)\n1x USB drive containing Microsoft 365 PST export (evidence tag #EV-003)",
                'condition_of_evidence'     => 'Laptop received powered off, slight scuff on lid, functionally intact. USB drive in good condition.',
                'hash_algorithm'            => 'SHA-256',
                'hash_verification_details' => "EV-002 image hash: B7D3E4F510A62178934B5C6D7E8F90123456789ABCDEF01234567890ABCDEF12\nEV-003 PST file hash: C9E5F6071B73289A045C6D7E8F90234567890ABCDEF12345678901BCDEF23456",
 
                // 7. Chain of Custody
                'evidence_transfer_records' => 'Evidence seized by Insp. A. Kyei at Zenith Financial premises on 2024-05-18 at 09:15 AM under warrant authority.',
                'storage_records'           => 'Stored in Ghana Police Cybercrime Unit evidence vault, locker #CV-09. Access log maintained.',
                'custodian_signatures'      => 'Insp. A. Kyei (seizing officer), Sgt. K. Asante (evidence custodian).',
 
                // 8. Methodology
                'methodology_identification' => 'Devices photographed, labelled, and asset details recorded at scene prior to seizure.',
                'methodology_preservation'   => 'Laptop powered off immediately. Faraday bag used for transport to prevent remote wipe.',
                'methodology_acquisition'    => 'Disk image acquired with Magnet AXIOM. PST file hashed and copied to forensic workstation.',
                'methodology_examination'    => 'Email headers parsed with MXToolbox and custom Python scripts. Mailbox analysed in Magnet AXIOM and Outlook in read-only mode.',
                'methodology_analysis'       => 'Malicious inbox rules identified. IP addresses geo-located. Email thread reconstruction performed. Azure AD anomalous sign-in logs reviewed.',
                'methodology_reporting'      => 'Findings compiled with supporting email header extracts, IP resolution tables, and timeline. Submitted to Cybercrime Unit and court.',
 
                // 9. Forensic Environment
                'workstation_specifications'  => 'Lenovo ThinkStation P620, AMD Threadripper, 128 GB RAM, Windows 11 Pro — isolated forensic network.',
                'write_blockers_used'         => 'Wiebetech USB WriteBlocker v4.',
                'forensic_tools_and_versions' => 'Magnet AXIOM v7.3, MXToolbox Email Header Analyser, Microsoft Message Header Analyser, Python 3.12 (custom header parsing scripts), Azure AD Audit Log Explorer.',
 
                // 10. Examination Procedures
                'imaging_procedures'      => 'Full disk image acquired via USB 3.0 through write blocker. PST file integrity confirmed via hash comparison.',
                'verification_methods'    => 'Pre- and post-acquisition hashes matched. PST file opened in read-only forensic copy only.',
                'artifact_analysis'       => 'Inbox rules, sent items, deleted items, and email headers extracted and correlated. Azure AD logs filtered for anomalous sign-in events.',
                'timeline_reconstruction' => 'Email timestamps correlated with Azure AD sign-in events to reconstruct attack timeline from initial compromise to fraudulent transfer.',
 
                // 11. Findings and Analysis
                'user_activity_analysis'  => 'Azure AD logs show a successful sign-in from IP 197.255.43.12 (Lagos, Nigeria) on 2024-05-02 at 02:14 AM — outside normal business hours and location.',
                'file_system_analysis'    => 'No significant file system artefacts. Attack was email-centric.',
                'browser_history'         => 'Chrome history shows CFO visited a credential phishing page (hxxps://microsoft-login-secure[.]com) on 2024-05-01 at 16:52.',
                'email_analysis'          => "Malicious inbox rule found: rule name '__' (blank), action: redirect emails from finance@partner.gh to Deleted Items and forward to external address attacker2024@protonmail.com.\nFraudulent payment instruction email sent from spoofed address cfo@zenith-financial.gh (note hyphen) on 2024-05-03.",
                'usb_analysis'            => null,
                'mobile_device_analysis'  => null,
 
                // 12. Timeline of Events
                'chronological_reconstruction'    => "2024-05-01 16:52 — CFO clicks phishing link, credentials harvested.\n2024-05-02 02:14 — Attacker signs into M365 account from Lagos IP.\n2024-05-02 02:17 — Malicious inbox rule created.\n2024-05-03 09:05 — Fraudulent payment email sent to Accounts team.\n2024-05-03 11:30 — Accounts processes GHS 420,000 wire transfer.\n2024-05-03 15:00 — Fraud identified; IT notified; account locked.",
                'correlation_of_evidence_sources' => 'Azure AD logs, inbox rule artefacts, browser history, and email headers independently corroborate the same attack sequence.',
 
                // 13. Conclusion
                'investigation_conclusions' => 'A threat actor compromised the CFO\'s Microsoft 365 account via phishing, installed inbox rules to intercept correspondence, and issued a fraudulent payment instruction resulting in a GHS 420,000 loss.',
                'evidentiary_significance'  => 'Email headers, Azure AD logs, and inbox rule artefacts provide strong admissible evidence for prosecution.',
 
                // 14. Expert Opinion
                'professional_opinion'                    => 'In my professional opinion, this attack bears the hallmarks of an organised BEC operation. The evidence trail is clear and consistent across multiple independent sources.',
                'reasonable_degree_of_forensic_certainty' => 'I hold these conclusions to a reasonable degree of forensic certainty.',
 
                // 15. Limitations
                'scope_limitations'        => 'Examination limited to provided devices and M365 export. Attacker\'s infrastructure and ProtonMail account were outside scope.',
                'potential_data_gaps'      => 'Some email metadata may have been purged from M365 server prior to export due to default retention policies.',
                'timestamp_considerations' => 'Azure AD logs use UTC. All times converted to GMT+0 for this report. Device clock verified as accurate.',
 
                // 16. Recommendations
                'security_improvements'         => 'Enable Multi-Factor Authentication on all M365 accounts immediately. Deploy Microsoft Defender for Office 365. Configure conditional access policies to block sign-ins from high-risk locations.',
                'further_investigative_actions'  => 'Submit mutual legal assistance request for ProtonMail account records. Pursue IP geolocation leads with INTERPOL Cybercrime unit.',
                'policy_recommendations'         => 'Implement dual-authorisation for all wire transfers above GHS 50,000. Conduct mandatory phishing awareness training for finance staff.',
 
                // 17. Appendices
                'hash_values'          => "EV-002 image: SHA-256 — B7D3E4F510A62178934B5C6D7E8F90123456789ABCDEF01234567890ABCDEF12\nEV-003 PST: SHA-256 — C9E5F6071B73289A045C6D7E8F90234567890ABCDEF12345678901BCDEF23456",
                'screenshots'          => json_encode(['appendices/case002/inbox_rule.png', 'appendices/case002/azure_signin.png', 'appendices/case002/phishing_email.png']),
                'tool_logs'            => 'Magnet AXIOM processing log attached. Azure AD export log attached.',
                'evidence_photographs' => json_encode(['photos/case002/laptop_front.jpg', 'photos/case002/evidence_seal.jpg']),
                'glossary_of_terms'    => "BEC — Business Email Compromise: A form of cybercrime targeting organisations that conduct wire transfers.\nPST — Personal Storage Table: Microsoft Outlook email archive format.\nAzure AD — Microsoft's cloud-based identity and access management service.\nMFA — Multi-Factor Authentication: Security mechanism requiring multiple verification steps.",
        ])->receivers()->attach([3, 4]);;

    ForensicReport::create([
                'user_id' => 1,
        // 1. Case Information
                'case_reference_number' => 'DFI-2024-003',
                'investigation_title'   => 'Possession of Prohibited Digital Material — Suspect: J. Doe',
                'requesting_agency'     => 'Ghana Police Service — Criminal Investigations Department',
                'lead_examiner'         => 'Det. Cpl. Kwame Asante',
                'court_jurisdiction'    => 'High Court, Accra — Criminal Division',
                'date_of_examination'   => '2024-07-05',
                'status'                =>  'open',
                'review_status'                => 'in_review',
 
                // 2. Declaration
                'certification_of_evidence_integrity' => 'I certify that evidence was handled strictly in accordance with Ghana Police Service evidence handling protocols and has not been altered.',
                'confirmation_of_methodologies'       => 'All procedures comply with ACPO guidelines, ISO/IEC 27037, and GPS Digital Evidence SOP v3.0.',
                'examiner_signature'                  => 'Det. Cpl. Kwame Asante',
                'signature_date'                      => '2024-07-12',
 
                // 3. Executive Summary
                'purpose_of_investigation' => 'To forensically examine seized digital devices belonging to the suspect for the presence of prohibited digital material pursuant to Search Warrant No. ACC-CID-2024-211.',
                'summary_of_findings'      => 'Examination of the seized smartphone and external hard drive revealed the presence of prohibited files across multiple storage locations, including cloud-synced folders and encrypted containers. File metadata and network logs corroborate possession and distribution activity.',
                'summary_of_conclusions'   => 'Evidence supports charges of possession and distribution of prohibited digital material under applicable Ghanaian law. Examination ongoing.',
 
                // 4. Scope of Examination
                'devices_examined'         => "1x Samsung Galaxy S23 (IMEI: 352041110012345)\n1x Seagate 2TB External HDD (S/N: NA8KPQR1)",
                'evidence_sources'         => 'Physical extraction of mobile device, full disk image of external HDD, cloud sync artefacts, network connection logs.',
                'investigation_objectives' => 'Identify prohibited files; establish possession timeline; identify any distribution activity; recover deleted content.',
 
                // 5. Legal Authority
                'search_warrant_details'     => 'Search Warrant No. ACC-CID-2024-211 issued 2024-07-02 by Accra High Court, authorising seizure and forensic examination of all digital devices at the listed premises.',
                'court_order_references'     => 'Case No. ACC/CR/0887/2024.',
                'consent_authorization'      => null,
                'applicable_legal_framework' => 'Criminal Offences Act 1960 (Act 29) as amended, Children\'s Act 1998 (Act 560), Electronic Transactions Act 2008 (Act 772), Cybersecurity Act 2020 (Act 1038).',
 
                // 6. Evidence Received
                'evidence_inventory'        => "1x Samsung Galaxy S23, black, cracked screen protector (evidence tag #EV-004)\n1x Seagate 2TB External HDD, grey (evidence tag #EV-005)\n1x USB-C charging cable (evidence tag #EV-006)",
                'condition_of_evidence'     => 'Smartphone received powered on — immediately placed in Faraday bag. HDD received disconnected, in good condition. All tamper-evident seals intact.',
                'hash_algorithm'            => 'SHA-256',
                'hash_verification_details' => "EV-004 mobile extraction hash: D1F7A8B92C043E1A056D7E8F90345678901ABCDEF23456789012CDEF34567890\nEV-005 HDD image hash: E3091AC4D1154F2B167E8F90456789012BCDEF34567890123DEF456789012345",
 
                // 7. Chain of Custody
                'evidence_transfer_records' => 'Devices seized by Det. Cpl. K. Asante and WDC A. Brew at suspect\'s residence on 2024-07-02 at 07:45 AM under warrant. Itemised seizure receipt issued.',
                'storage_records'           => 'Stored in GPS-CID Digital Evidence Vault, cabinet #DV-03. Restricted access. Entry log maintained.',
                'custodian_signatures'      => 'Det. Cpl. K. Asante (seizing officer), WDC A. Brew (witness), Sgt. B. Tetteh (vault custodian).',
 
                // 8. Methodology
                'methodology_identification' => 'All devices photographed, IMEI/serial numbers recorded, and labelled at scene prior to seizure.',
                'methodology_preservation'   => 'Mobile device placed in Faraday bag immediately upon seizure to prevent remote access or wipe. HDD stored in anti-static packaging.',
                'methodology_acquisition'    => 'Mobile physical extraction performed using Cellebrite UFED 4PC with device-specific bootloader method. HDD imaged using Tableau TX1 and FTK Imager.',
                'methodology_examination'    => 'Cellebrite Physical Analyser used for mobile artefact parsing. Autopsy used for HDD examination. Encrypted containers identified for further analysis.',
                'methodology_analysis'       => 'File hash comparison against reference databases. Metadata extraction from identified files. Network log analysis for distribution indicators.',
                'methodology_reporting'      => 'Interim findings documented. Full report pending completion of encrypted container analysis. All findings to be submitted to CID and Crown Counsel.',
 
                // 9. Forensic Environment
                'workstation_specifications'  => 'Dell Precision 5820, Intel Xeon W, 64 GB RAM, Windows 10 Pro — air-gapped, GPS-CID forensic lab.',
                'write_blockers_used'         => 'Tableau TX1 (HDD); Cellebrite UFED 4PC handles mobile acquisition internally.',
                'forensic_tools_and_versions' => 'Cellebrite UFED 4PC v7.62, Cellebrite Physical Analyser v7.62, FTK Imager v4.7.1, Autopsy v4.21, Hashkeeper v3.0, VeraCrypt v1.26 (for encrypted container analysis).',
 
                // 10. Examination Procedures
                'imaging_procedures'      => 'Mobile physical extraction via Cellebrite UFED bootloader method — full file system image obtained. HDD full sector image acquired via write blocker.',
                'verification_methods'    => 'Pre- and post-acquisition hashes verified for both devices. Mobile extraction integrity confirmed by Cellebrite extraction report.',
                'artifact_analysis'       => 'File system, deleted file recovery, cloud sync artefacts (Google Photos, Dropbox), messaging app databases, and network connection logs examined.',
                'timeline_reconstruction' => 'File creation/modification timestamps, app usage logs, and network logs combined to reconstruct activity timeline. Super timeline in progress.',
 
                // 11. Findings and Analysis
                'user_activity_analysis'  => 'Device usage logs show frequent access to specific application folders and cloud sync activity. Usage patterns consistent with regular access to stored material.',
                'file_system_analysis'    => 'Prohibited files identified in multiple directory locations on HDD. Deleted file recovery yielded additional items. Encrypted VeraCrypt container identified — pending decryption order.',
                'browser_history'         => 'Mobile browser history shows access to known file-sharing platforms on multiple dates.',
                'email_analysis'          => 'Gmail app database extracted. Relevant correspondence under review.',
                'usb_analysis'            => 'HDD connection history on mobile device indicates regular connection. LNK artefacts on HDD suggest use with a separate Windows PC not yet seized.',
                'mobile_device_analysis'  => 'Full physical extraction successful. Cellebrite Physical Analyser identified files across internal storage, SD card, and application data directories. Messaging app (WhatsApp, Telegram) databases extracted and under analysis.',
 
                // 12. Timeline of Events
                'chronological_reconstruction'    => "2024-01-15 — Earliest file creation timestamp identified on HDD.\n2024-03-08 — Cloud sync activity detected (Google Photos).\n2024-05-22 — Messaging app exchange referencing file transfer detected.\n2024-07-02 07:45 — Devices seized under warrant.\n2024-07-05 — Forensic examination commenced.\n2024-07-12 — Interim findings documented. Examination ongoing.",
                'correlation_of_evidence_sources' => 'File system timestamps, cloud sync logs, and messaging app databases provide converging evidence of possession over an extended period. Distribution indicators under active analysis.',
 
                // 13. Conclusion
                'investigation_conclusions' => 'Examination to date has identified prohibited material across multiple storage locations on both seized devices. Evidence of potential distribution activity identified and under further analysis. Full conclusions pending.',
                'evidentiary_significance'  => 'Findings to date are significant and support the basis for prosecution. Ongoing analysis of encrypted container and messaging databases may yield additional evidence.',
 
                // 14. Expert Opinion
                'professional_opinion'                    => 'Based on findings to date, I am of the professional opinion that the digital evidence recovered supports the allegations. A supplementary opinion will be provided upon completion of the full examination.',
                'reasonable_degree_of_forensic_certainty' => 'Interim conclusions are held to a reasonable degree of forensic certainty. Final opinion reserved pending completion of examination.',
 
                // 15. Limitations
                'scope_limitations'        => 'A VeraCrypt-encrypted container on the HDD has not yet been examined pending a court decryption order. A second Windows PC indicated by LNK artefacts has not yet been seized or examined.',
                'potential_data_gaps'      => 'Cloud storage accounts (Google Photos, Dropbox) were not examined — additional court orders required. Some deleted files were unrecoverable due to overwriting.',
                'timestamp_considerations' => 'Mobile device timestamps were in GMT+0. File system timestamps on HDD suggest a different timezone (UTC+1) — under investigation.',
 
                // 16. Recommendations
                'security_improvements'        => 'N/A — criminal investigation.',
                'further_investigative_actions' => "Obtain court order for VeraCrypt container decryption.\nSeize and examine the second Windows PC indicated by LNK artefacts.\nObtain preservation orders and account data from Google and Dropbox via MLAT.\nAnalyse Telegram and WhatsApp databases fully.",
                'policy_recommendations'       => 'N/A — criminal investigation.',
 
                // 17. Appendices
                'hash_values'          => "EV-004 extraction: SHA-256 — D1F7A8B92C043E1A056D7E8F90345678901ABCDEF23456789012CDEF34567890\nEV-005 image: SHA-256 — E3091AC4D1154F2B167E8F90456789012BCDEF34567890123DEF456789012345",
                'screenshots'          => json_encode(['appendices/case003/cellebrite_report_cover.png', 'appendices/case003/veracrypt_container.png', 'appendices/case003/hdd_directory_tree.png']),
                'tool_logs'            => 'Cellebrite UFED extraction report attached. FTK Imager acquisition log attached. Autopsy case export pending.',
                'evidence_photographs' => json_encode(['photos/case003/samsung_front.jpg', 'photos/case003/hdd_label.jpg', 'photos/case003/faraday_bag_sealed.jpg']),
                'glossary_of_terms'    => "IMEI — International Mobile Equipment Identity: Unique identifier for mobile devices.\nUFED — Universal Forensic Extraction Device: Cellebrite mobile forensic acquisition tool.\nVeraCrypt — Open-source disk encryption software used to create encrypted containers.\nMLAT — Mutual Legal Assistance Treaty: International agreement for cross-border evidence sharing.\nFaraday bag — RF-shielded bag preventing wireless signals from reaching a device.",
            ])->receivers()->attach([3, 4]);;
    }
}
