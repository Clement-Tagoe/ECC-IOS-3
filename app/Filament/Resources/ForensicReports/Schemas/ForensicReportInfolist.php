<?php

namespace App\Filament\Resources\ForensicReports\Schemas;

use App\Models\ForensicReport;
use Filament\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Kirschbaum\Commentions\Filament\Infolists\Components\CommentsEntry;


class ForensicReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('1. Case Information')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('case_reference_number')
                            ->label('Case Reference Number'),
                        TextEntry::make('investigation_title')
                            ->label('Investigation Title'),
                        TextEntry::make('requesting_agency')
                            ->label('Requesting Agency / Organisation'),
                        TextEntry::make('lead_examiner')
                            ->label('Lead Examiner'),
                        TextEntry::make('court_jurisdiction')
                            ->label('Court / Jurisdiction')
                            ->placeholder('N/A'),
                        TextEntry::make('date_of_examination')
                            ->label('Date of Examination')
                            ->date(),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge(),
                        TextEntry::make('review_status')
                            ->label('Review Status')
                            ->badge(),
                        TextEntry::make('user.name')
                            ->label('Sent By'),
                        TextEntry::make('collaborators.name')
                            ->label('Collaborators')
                            ->listWithLineBreaks()
                            ->placeholder('No collaborators'),
                        TextEntry::make('receivers.name')
                            ->label('Sent To (Receivers)')
                            ->listWithLineBreaks(),
                    ]),
 
                // ── 2. Declaration ───────────────────────────────────────────
                Section::make('2. Declaration')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('certification_of_evidence_integrity')
                            ->label('Certification of Evidence Integrity')
                            ->columnSpanFull(),
                        TextEntry::make('confirmation_of_methodologies')
                            ->label('Confirmation of Accepted Forensic Methodologies')
                            ->columnSpanFull(),
                        TextEntry::make('examiner_signature')
                            ->label('Examiner Signature'),
                        TextEntry::make('signature_date')
                            ->label('Signature Date')
                            ->date(),
                    ]),
 
                // ── 3. Executive Summary ─────────────────────────────────────
                Section::make('3. Executive Summary')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('purpose_of_investigation')
                            ->label('Purpose of Investigation')
                            ->columnSpanFull(),
                        TextEntry::make('summary_of_findings')
                            ->label('Summary of Findings')
                            ->columnSpanFull(),
                        TextEntry::make('summary_of_conclusions')
                            ->label('Summary of Conclusions')
                            ->columnSpanFull(),
                    ]),
 
                // ── 4. Scope of Examination ──────────────────────────────────
                Section::make('4. Scope of Examination')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('devices_examined')
                            ->label('Devices Examined')
                            ->columnSpanFull(),
                        TextEntry::make('evidence_sources')
                            ->label('Evidence Sources')
                            ->columnSpanFull(),
                        TextEntry::make('investigation_objectives')
                            ->label('Investigation Objectives')
                            ->columnSpanFull(),
                    ]),
 
                // ── 5. Legal Authority ───────────────────────────────────────
                Section::make('5. Legal Authority')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('search_warrant_details')
                            ->label('Search Warrant Details')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('court_order_references')
                            ->label('Court Order References')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('consent_authorization')
                            ->label('Consent Authorization')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('applicable_legal_framework')
                            ->label('Applicable Legal Framework')
                            ->columnSpanFull(),
                    ]),
 
                // ── 6. Evidence Received ─────────────────────────────────────
                Section::make('6. Evidence Received')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('evidence_inventory')
                            ->label('Evidence Inventory')
                            ->columnSpanFull(),
                        TextEntry::make('condition_of_evidence')
                            ->label('Condition of Evidence')
                            ->columnSpanFull(),
                        TextEntry::make('hash_algorithm')
                            ->label('Hash Algorithm'),
                        TextEntry::make('hash_verification_details')
                            ->label('Hash Verification Details')
                            ->columnSpanFull(),
                    ]),
 
                // ── 7. Chain of Custody ──────────────────────────────────────
                Section::make('7. Chain of Custody')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('evidence_transfer_records')
                            ->label('Evidence Transfer Records')
                            ->columnSpanFull(),
                        TextEntry::make('storage_records')
                            ->label('Storage Records')
                            ->columnSpanFull(),
                        TextEntry::make('custodian_signatures')
                            ->label('Custodian Signatures')
                            ->columnSpanFull(),
                    ]),
 
                // ── 8. Methodology ───────────────────────────────────────────
                Section::make('8. Methodology')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('methodology_identification')
                            ->label('Identification')
                            ->columnSpanFull(),
                        TextEntry::make('methodology_preservation')
                            ->label('Preservation')
                            ->columnSpanFull(),
                        TextEntry::make('methodology_acquisition')
                            ->label('Acquisition')
                            ->columnSpanFull(),
                        TextEntry::make('methodology_examination')
                            ->label('Examination')
                            ->columnSpanFull(),
                        TextEntry::make('methodology_analysis')
                            ->label('Analysis')
                            ->columnSpanFull(),
                        TextEntry::make('methodology_reporting')
                            ->label('Reporting')
                            ->columnSpanFull(),
                    ]),
 
                // ── 9. Forensic Environment ──────────────────────────────────
                Section::make('9. Forensic Environment')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('workstation_specifications')
                            ->label('Workstation Specifications')
                            ->columnSpanFull(),
                        TextEntry::make('write_blockers_used')
                            ->label('Write Blockers Used')
                            ->columnSpanFull(),
                        TextEntry::make('forensic_tools_and_versions')
                            ->label('Forensic Tools and Versions')
                            ->columnSpanFull(),
                    ]),
 
                // ── 10. Examination Procedures ───────────────────────────────
                Section::make('10. Examination Procedures')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('imaging_procedures')
                            ->label('Imaging Procedures')
                            ->columnSpanFull(),
                        TextEntry::make('verification_methods')
                            ->label('Verification Methods')
                            ->columnSpanFull(),
                        TextEntry::make('artifact_analysis')
                            ->label('Artifact Analysis')
                            ->columnSpanFull(),
                        TextEntry::make('timeline_reconstruction')
                            ->label('Timeline Reconstruction')
                            ->columnSpanFull(),
                    ]),
 
                // ── 11. Findings and Analysis ────────────────────────────────
                Section::make('11. Findings and Analysis')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('user_activity_analysis')
                            ->label('User Activity Analysis')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('file_system_analysis')
                            ->label('File System Analysis')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('browser_history')
                            ->label('Browser History')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('email_analysis')
                            ->label('Email Analysis')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('usb_analysis')
                            ->label('USB Analysis')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('mobile_device_analysis')
                            ->label('Mobile Device Analysis')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                    ]),
 
                // ── 12. Timeline of Events ───────────────────────────────────
                Section::make('12. Timeline of Events')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('chronological_reconstruction')
                            ->label('Chronological Reconstruction of Activities')
                            ->columnSpanFull(),
                        TextEntry::make('correlation_of_evidence_sources')
                            ->label('Correlation of Evidence Sources')
                            ->columnSpanFull(),
                    ]),
 
                // ── 13. Conclusion ───────────────────────────────────────────
                Section::make('13. Conclusion')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('investigation_conclusions')
                            ->label('Investigation Conclusions')
                            ->columnSpanFull(),
                        TextEntry::make('evidentiary_significance')
                            ->label('Evidentiary Significance')
                            ->columnSpanFull(),
                    ]),
 
                // ── 14. Expert Opinion ───────────────────────────────────────
                Section::make('14. Expert Opinion')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('professional_opinion')
                            ->label('Professional Opinion')
                            ->columnSpanFull(),
                        TextEntry::make('reasonable_degree_of_forensic_certainty')
                            ->label('Reasonable Degree of Forensic Certainty')
                            ->columnSpanFull(),
                    ]),
 
                // ── 15. Limitations ──────────────────────────────────────────
                Section::make('15. Limitations')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('scope_limitations')
                            ->label('Scope Limitations')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('potential_data_gaps')
                            ->label('Potential Data Gaps')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('timestamp_considerations')
                            ->label('Timestamp Considerations')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                    ]),
 
                // ── 16. Recommendations ──────────────────────────────────────
                Section::make('16. Recommendations')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('security_improvements')
                            ->label('Security Improvements')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('further_investigative_actions')
                            ->label('Further Investigative Actions')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('policy_recommendations')
                            ->label('Policy Recommendations')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                    ]),
 
                // ── 17. Appendices ───────────────────────────────────────────
                Section::make('17. Appendices')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('hash_values')
                            ->label('Hash Values')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                        TextEntry::make('glossary_of_terms')
                            ->label('Glossary of Terms')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                    ]),
 
                // ── Attachments ──────────────────────────────────────────────
                Section::make('Attachments')
                    ->columnSpanFull()
                    ->schema([
 
                        // Evidence Photographs & Screenshots
                        SpatieMediaLibraryImageEntry::make('images')
                            ->label('Evidence Photographs & Screenshots')
                            ->collection('forensic-report-images')
                            ->imageGallery(),

                        // Evidence Files
                        RepeatableEntry::make('media')
                            ->label('Forensic Report Files')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('File Name')
                                    ->suffixAction(
                                        Action::make('download')
                                            ->icon('heroicon-m-arrow-down-tray')
                                            ->button()
                                            ->action(fn ($record) => response()->download(
                                                $record->getPath(),
                                                $record->file_name
                                            ))
                                    ),
                                ImageEntry::make('mime_type')
                                        ->label('File Icon')
                                        ->getStateUsing(function ($record) {
                                            // Determine icon based on mime type
                                            $mime = $record->mime_type;
                                            
                                            $icon = match (true) {
                                                Str::contains($mime, ['application/pdf', 'application/x-pdf', 'application/acrobat', 'application/vnd.pdf','text/pdf','text/x-pdf']) => 'pdf.png',
                                                Str::contains($mime, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-word.document.macroEnabled.12', 'application/vnd.ms-word.template.macroEnabled.12']) => 'word.png',
                                                Str::contains($mime, ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel.sheet.macroEnabled.12', 'application/vnd.ms-excel.template.macroEnabled.12']) => 'excel.png',
                                                Str::contains($mime, ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-powerpoint.presentation.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow', 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.template', 'application/vnd.ms-powerpoint.template.macroEnabled.12',]) => 'powerpoint.png',
                                                Str::contains($mime, 'video/') => 'video.png',
                                                Str::contains($mime, ['audio/mpeg', 'audio/ogg', 'audio/wav', 'audio/x-m4a', 'audio/webm', 'audio/']) => 'audio.png',
                                                Str::contains($mime, ['application/zip','zip']) => 'zip.png',
                                                Str::contains($mime, 'text/') => 'txt-file.png',
                                                default => 'attach-file.png', // Default icon
                                            };
                
                                                // Return path to the icon in public/images/file-icons/
                                                return asset('images/file-icons/' . $icon);
                                            })
                                            ->disk('public') // Assuming images are in public disk
                                            ->imageSize(20),

                                    TextEntry::make('mime_type')
                                        ->label('File Type')
                                        ->getStateUsing(function ($record) {
                                                // Determine icon based on mime type
                                                $mime = $record->mime_type;

                                                return match (true) {
                                                    Str::contains($mime, ['application/pdf','application/x-pdf', 'application/acrobat','application/vnd.pdf','text/pdf','text/x-pdf']) => 'PDF Document',
                                                    Str::contains($mime, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-word.document.macroEnabled.12', 'application/vnd.ms-word.template.macroEnabled.12']) => 'Microsoft Word',
                                                    Str::contains($mime, ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel.sheet.macroEnabled.12', 'application/vnd.ms-excel.template.macroEnabled.12']) => 'Microsoft Excel',
                                                    Str::contains($mime, ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-powerpoint.presentation.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow', 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.template', 'application/vnd.ms-powerpoint.template.macroEnabled.12']) => 'Microsoft PowerPoint',
                                                    Str::contains($mime, ['video/']) => 'Video',
                                                    Str::contains($mime, ['audio/']) => 'Audio',
                                                    Str::contains($mime, ['zip']) => 'Zip',
                                                    Str::contains($mime, ['text/']) => 'Txt-File',
                                                    default => 'Attachment',
                                                };
                                            }),
                            ])
                            ->getStateUsing(fn ($record) => $record->media->where(
                                'collection_name', 'forensic-report-files'
                            )),
 
                    ]),
 
                // ── Audit Trail ──────────────────────────────────────────────
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Group::make([
                            TextEntry::make('created_at')->label('Created At')->dateTime(),
                            TextEntry::make('updated_at')->label('Updated At')->dateTime(),
                            TextEntry::make('deleted_at')->label('Deleted At')->dateTime(),
                        ])->columns(3)->columnSpan(2),
                    ]),
            Section::make()
                    ->columnSpanFull()
                    ->schema([
                        CommentsEntry::make('comments')
                            ->mentionables(function (ForensicReport $record) {
                                return $record->receivers
                                    ->push($record->user)
                                    ->filter()
                                    ->unique('id');

                            })
                            ->perPage(8),
                    ]),
        ]);
    }
}