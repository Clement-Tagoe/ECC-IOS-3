<?php

namespace App\Filament\Resources\CameraLocations\Pages;

use App\Filament\Resources\CameraLocations\CameraLocationResource;
use App\Models\CameraLocation;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCameraLocation extends EditRecord
{
    protected static string $resource = CameraLocationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                    ->action(function (CameraLocation $record, DeleteAction $action) {
                        if ($record->cameraAudits()->exists()) {
                            Notification::make()
                                ->title('Cannot delete location')
                                ->body('This location has camera audits attached. Remove them first.')
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
