<?php

namespace App\Filament\Resources\CallStaffGroups\Pages;

use App\Filament\Resources\CallStaffGroups\CallStaffGroupResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCallStaffGroup extends EditRecord
{
    protected static string $resource = CallStaffGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
