<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ValidCases\ValidCaseResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestValidCases extends TableWidget
{ 
    public function table(Table $table): Table
    {
        return $table
            ->query(ValidCaseResource::getEloquentQuery()->limit(10))
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('case_id')
                    ->label('Case ID'),
                TextColumn::make('reporting_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('reporting_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('agency.name'),
                TextColumn::make('location.name'),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                
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
