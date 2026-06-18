<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Tasks\TaskResource;
use App\Models\Task;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Kirschbaum\Commentions\Filament\Actions\CommentsAction;


class LatestTasks extends TableWidget
{   
    public function table(Table $table): Table
    {
        return $table
             ->query(TaskResource::getEloquentQuery()->limit(10))
             ->modifyQueryUsing(function ($query) {
                return $query->where(function (Builder $q) {
                    $q->where('user_id', Auth::id())
                    ->orWhereHas('collaborators', function (Builder $q) {
                        $q->where('users.id', Auth::id());
                    });
                });
            })
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Assigned By'),
                 TextColumn::make('title')
                    ->sortable()
                    ->weight(FontWeight::Medium)
                    ->limit(40),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('priority')
                    ->badge(),

                TextColumn::make('collaborators.name')
                    ->label('Assignee(s)')
                    ->badge()
                    ->color('tertiary'),

                TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                CommentsAction::make()
                    ->mentionables(function (Task $record) {
                                return $record->collaborators
                                    ->push($record->user)
                                    ->filter()
                                    ->unique('id');
                    })
                    ->perPage(10),
                DeleteAction::make(),
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
