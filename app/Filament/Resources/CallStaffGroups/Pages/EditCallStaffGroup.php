<?php

namespace App\Filament\Resources\CallStaffGroups\Pages;

use App\Filament\Resources\CallStaffGroups\CallStaffGroupResource;
use App\Models\CallStaffGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCallStaffGroup extends EditRecord
{
    protected static string $resource = CallStaffGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                    ->action(function (CallStaffGroup $record, DeleteAction $action) {
                        if ($record->callStaffs()->exists()) {
                            Notification::make()
                                ->title('Cannot delete group')
                                ->body('This group has call staff assigned to it. Reassign or remove them first.')
                                ->danger()
                                ->send();

                            $action->cancel();
                            return;
                        }

                        $record->delete();
                    }),
            RestoreAction::make(),
        ];
    }
}
