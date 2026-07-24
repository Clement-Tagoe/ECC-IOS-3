<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class CameraLocation extends Model
{
    use Userstamps, SoftDeletes;
    
    protected $guarded = [];

    public function cameraAudits(): HasMany
    {
        return $this->hasMany(CameraAudit::class);
    }
}
