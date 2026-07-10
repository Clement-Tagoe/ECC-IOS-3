<?php

namespace App\Filament\Resources\CameraAudits;

use App\Filament\Resources\CameraAudits\Pages\CreateCameraAudit;
use App\Filament\Resources\CameraAudits\Pages\EditCameraAudit;
use App\Filament\Resources\CameraAudits\Pages\ListCameraAudits;
use App\Filament\Resources\CameraAudits\Schemas\CameraAuditForm;
use App\Filament\Resources\CameraAudits\Schemas\CameraAuditInfolist;
use App\Filament\Resources\CameraAudits\Tables\CameraAuditsTable;
use App\Models\CameraAudit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CameraAuditResource extends Resource
{
    protected static ?string $model = CameraAudit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Camera;

    protected static ?string $recordTitleAttribute = 'camera_name';

    protected static string | UnitEnum | null $navigationGroup = 'Monitoring';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return CameraAuditForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CameraAuditsTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CameraAuditInfolist::configure($schema);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
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
            'index' => ListCameraAudits::route('/'),
            'create' => CreateCameraAudit::route('/create'),
            'edit' => EditCameraAudit::route('/{record}/edit'),
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
