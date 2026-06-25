<?php

namespace App\Filament\Resources\ContactLists\Pages;

use App\Filament\Resources\ContactLists\ContactListResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContactList extends ViewRecord
{
    protected static string $resource = ContactListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
