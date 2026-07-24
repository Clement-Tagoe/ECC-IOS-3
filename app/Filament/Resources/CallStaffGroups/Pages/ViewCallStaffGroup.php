<?php

namespace App\Filament\Resources\CallStaffGroups\Pages;

use App\Filament\Resources\CallStaffGroups\CallStaffGroupResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCallStaffGroup extends ViewRecord
{
    protected static string $resource = CallStaffGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
