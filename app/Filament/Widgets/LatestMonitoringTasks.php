<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\MonitoringTasks\MonitoringTaskResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestMonitoringTasks extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(MonitoringTaskResource::getEloquentQuery()->limit(10))
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('time'),
                TextColumn::make('shift')
                    ->badge(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('topics.name'),
                TextColumn::make('region.name'),
                TextColumn::make('location.name'),
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
