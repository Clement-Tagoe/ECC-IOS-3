<?php

namespace App\Filament\Exports;

use App\Models\ValidCase;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ValidCaseExporter extends Exporter
{
    protected static ?string $model = ValidCase::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('case_id'),
            ExportColumn::make('reporting_time'),
            ExportColumn::make('reporting_date'),
            ExportColumn::make('region.name'),
            ExportColumn::make('agency.name'),
            ExportColumn::make('validCaseNature.name'),
            ExportColumn::make('location.name'),
            ExportColumn::make('status'),
            ExportColumn::make('contact_name'),
            ExportColumn::make('contact_number'),
            ExportColumn::make('description'),
            ExportColumn::make('feedback_comment'),
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
        $body = 'Your valid case export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
