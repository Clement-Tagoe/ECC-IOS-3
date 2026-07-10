<?php

namespace App\Observers;

use App\Models\CameraAudit;
use Illuminate\Support\Facades\Cache;

class CameraAuditObserver
{
    /**
     * Handle the CameraAudit "created" event.
     */
    public function created(CameraAudit $cameraAudit): void
    {
        Cache::forget(CameraAudit::NAV_BADGE_CACHE_KEY);
    }

    /**
     * Handle the CameraAudit "updated" event.
     */
    public function updated(CameraAudit $cameraAudit): void
    {
        Cache::forget(CameraAudit::NAV_BADGE_CACHE_KEY);
    }

    /**
     * Handle the CameraAudit "deleted" event.
     */
    public function deleted(CameraAudit $cameraAudit): void
    {
        Cache::forget(CameraAudit::NAV_BADGE_CACHE_KEY);
    }

    /**
     * Handle the CameraAudit "restored" event.
     */
    public function restored(CameraAudit $cameraAudit): void
    {
        Cache::forget(CameraAudit::NAV_BADGE_CACHE_KEY);
    }

    /**
     * Handle the CameraAudit "force deleted" event.
     */
    public function forceDeleted(CameraAudit $cameraAudit): void
    {
        Cache::forget(CameraAudit::NAV_BADGE_CACHE_KEY);
    }
}
