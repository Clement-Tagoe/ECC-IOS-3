<?php

namespace App\Filament\Widgets\MainDashboard;

use App\Filament\Resources\Tasks\TaskResource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class LatestTasks extends TableWidget
{   
    protected int | string | array $columnSpan =  6;
    
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
            ]);
    }
}
