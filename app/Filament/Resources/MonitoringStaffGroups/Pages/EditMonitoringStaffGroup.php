<?php

namespace App\Filament\Resources\MonitoringStaffGroups\Pages;

use App\Filament\Resources\MonitoringStaffGroups\MonitoringStaffGroupResource;
use App\Models\MonitoringStaffGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditMonitoringStaffGroup extends EditRecord
{
    protected static string $resource = MonitoringStaffGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                    ->action(function (MonitoringStaffGroup $record, DeleteAction $action) {
                        if ($record->monitoringStaffs()->exists()) {
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
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
