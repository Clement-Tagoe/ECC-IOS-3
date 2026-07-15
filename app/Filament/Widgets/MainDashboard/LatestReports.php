<?php

namespace App\Filament\Widgets\MainDashboard;


use App\Filament\Resources\Reports\ReportResource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LatestReports extends TableWidget
{
    protected int | string | array $columnSpan =  6;

    public function table(Table $table): Table
    {
        return $table
            ->query(ReportResource::getEloquentQuery()->limit(10))
            ->modifyQueryUsing(function ($query) {
                    return $query->where(function (Builder $q) {
                        $q->where('user_id', Auth::id())
                        ->orWhereHas('receivers', function (Builder $q) {
                            $q->where('users.id', Auth::id());
                        });
                    });
                })
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Sent By'),
                TextColumn::make('title')
                    ->sortable()
                    ->weight(FontWeight::Medium)
                    ->limit(10),
                TextColumn::make('type'),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('priority')
                    ->badge(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('receivers.name')
                    ->label('Sent To')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('attachments_count')
                    ->label('Attachments')
                    ->getStateUsing(fn ($record) => $record->media->count())
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'info' : 'success')
                    ->sortable(false)   // counting is not easily sortable without extra work
                    ->alignCenter(),
            ]);
    }
}
