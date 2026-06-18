<?php

namespace App\Filament\Widgets;


use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use App\Filament\Resources\Reports\ReportResource;
use App\Models\Report;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Kirschbaum\Commentions\Filament\Actions\CommentsAction;

class LatestReports extends TableWidget
{
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
            ])
            ->filters([
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                CommentsAction::make()
                    ->mentionables(function (Report $record) {
                        return $record->receivers
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
