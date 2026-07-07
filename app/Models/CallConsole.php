<?php

namespace App\Models;

use App\Enums\ConsoleStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class CallConsole extends Model
{
    use Userstamps, SoftDeletes;
    
    protected $guarded = [];

    protected $casts = [
        'status' => ConsoleStatus::class,
    ];

    public function assignee():BelongsTo
    {
        return $this->belongsTo(CallStaff::class, 'call_staff_id');
    }

}
