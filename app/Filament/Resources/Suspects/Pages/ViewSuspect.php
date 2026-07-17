<?php

namespace App\Filament\Resources\Suspects\Pages;

use App\Filament\Resources\Suspects\SuspectResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewSuspect extends ViewRecord
{
    protected static string $resource = SuspectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportPdf')
                ->label('Download PDF')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $suspect = $this->getRecord();

                    // Generate the PDF using a Blade view
                    $pdf = Pdf::loadView('pdf.suspect', ['suspect' => $suspect]);

                    // Download the file
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'suspect'.$suspect->id.'.pdf'
                    );
                }),
            EditAction::make(),
        ];
    }
}
