<?php

namespace App\Filament\Resources\CallStaffGroups;

use App\Filament\Resources\CallStaffGroups\Pages\CreateCallStaffGroup;
use App\Filament\Resources\CallStaffGroups\Pages\EditCallStaffGroup;
use App\Filament\Resources\CallStaffGroups\Pages\ListCallStaffGroups;
use App\Filament\Resources\CallStaffGroups\Pages\ViewCallStaffGroup;
use App\Filament\Resources\CallStaffGroups\Schemas\CallStaffGroupForm;
use App\Filament\Resources\CallStaffGroups\Schemas\CallStaffGroupInfolist;
use App\Filament\Resources\CallStaffGroups\Tables\CallStaffGroupsTable;
use App\Models\CallStaffGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CallStaffGroupResource extends Resource
{
    protected static ?string $model = CallStaffGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | UnitEnum | null $navigationGroup = 'Call-Taking';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return CallStaffGroupForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CallStaffGroupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CallStaffGroupsTable::configure($table);
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
            'index' => ListCallStaffGroups::route('/'),
            'create' => CreateCallStaffGroup::route('/create'),
            'view' => ViewCallStaffGroup::route('/{record}'),
            'edit' => EditCallStaffGroup::route('/{record}/edit'),
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
