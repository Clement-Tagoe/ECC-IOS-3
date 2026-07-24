<?php

namespace App\Filament\Resources\ValidCases\Pages;

use App\Filament\Resources\ValidCases\ValidCaseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditValidCase extends EditRecord
{
    protected static string $resource = ValidCaseResource::class;

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
