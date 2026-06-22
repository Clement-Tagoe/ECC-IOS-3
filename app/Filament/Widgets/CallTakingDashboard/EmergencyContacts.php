<?php

namespace App\Filament\Widgets\CallTakingDashboard;

use App\Filament\Resources\EmergencyContacts\EmergencyContactResource;
use Filament\Actions\BulkActionGroup;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class EmergencyContacts extends TableWidget
{
    protected int | string | array $columnSpan =  4;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(EmergencyContactResource::getEloquentQuery()->limit(10))
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('contacts')
                    ->icon(Heroicon::PhoneArrowUpRight)
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
