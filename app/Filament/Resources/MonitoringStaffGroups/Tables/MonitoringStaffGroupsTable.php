<?php

namespace App\Filament\Resources\MonitoringStaffGroups\Tables;

use App\Models\MonitoringStaffGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MonitoringStaffGroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->action(function (MonitoringStaffGroup $record, DeleteAction $action) {
                        if ($record->monitoringStaffs()->exists()) {
                            Notification::make()
                                ->title('Cannot delete group')
                                ->body('This group has call staff assigned to it. Reassign or remove them first.')
                                ->danger()
                                ->send();

                            $action->cancel();
                            return;
                        }

                        $record->delete();
                    }),
                RestoreAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
