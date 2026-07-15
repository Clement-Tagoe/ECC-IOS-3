<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\ReportResource;
use Filament\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }

    protected function afterCreate(): void
    {
        $report = $this->record;

       if ($report->receivers->isNotEmpty()) {
            foreach ($report->receivers as $user) {
                Notification::make()
                    ->title('New Report from '. $report->user->name)
                    ->body('Title: ' . $report->title)
                    ->actions([
                        Action::make('Mark as read')
                            ->button()
                            ->markAsRead()
                            ->close(),
                        Action::make('View')
                            ->button()
                            ->url(ReportResource::getUrl('view', ['record' => $report]))
                            ->markAsRead()
                            ->close(),
                    ])
                    ->sendToDatabase($user);
                event(new DatabaseNotificationsSent($user));
                }
        }
    }
}
