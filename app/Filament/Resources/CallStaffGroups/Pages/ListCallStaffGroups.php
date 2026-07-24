<?php

namespace App\Filament\Resources\CallStaffGroups\Pages;

use App\Filament\Resources\CallStaffGroups\CallStaffGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCallStaffGroups extends ListRecords
{
    protected static string $resource = CallStaffGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
