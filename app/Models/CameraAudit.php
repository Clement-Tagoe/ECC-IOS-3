<?php

namespace App\Models;

use App\Enums\CameraStatus;
use App\Observers\CameraAuditObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Mattiverse\Userstamps\Traits\Userstamps;

#[ObservedBy([CameraAuditObserver::class])]
class CameraAudit extends Model
{
    use Userstamps, SoftDeletes;

    public const NAV_BADGE_CACHE_KEY = 'cameraAudits.count';

    protected $casts = [
        'status' => CameraStatus::class,
    ];

    public static function cachedCount(): int
    {
        return Cache::remember(
            self::NAV_BADGE_CACHE_KEY,
            now()->addMinutes(60),
            fn (): int => self::count(),
        );
    }

    protected $guarded = [];
    
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function observations():BelongsToMany
    {
        return $this->belongsToMany(Observation::class, 'camera_observations', 'camera_audit_id', 'observation_id');
    }

    public function cameraLocation(): BelongsTo
    {
        return $this->belongsTo(CameraLocation::class, 'camera_location_id');
    }
}
