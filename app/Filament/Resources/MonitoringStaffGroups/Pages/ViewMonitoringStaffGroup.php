<?php

namespace App\Filament\Resources\MonitoringStaffGroups\Pages;

use App\Filament\Resources\MonitoringStaffGroups\MonitoringStaffGroupResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMonitoringStaffGroup extends ViewRecord
{
    protected static string $resource = MonitoringStaffGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
