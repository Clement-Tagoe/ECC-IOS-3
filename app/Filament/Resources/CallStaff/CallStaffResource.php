<?php

namespace App\Filament\Resources\CallStaff;

use App\Filament\Resources\CallStaff\CallStaffResource\RelationManagers\AgentActivitiesRelationManager;
use App\Filament\Resources\CallStaff\Pages\ViewCallStaff;
use App\Filament\Resources\CallStaff\Pages\CreateCallStaff;
use App\Filament\Resources\CallStaff\Pages\EditCallStaff;
use App\Filament\Resources\CallStaff\Pages\ListCallStaff;
use App\Filament\Resources\CallStaff\Schemas\CallStaffForm;
use App\Filament\Resources\CallStaff\Schemas\CallStaffInfolist;
use App\Filament\Resources\CallStaff\Tables\CallStaffTable;
use App\Models\CallStaff;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CallStaffResource extends Resource
{
    protected static ?string $model = CallStaff::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | UnitEnum | null $navigationGroup = 'Call-Taking';

    protected static ?string $navigationLabel = 'Call Staff';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return CallStaffForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CallStaffInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CallStaffTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AgentActivitiesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCallStaff::route('/'),
            'create' => CreateCallStaff::route('/create'),
            'view' => ViewCallStaff::route('/{record}'),
            'edit' => EditCallStaff::route('/{record}/edit'),
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
