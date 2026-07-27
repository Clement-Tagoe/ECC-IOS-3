<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Observation extends Model
{
    use Userstamps, SoftDeletes;

    protected $guarded = [];

    protected static array $blockingRelations = [
        'cameraAudits',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Observation $observation) {
            $blockers = collect(static::$blockingRelations)
                ->filter(fn ($relation) => $observation->{$relation}()->exists())
                ->all();

            if (! empty($blockers)) {
                Notification::make()
                    ->title('Cannot delete observation')
                    ->body('This observation still has related: ' . implode(', ', $blockers) . '.')
                    ->danger()
                    ->send();

                return false;
            }
        });
    }

    public function cameraAudits(): BelongsToMany
    {
        return $this->belongsToMany(CameraAudit::class, 'camera_observations', 'observation_id', 'camera_audit_id');
    }

}
