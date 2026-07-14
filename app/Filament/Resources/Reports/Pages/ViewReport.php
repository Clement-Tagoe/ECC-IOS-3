<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Enums\ReportStatus;
use App\Filament\Resources\Reports\ReportResource;
use App\Models\Report;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('change_status')
                ->icon(Heroicon::ArrowPathRoundedSquare)
                ->color('primary')
                ->modalWidth(Width::Medium)
                ->modalSubmitActionLabel('Save')
                ->stickyModalFooter()
                ->fillForm(fn (Report $record): array => [
                    'status' => $record->status,
                ])
                ->schema([
                    ToggleButtons::make('status')
                        ->options(ReportStatus::class)
                        ->inline()
                        ->required(),
                ])
                ->action(function (Report $record, array $data): void {
                    $record->update($data);
                    $this->refreshFormData(['status']);
                }),
            Action::make('exportPdf')
                ->label('Download PDF')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $report = $this->getRecord();

                    // Generate the PDF using a Blade view
                    $pdf = Pdf::loadView('pdf.report', ['report' => $report]);

                    // Download the file
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'report'.$report->id.'.pdf'
                    );
                }),
            EditAction::make(),
        ];
    }
}
