<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;


class Topic extends Model
{
    use Userstamps, SoftDeletes;
    
    protected $guarded = [];

    protected static array $blockingRelations = [
        'monitoringTasks',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Topic $topic) {
            $blockers = collect(static::$blockingRelations)
                ->filter(fn ($relation) => $topic->{$relation}()->exists())
                ->all();

            if (! empty($blockers)) {
                Notification::make()
                    ->title('Cannot delete topic')
                    ->body('This topic still has related: ' . implode(', ', $blockers) . '.')
                    ->danger()
                    ->send();

                return false;
            }
        });
    }

    public function monitoringTasks(): BelongsToMany
    {
        return $this->belongsToMany(MonitoringTask::class, 'monitoring_topics', 'topic_id', 'monitoring_task_id');
    }

}
