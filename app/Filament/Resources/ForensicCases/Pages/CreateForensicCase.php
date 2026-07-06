<?php

namespace App\Filament\Resources\ForensicCases\Pages;

use App\Filament\Resources\ForensicCases\ForensicCaseResource;
use Filament\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateForensicCase extends CreateRecord
{
    protected static string $resource = ForensicCaseResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

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
                    ->title('New Forensic Case from '. $report->user->name)
                    ->body('Title: ' . $report->title)
                    ->actions([
                        Action::make('Mark as read')
                            ->button()
                            ->markAsRead()
                            ->close(),
                        Action::make('View')
                            ->button()
                            ->url(ForensicCaseResource::getUrl('view', ['record' => $report]))
                            ->markAsRead()
                            ->close(),
                    ])
                    ->sendToDatabase($user);
                event(new DatabaseNotificationsSent($user));
                }
        }
    }
}
