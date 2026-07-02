<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class CallStaff extends Model
{
    use Userstamps, SoftDeletes;
    
    protected $guarded = [];

    protected $table = 'call_staffs';

    public function group(): BelongsTo
    {
        return $this->belongsTo(CallStaffGroup::class, 'call_staff_group_id');
    }

    public function callStaffAttendances(): HasMany
    {
        return $this->hasMany(CallStaffAttendance::class);
    }

    public function callStaffActivities(): HasMany
    {
        return $this->hasMany(CallStaffActivity::class);
    }


}
