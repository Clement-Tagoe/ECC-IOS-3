<?php

namespace App\Models;

use App\Filament\Resources\CameraAudits\CameraAuditResource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Region extends Model
{
    use Userstamps, SoftDeletes;
     
    protected $guarded = [];

    protected static array $blockingRelations = [
        'locations',
        'validCases',
        'monitoringTasks',
        'cameraAudits',
        'contactLists',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Region $region) {
            $blockers = collect(static::$blockingRelations)
                ->filter(fn ($relation) => $region->{$relation}()->exists())
                ->all();

            if (! empty($blockers)) {
                Notification::make()
                    ->title('Cannot delete region')
                    ->body('This region still has related: ' . implode(', ', $blockers) . '.')
                    ->danger()
                    ->send();

                return false; // halts the delete
            }
        });
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function validCases(): HasMany
    {
        return $this->hasMany(ValidCase::class);
    }

    public function monitoringTasks(): HasMany
    {
        return $this->hasMany(MonitoringTask::class);
    }

    public function cameraAudits(): HasMany
    {
        return $this->hasMany(CameraAudit::class);
    }

    public function contactLists(): HasMany
    {
        return $this->hasMany(ContactList::class);
    }
}
