<?php

namespace App\Filament\Resources\Agencies\Tables;

use App\Models\Agency;
use App\Models\ForensicCase;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class AgenciesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('contact')
                    ->icon('heroicon-o-phone'),
                TextColumn::make('email')
                    ->icon('heroicon-o-envelope')
                    ->iconColor('primary'),
                TextColumn::make('location')
                    ->icon('heroicon-o-map-pin'),
                TextColumn::make('website')
                    ->icon('heroicon-o-globe-alt'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->action(function (Agency $record, DeleteAction $action) {
                        if ($record->validCases()->exists()) {
                            Notification::make()
                                ->title('Cannot delete agency')
                                ->body('This agency has valid cases attached. Remove or reassign them first.')
                                ->danger()
                                ->send();

                            $action->cancel();
                            return;
                        }

                        $record->delete();
                }),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
