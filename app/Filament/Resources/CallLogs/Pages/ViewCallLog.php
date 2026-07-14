<?php

namespace App\Filament\Resources\CallLogs\Pages;

use App\Enums\CallLogStatus;
use App\Filament\Resources\CallLogs\CallLogResource;
use App\Models\CallLog;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewCallLog extends ViewRecord
{
    protected static string $resource = CallLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('change_status')
                ->icon(Heroicon::ArrowPathRoundedSquare)
                ->color('primary')
                ->modalWidth(Width::Medium)
                ->modalSubmitActionLabel('Save')
                ->stickyModalFooter()
                ->fillForm(fn (CallLog $record): array => [
                    'status' => $record->status,
                ])
                ->schema([
                    ToggleButtons::make('status')
                        ->options(CallLogStatus::class)
                        ->inline()
                        ->required(),
                ])
                ->action(function (CallLog $record, array $data): void {
                    $record->update($data);
                    $this->refreshFormData(['status']);
                }),
            Action::make('exportPdf')
                ->label('Download PDF')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $callLog = $this->getRecord();

                    // Generate the PDF using a Blade view
                    $pdf = Pdf::loadView('pdf.call-log', ['callLog' => $callLog]);

                    // Download the file
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'call-log-'.$callLog->id.'.pdf'
                    );
                }),
            EditAction::make(),
        ];
    }
}
