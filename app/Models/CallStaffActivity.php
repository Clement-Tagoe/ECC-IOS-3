<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class CallStaffActivity extends Model
{
    use Userstamps, SoftDeletes;

    protected $guarded = [];
    
    public function callStaff(): BelongsTo
    {
        return $this->belongsTo(CallStaff::class);
    }
}
