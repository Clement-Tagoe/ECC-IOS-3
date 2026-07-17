<?php

namespace App\Filament\Resources\ValidCases;

use App\Filament\Resources\ValidCases\Pages\CreateValidCase;
use App\Filament\Resources\ValidCases\Pages\EditValidCase;
use App\Filament\Resources\ValidCases\Pages\ListValidCases;
use App\Filament\Resources\ValidCases\Pages\ViewValidCase;
use App\Filament\Resources\ValidCases\Schemas\ValidCaseForm;
use App\Filament\Resources\ValidCases\Schemas\ValidCaseInfolist;
use App\Filament\Resources\ValidCases\Tables\ValidCasesTable;
use App\Models\ValidCase;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ValidCaseResource extends Resource
{
    protected static ?string $model = ValidCase::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'validCaseNature.name';

    protected static string | UnitEnum | null $navigationGroup = 'Call-Taking';

    public static function form(Schema $schema): Schema
    {
        return ValidCaseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ValidCaseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ValidCasesTable::configure($table);
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
            'index' => ListValidCases::route('/'),
            'create' => CreateValidCase::route('/create'),
            'view' => ViewValidCase::route('/{record}'),
            'edit' => EditValidCase::route('/{record}/edit'),
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
