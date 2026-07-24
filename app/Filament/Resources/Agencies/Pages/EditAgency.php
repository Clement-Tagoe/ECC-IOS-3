<?php

namespace App\Filament\Resources\Agencies\Pages;

use App\Filament\Resources\Agencies\AgencyResource;
use App\Models\Agency;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditAgency extends EditRecord
{
    protected static string $resource = AgencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                    ->action(function (Agency $record, DeleteAction $action) {
                        if ($record->validCases()->exists()) {
                            Notification::make()
                                ->title('Cannot delete agency')
                                ->body('This agency has valid cases attached. Remove or reassign them first.')
                                ->danger()
                                ->send();

                            $action->cancel();
                            return;
                        }

                        $record->delete();
                }),
        ];
    }
}
