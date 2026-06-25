<?php

namespace App\Filament\Resources\ContactLists\Pages;

use App\Filament\Resources\ContactLists\ContactListResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditContactList extends EditRecord
{
    protected static string $resource = ContactListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
