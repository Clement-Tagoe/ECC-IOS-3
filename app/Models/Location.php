<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Location extends Model
{
    use Userstamps, SoftDeletes;
    
    protected $guarded = [];

    protected static array $blockingRelations = [
        'validCases',
        'monitoringTasks',
        'contactLists',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Location $location) {
            $blockers = collect(static::$blockingRelations)
                ->filter(fn ($relation) => $location->{$relation}()->exists())
                ->all();

            if (! empty($blockers)) {
                Notification::make()
                    ->title('Cannot delete location')
                    ->body('This location still has related: ' . implode(', ', $blockers) . '.')
                    ->danger()
                    ->send();

                return false; // halts the delete (soft or force)
            }
        });
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function validCases(): HasMany
    {
        return $this->hasMany(ValidCase::class);
    }

    public function monitoringTasks(): HasMany
    {
        return $this->hasMany(MonitoringTask::class);
    }

    public function contactLists(): HasMany
    {
        return $this->hasMany(contactList::class);
    }

}
