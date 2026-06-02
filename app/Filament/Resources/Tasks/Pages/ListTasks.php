<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Enums\TaskStatus;
use App\Filament\Resources\Tasks\TaskResource;
use App\Models\Task;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $userId = Auth::user()->id;

        return [
            'all' => Tab::make()
                ->icon(Heroicon::OutlinedClipboardDocumentCheck),
            'in progress' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', TaskStatus::InProgress)
                                                                ->where(fn (Builder $q) => $q
                                                                ->where('user_id', $userId)
                                                                ->orWhereHas('collaborators', fn (Builder $q) => $q->where('users.id', $userId))
                ))
                ->badge(Task::query()
                        ->where('status', TaskStatus::InProgress)
                        ->where(fn (Builder $q) => $q
                            ->where('user_id', $userId)
                            ->orWhereHas('collaborators', fn (Builder $q) => $q->where('users.id', $userId))
                        )
                        ->count()),
            'completed' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', TaskStatus::Completed)
                                                                ->where(fn (Builder $q) => $q
                                                                ->where('user_id', $userId)
                                                                ->orWhereHas('collaborators', fn (Builder $q) => $q->where('users.id', $userId))
                ))
                ->badge(Task::query()
                        ->where('status', TaskStatus::Completed)
                        ->where(fn (Builder $q) => $q
                            ->where('user_id', $userId)
                            ->orWhereHas('collaborators', fn (Builder $q) => $q->where('users.id', $userId))
                        )
                        ->count()),
            'in review' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', TaskStatus::InReview)
                                                                ->where(fn (Builder $q) => $q
                                                                ->where('user_id', $userId)
                                                                ->orWhereHas('collaborators', fn (Builder $q) => $q->where('users.id', $userId))
                ))
                ->badge(Task::query()
                        ->where('status', TaskStatus::InReview)
                        ->where(fn (Builder $q) => $q
                            ->where('user_id', $userId)
                            ->orWhereHas('collaborators', fn (Builder $q) => $q->where('users.id', $userId))
                        )
                        ->count()),
            'reviewed' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', TaskStatus::Reviewed)
                                                                ->where(fn (Builder $q) => $q
                                                                ->where('user_id', $userId)
                                                                ->orWhereHas('collaborators', fn (Builder $q) => $q->where('users.id', $userId))
                ))
                ->badge(Task::query()
                        ->where('status', TaskStatus::Reviewed)
                        ->where(fn (Builder $q) => $q
                            ->where('user_id', $userId)
                            ->orWhereHas('collaborators', fn (Builder $q) => $q->where('users.id', $userId))
                        )
                        ->count()),
            'cancelled' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', TaskStatus::Cancelled)
                                                                ->where(fn (Builder $q) => $q
                                                                ->where('user_id', $userId)
                                                                ->orWhereHas('collaborators', fn (Builder $q) => $q->where('users.id', $userId))
                ))
                ->badge(Task::query()
                        ->where('status', TaskStatus::Cancelled)
                        ->where(fn (Builder $q) => $q
                            ->where('user_id', $userId)
                            ->orWhereHas('collaborators', fn (Builder $q) => $q->where('users.id', $userId))
                        )
                        ->count()),
        ];
    }
}
