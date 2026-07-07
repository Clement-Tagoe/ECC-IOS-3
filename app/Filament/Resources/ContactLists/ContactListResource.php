<?php

namespace App\Filament\Resources\ContactLists;

use App\Filament\Resources\ContactLists\Pages\CreateContactList;
use App\Filament\Resources\ContactLists\Pages\EditContactList;
use App\Filament\Resources\ContactLists\Pages\ListContactLists;
use App\Filament\Resources\ContactLists\Pages\ViewContactList;
use App\Filament\Resources\ContactLists\Schemas\ContactListForm;
use App\Filament\Resources\ContactLists\Schemas\ContactListInfolist;
use App\Filament\Resources\ContactLists\Tables\ContactListsTable;
use App\Models\ContactList;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ContactListResource extends Resource
{
    protected static ?string $model = ContactList::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DevicePhoneMobile;

    protected static string | UnitEnum | null $navigationGroup = 'Others';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ContactListForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContactListInfolist::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return ContactListsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactLists::route('/'),
            'create' => CreateContactList::route('/create'),
            'view' => ViewContactList::route('/{record}'),
            'edit' => EditContactList::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
