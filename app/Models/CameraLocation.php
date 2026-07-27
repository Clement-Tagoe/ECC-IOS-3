<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class CameraLocation extends Model
{
    use Userstamps, SoftDeletes;
    
    protected $guarded = [];

    protected static array $blockingRelations = [
        'cameraAudits',
    ];

    protected static function booted(): void
    {
        static::deleting(function (CameraLocation $cameraLocation) {
            $blockers = collect(static::$blockingRelations)
                ->filter(fn ($relation) => $cameraLocation->{$relation}()->exists())
                ->all();

            if (! empty($blockers)) {
                Notification::make()
                    ->title('Cannot delete camera location')
                    ->body('This camera location still has related: ' . implode(', ', $blockers) . '.')
                    ->danger()
                    ->send();

                return false;
            }
        });
    }

    public function cameraAudits(): HasMany
    {
        return $this->hasMany(CameraAudit::class);
    }
}
