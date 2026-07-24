<?php

namespace App\Filament\Resources\MonitoringStaffGroups;

use App\Filament\Resources\MonitoringStaffGroups\Pages\CreateMonitoringStaffGroup;
use App\Filament\Resources\MonitoringStaffGroups\Pages\EditMonitoringStaffGroup;
use App\Filament\Resources\MonitoringStaffGroups\Pages\ListMonitoringStaffGroups;
use App\Filament\Resources\MonitoringStaffGroups\Pages\ViewMonitoringStaffGroup;
use App\Filament\Resources\MonitoringStaffGroups\Schemas\MonitoringStaffGroupForm;
use App\Filament\Resources\MonitoringStaffGroups\Schemas\MonitoringStaffGroupInfolist;
use App\Filament\Resources\MonitoringStaffGroups\Tables\MonitoringStaffGroupsTable;
use App\Models\MonitoringStaffGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class MonitoringStaffGroupResource extends Resource
{
    protected static ?string $model = MonitoringStaffGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | UnitEnum | null $navigationGroup = 'Monitoring';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return MonitoringStaffGroupForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MonitoringStaffGroupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MonitoringStaffGroupsTable::configure($table);
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
            'index' => ListMonitoringStaffGroups::route('/'),
            'create' => CreateMonitoringStaffGroup::route('/create'),
            'view' => ViewMonitoringStaffGroup::route('/{record}'),
            'edit' => EditMonitoringStaffGroup::route('/{record}/edit'),
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
