<?php

namespace App\Filament\Resources\MonitoringStaffGroups\Pages;

use App\Filament\Resources\MonitoringStaffGroups\MonitoringStaffGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMonitoringStaffGroups extends ListRecords
{
    protected static string $resource = MonitoringStaffGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
