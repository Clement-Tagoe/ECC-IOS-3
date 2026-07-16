<?php

namespace App\Filament\Resources\ForensicReports\Pages;

use App\Enums\ForensicReportStatus;
use App\Filament\Resources\ForensicReports\ForensicReportResource;
use App\Models\ForensicReport;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewForensicReport extends ViewRecord
{
    protected static string $resource = ForensicReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('change_status')
                ->icon(Heroicon::ArrowPathRoundedSquare)
                ->color('primary')
                ->modalWidth(Width::Medium)
                ->modalSubmitActionLabel('Save')
                ->stickyModalFooter()
                ->fillForm(fn (ForensicReport $record): array => [
                    'status' => $record->status,
                ])
                ->schema([
                    ToggleButtons::make('status')
                        ->options(ForensicReportStatus::class)
                        ->inline()
                        ->required(),
                ])
                ->action(function (ForensicReport $record, array $data): void {
                    $record->update($data);
                    $this->refreshFormData(['status']);
                }),
            Action::make('exportPdf')
                ->label('Download PDF')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $forensicReport = $this->getRecord();

                    // Generate the PDF using a Blade view
                    $pdf = Pdf::loadView('pdf.forensic-report', ['report' => $forensicReport]);

                    // Download the file
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'forensic-report'.$forensicReport->id.'.pdf'
                    );
                }),
            EditAction::make(),
        ];
    }
}
