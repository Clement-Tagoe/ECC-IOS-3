<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class MonitoringStaff extends Model
{
    use Userstamps, SoftDeletes;
    
    protected $guarded = [];

    protected $table = 'monitoring_staffs';

    public function group(): BelongsTo
    {
        return $this->belongsTo(MonitoringStaffGroup::class, 'monitoring_staff_group_id');
    }

    public function monitoringStaffAttendances(): HasMany
    {
        return $this->hasMany(MonitoringStaffAttendance::class);
    }

}
