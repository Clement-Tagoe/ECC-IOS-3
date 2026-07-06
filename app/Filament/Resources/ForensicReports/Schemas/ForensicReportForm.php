<?php

namespace App\Filament\Resources\ForensicReports\Schemas;

use App\Enums\ForensicReportReviewStatus;
use App\Enums\ForensicReportStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ForensicReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('1. Case Information')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('case_reference_number')
                            ->required(),
                        TextInput::make('investigation_title')
                            ->required(),
                        TextInput::make('requesting_agency')
                            ->required(),
                        TextInput::make('lead_examiner')
                            ->required(),
                        TextInput::make('court_jurisdiction')
                            ->default(null),
                        DatePicker::make('date_of_examination')
                            ->required(),
                        ToggleButtons::make('status')
                            ->options(ForensicReportStatus::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(ForensicReportStatus::Open),
                        ToggleButtons::make('review_status')
                            ->options(ForensicReportReviewStatus::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(ForensicReportReviewStatus::InReview),
                        Select::make('collaborators')
                            ->relationship('collaborators', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('receivers')
                            ->label('Send To (Receivers)')
                            ->relationship(
                                name: 'receivers', 
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('users.id', '!=',Auth::id()))   // assuming User has 'name' column
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
            
                Section::make('2. Declaration')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('certification_of_evidence_integrity')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('confirmation_of_methodologies')
                            ->default(null)
                            ->columnSpanFull(),
                        TextInput::make('examiner_signature')
                            ->default(null),
                        DatePicker::make('signature_date'),
                    ]),
            
                Section::make('3. Executive Summary')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('purpose_of_investigation')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('summary_of_findings')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('summary_of_conclusions')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('4. Scope of Examination')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('devices_examined')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('evidence_sources')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('investigation_objectives')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('5. Legal Authority')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('search_warrant_details')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('court_order_references')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('consent_authorization')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('applicable_legal_framework')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('6. Evidence Received')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('evidence_inventory')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('condition_of_evidence')
                            ->default(null)
                            ->columnSpanFull(),
                        TextInput::make('hash_algorithm')
                            ->required()
                            ->default('SHA-256'),
                        Textarea::make('hash_verification_details')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('7. Chain of Custody')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('evidence_transfer_records')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('storage_records')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('custodian_signatures')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('8. Methodology')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('methodology_identification')
                            ->label('Identification')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('methodology_preservation')
                            ->label('Preservation')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('methodology_acquisition')
                            ->label('Acquisition')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('methodology_examination')
                            ->label('Examination')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('methodology_analysis')
                            ->label('Analysis')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('methodology_reporting')
                            ->label('Reporting')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('9. Forensic Environment')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('workstation_specifications')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('write_blockers_used')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('forensic_tools_and_versions')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('10. Examination Procedures')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('imaging_procedures')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('verification_methods')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('artifact_analysis')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('timeline_reconstruction')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('11. Findings and Analysis')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('user_activity_analysis')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('file_system_analysis')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('browser_history')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('email_analysis')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('usb_analysis')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('mobile_device_analysis')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('12. Timeline of Events')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('chronological_reconstruction')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('correlation_of_evidence_sources')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('13. Conclusion')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('investigation_conclusions')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('evidentiary_significance')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('14. Expert Opinion')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('professional_opinion')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('reasonable_degree_of_forensic_certainty')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('15. Limitations')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('scope_limitations')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('potential_data_gaps')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('timestamp_considerations')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('16. Recommendations')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('security_improvements')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('further_investigative_actions')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('policy_recommendations')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            
                Section::make('17. Appendices')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('hash_values')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('screenshots')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('tool_logs')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('evidence_photographs')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('glossary_of_terms')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),

                Section::make('18. Attachments')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('images')
                            ->collection('forensic-report-images')
                            ->multiple()
                            ->image()
                            ->preserveFilenames()
                            ->maxFiles(4)
                            ->nullable(),
                        SpatieMediaLibraryFileUpload::make('files/videos')
                            ->collection('forensic-report-files')
                            ->multiple()
                            ->preserveFilenames()
                            ->nullable(),
                    ])
            ]);
    }
}
