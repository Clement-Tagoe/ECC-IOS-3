<?php

namespace App\Providers;

use App\Models\ForensicCase;
use App\Models\ForensicReport;
use App\Models\Report;
use App\Models\Task;
use App\Observers\MessageObserver;
use App\Traits\SendsCommentNotifications;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Kirschbaum\Commentions\Events\CommentWasCreatedEvent;
use Kirschbaum\Commentions\Events\UserWasMentionedEvent;
use Wirechat\Wirechat\Models\Message;


class AppServiceProvider extends ServiceProvider
{
    use SendsCommentNotifications;
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

        Event::listen(function (UserWasMentionedEvent $event) {
           
            $this->sendCommentNotification(
                comment: $event->comment,
                recipients: collect([$event->user]),
                title: 'You were mentioned in a comment by ' . $event->comment->getAuthorName(),
            );
            
        });

        Event::listen(function (CommentWasCreatedEvent $event) {

            $comment = $event->comment;
            $record  = $comment->commentable;

            $involved = match (true) {
                $record instanceof Task   => collect([$record->user])->merge($record->collaborators),
                $record instanceof Report => collect([$record->user])->merge($record->receivers),
                $record instanceof ForensicCase   => collect([$record->user])->merge($record->receivers),
                $record instanceof ForensicReport => collect([$record->user])->merge($record->receivers),
                default                   => collect(),
            };

            if ($involved->isEmpty()) {
                return;
            }

            $mentionedIds = $comment->getMentioned()->pluck('id');

            $recipients = $involved
                ->filter(fn ($u) => $u !== null)
                ->unique('id')
                ->reject(fn ($u) => $u->id === $comment->author_id)
                ->reject(fn ($u) => $mentionedIds->contains($u->id));

            $this->sendCommentNotification(
                comment: $comment,
                recipients: $recipients,
                title: 'A comment was made by ' . $comment->getAuthorName(),
            );
        });
    }
}
