<?php

namespace App\Filament\Resources\CallStaff\Pages;

use App\Filament\Resources\CallStaff\CallStaffResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCallStaff extends EditRecord
{
    protected static string $resource = CallStaffResource::class;

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
