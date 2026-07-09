<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class AgentActivity extends Model
{
    use Userstamps, SoftDeletes;

    protected $guarded = [];
    
    protected $table = 'agent_activities';

    public function callLog(): BelongsTo
    {
        return $this->belongsTo(CallLog::class);
    }

    public function callStaff(): BelongsTo
    {
        return $this->belongsTo(CallStaff::class);
    }


}
