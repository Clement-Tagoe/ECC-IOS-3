<?php

namespace App\Traits;

use App\Filament\Resources\ForensicCases\ForensicCaseResource;
use App\Filament\Resources\ForensicReports\ForensicReportResource;
use App\Filament\Resources\Reports\ReportResource;
use App\Filament\Resources\Tasks\TaskResource;
use App\Models\ForensicCase;
use App\Models\ForensicReport;
use App\Models\Report;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Kirschbaum\Commentions\Comment;


trait SendsCommentNotifications
{
    private function sendCommentNotification(Comment $comment, Collection $recipients, string $title): void
    {
        $url = $this->resolveCommentUrl($comment);

        foreach ($recipients as $recipient) {
            Notification::make()
                ->title($title)
                ->body(strip_tags($comment->getBodyMarkdown()))
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->actions([
                    Action::make('view')
                        ->label('View Comment')
                        ->url($url)
                        ->markAsRead()
                        ->close()
                ])
                ->sendToDatabase($recipient);

            event(new DatabaseNotificationsSent($recipient));
        }
    }

    private function resolveCommentUrl(Comment $comment): \Closure
    {
        return function () use ($comment) {
            $record = $comment->commentable;

            return match (true) {
                $record instanceof Task   => TaskResource::getUrl('view', ['record' => $record]),
                $record instanceof Report => ReportResource::getUrl('view', ['record' => $record]),
                $record instanceof ForensicCase   => ForensicCaseResource::getUrl('view', ['record' => $record]),
                $record instanceof ForensicReport => ForensicReportResource::getUrl('view', ['record' => $record]),
                default                   => null,
            };
        };
    }
}