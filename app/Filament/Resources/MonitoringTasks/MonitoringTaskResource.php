<?php

namespace App\Filament\Resources\MonitoringTasks;

use App\Filament\Resources\MonitoringTasks\Pages\CreateMonitoringTask;
use App\Filament\Resources\MonitoringTasks\Pages\EditMonitoringTask;
use App\Filament\Resources\MonitoringTasks\Pages\ListMonitoringTasks;
use App\Filament\Resources\MonitoringTasks\Pages\ViewMonitoringTask;
use App\Filament\Resources\MonitoringTasks\Schemas\MonitoringTaskForm;
use App\Filament\Resources\MonitoringTasks\Schemas\MonitoringTaskInfolist;
use App\Filament\Resources\MonitoringTasks\Tables\MonitoringTasksTable;
use App\Models\MonitoringTask;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;

class MonitoringTaskResource extends Resource
{
    protected static ?string $model = MonitoringTask::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ListBullet;

    protected static string | UnitEnum | null $navigationGroup = 'Monitoring';

    protected static ?int $navigationSort = 2;

    // public static function getRecordTitle(?Model $record): string|Htmlable|null
    // {
    //     return $record?->topics->pluck('name')->join(', ') ?: 'Monitoring Task';
    // }

    // public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    // {
    //     return $record->topics->pluck('name')->join(', ') ?: 'Monitoring Task';
    // }

    public static function form(Schema $schema): Schema
    {
        return MonitoringTaskForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MonitoringTaskInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MonitoringTasksTable::configure($table);
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
            'index' => ListMonitoringTasks::route('/'),
            'create' => CreateMonitoringTask::route('/create'),
            'view' => ViewMonitoringTask::route('/{record}'),
            'edit' => EditMonitoringTask::route('/{record}/edit'),
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
