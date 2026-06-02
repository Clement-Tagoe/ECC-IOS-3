<?php

namespace App\Providers;

use App\Filament\Resources\Reports\ReportResource;
use App\Filament\Resources\Tasks\TaskResource;
use App\Models\Report;
use App\Models\Task;
use App\Models\User;
use App\Observers\MessageObserver;
use App\Observers\UserObserver;
use Filament\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Kirschbaum\Commentions\Events\CommentWasCreatedEvent;
use Kirschbaum\Commentions\Events\UserWasMentionedEvent;
use Wirechat\Wirechat\Models\Message;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Message::observe(MessageObserver::class);
        User::observe(UserObserver::class);

        Event::listen(function (UserWasMentionedEvent $event) {
           
            assert($event->user instanceof \App\Models\User);

            $user = $event->user;
            $comment = $event->comment;

            Notification::make()
                ->title('You were mentioned in a comment by ' . $comment->getAuthorName())
                ->body(strip_tags($comment->getBodyMarkdown()))
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->actions([
                    Action::make('view')
                        ->label('View Comment')
                        ->url(function () use ($comment) {
                                $record = $comment->commentable;

                                if ($record instanceof Task) {
                                    return TaskResource::getUrl('view', ['record' => $record]);
                                } 
                                
                                if ($record instanceof Report) {
                                    return ReportResource::getUrl('view', ['record' => $record]);
                                }
                            })
                        ->markAsRead()
                        ->close()
                ])
                ->sendToDatabase($user);

                event(new DatabaseNotificationsSent($user));
            });
        
        Event::listen(function (CommentWasCreatedEvent $event) {
            $comment = $event->comment;

            $receivers = $comment->commentable->receivers;

            $collaborators = $comment->commentable->collaborators;

            if ($receivers && $receivers->isNotEmpty()) {
                foreach ($receivers as $receiver) {
                        Notification::make()
                        ->title('A comment was made by ' . $comment->getAuthorName())
                        ->body(strip_tags($comment->getBodyMarkdown()))
                        ->icon('heroicon-o-chat-bubble-left-ellipsis')
                        ->actions([
                            Action::make('view')
                                ->label('View Comment')
                                ->url(function () use ($comment) {
                                    $record = $comment->commentable;

                                    if ($record instanceof Task) {
                                        return TaskResource::getUrl('view', ['record' => $record]);
                                    } 
                                    
                                    if ($record instanceof Report) {
                                        return ReportResource::getUrl('view', ['record' => $record]);
                                    }
                                })
                                ->markAsRead()
                                ->close()
                        ])
                        ->sendToDatabase($receiver);

                        event(new DatabaseNotificationsSent($receiver));
                    }
                }

                if ($collaborators && $collaborators->isNotEmpty()) {
                foreach ($collaborators as $collaborator) {
                        Notification::make()
                        ->title('A comment was made by ' . $comment->getAuthorName())
                        ->body(strip_tags($comment->getBodyMarkdown()))
                        ->icon('heroicon-o-chat-bubble-left-ellipsis')
                        ->actions([
                            Action::make('view')
                                ->label('View Comment')
                                ->url(function () use ($comment) {
                                    $record = $comment->commentable;

                                    if ($record instanceof Task) {
                                        return TaskResource::getUrl('view', ['record' => $record]);
                                    } 
                                    
                                    if ($record instanceof Report) {
                                        return ReportResource::getUrl('view', ['record' => $record]);
                                    }
                                })
                                ->markAsRead()
                                ->close()
                        ])
                        ->sendToDatabase($collaborator);

                        event(new DatabaseNotificationsSent($collaborator));
                    }
                }
            
            });
    }
}
