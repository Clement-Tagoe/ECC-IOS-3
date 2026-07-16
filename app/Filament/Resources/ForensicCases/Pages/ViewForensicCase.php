<?php

namespace App\Filament\Resources\ForensicCases\Pages;

use App\Enums\ForensicCaseStatus;
use App\Filament\Resources\ForensicCases\ForensicCaseResource;
use App\Models\ForensicCase;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewForensicCase extends ViewRecord
{
    protected static string $resource = ForensicCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('change_status')
                ->icon(Heroicon::ArrowPathRoundedSquare)
                ->color('primary')
                ->modalWidth(Width::Medium)
                ->modalSubmitActionLabel('Save')
                ->stickyModalFooter()
                ->fillForm(fn (ForensicCase $record): array => [
                    'status' => $record->status,
                ])
                ->schema([
                    ToggleButtons::make('status')
                        ->options(ForensicCaseStatus::class)
                        ->inline()
                        ->required(),
                ])
                ->action(function (ForensicCase $record, array $data): void {
                    $record->update($data);
                    $this->refreshFormData(['status']);
                }),
            Action::make('exportPdf')
                ->label('Download PDF')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $forensicCase = $this->getRecord();

                    // Generate the PDF using a Blade view
                    $pdf = Pdf::loadView('pdf.forensic-case', ['case' => $forensicCase]);

                    // Download the file
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'forensic-case'.$forensicCase->id.'.pdf'
                    );
                }),
            EditAction::make(),
        ];
    }
}
