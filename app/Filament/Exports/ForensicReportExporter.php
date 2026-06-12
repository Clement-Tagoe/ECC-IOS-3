<?php

namespace App\Filament\Exports;

use App\Models\ForensicReport;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ForensicReportExporter extends Exporter
{
    protected static ?string $model = ForensicReport::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('case_reference_number'),
            ExportColumn::make('investigation_title'),
            ExportColumn::make('requesting_agency'),
            ExportColumn::make('lead_examiner'),
            ExportColumn::make('court_jurisdiction'),
            ExportColumn::make('date_of_examination'),
            ExportColumn::make('status'),
            ExportColumn::make('certification_of_evidence_integrity'),
            ExportColumn::make('confirmation_of_methodologies'),
            ExportColumn::make('examiner_signature'),
            ExportColumn::make('signature_date'),
            ExportColumn::make('purpose_of_investigation'),
            ExportColumn::make('summary_of_findings'),
            ExportColumn::make('summary_of_conclusions'),
            ExportColumn::make('devices_examined'),
            ExportColumn::make('evidence_sources'),
            ExportColumn::make('investigation_objectives'),
            ExportColumn::make('search_warrant_details'),
            ExportColumn::make('court_order_references'),
            ExportColumn::make('consent_authorization'),
            ExportColumn::make('applicable_legal_framework'),
            ExportColumn::make('evidence_inventory'),
            ExportColumn::make('condition_of_evidence'),
            ExportColumn::make('hash_algorithm'),
            ExportColumn::make('hash_verification_details'),
            ExportColumn::make('evidence_transfer_records'),
            ExportColumn::make('storage_records'),
            ExportColumn::make('custodian_signatures'),
            ExportColumn::make('methodology_identification'),
            ExportColumn::make('methodology_preservation'),
            ExportColumn::make('methodology_acquisition'),
            ExportColumn::make('methodology_examination'),
            ExportColumn::make('methodology_analysis'),
            ExportColumn::make('methodology_reporting'),
            ExportColumn::make('workstation_specifications'),
            ExportColumn::make('write_blockers_used'),
            ExportColumn::make('forensic_tools_and_versions'),
            ExportColumn::make('imaging_procedures'),
            ExportColumn::make('verification_methods'),
            ExportColumn::make('artifact_analysis'),
            ExportColumn::make('timeline_reconstruction'),
            ExportColumn::make('user_activity_analysis'),
            ExportColumn::make('file_system_analysis'),
            ExportColumn::make('browser_history'),
            ExportColumn::make('email_analysis'),
            ExportColumn::make('usb_analysis'),
            ExportColumn::make('mobile_device_analysis'),
            ExportColumn::make('chronological_reconstruction'),
            ExportColumn::make('correlation_of_evidence_sources'),
            ExportColumn::make('investigation_conclusions'),
            ExportColumn::make('evidentiary_significance'),
            ExportColumn::make('professional_opinion'),
            ExportColumn::make('reasonable_degree_of_forensic_certainty'),
            ExportColumn::make('scope_limitations'),
            ExportColumn::make('potential_data_gaps'),
            ExportColumn::make('timestamp_considerations'),
            ExportColumn::make('security_improvements'),
            ExportColumn::make('further_investigative_actions'),
            ExportColumn::make('policy_recommendations'),
            ExportColumn::make('hash_values'),
            ExportColumn::make('screenshots'),
            ExportColumn::make('tool_logs'),
            ExportColumn::make('evidence_photographs'),
            ExportColumn::make('glossary_of_terms'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('deleted_at'),
            ExportColumn::make('created_by'),
            ExportColumn::make('updated_by'),
            ExportColumn::make('deleted_by'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your forensic report export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
