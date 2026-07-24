<?php

namespace App\Filament\Resources\CameraAudits\Pages;

use App\Filament\Resources\CameraAudits\CameraAuditResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCameraAudit extends EditRecord
{
    protected static string $resource = CameraAuditResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
