<?php

namespace App\Filament\Resources\MonitoringTasks\Pages;

use App\Filament\Resources\MonitoringTasks\MonitoringTaskResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMonitoringTask extends EditRecord
{
    protected static string $resource = MonitoringTaskResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
