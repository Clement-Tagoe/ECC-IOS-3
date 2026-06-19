<?php

namespace App\Models;

use App\Enums\ValidCaseStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Mattiverse\Userstamps\Traits\Userstamps;

class ValidCase extends Model
{
    use Userstamps, SoftDeletes;
    
    protected $guarded = [];

    protected $casts = [
        'status' => ValidCaseStatus::class,
    ];
    
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function validCaseNature(): BelongsTo
    {
        return $this->belongsTo(ValidCaseNature::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function setAgencyArrivalTimeAttribute($value)
    {
        $this->attributes['agency_arrival_time'] = $value;

        // Calculate agency response time when both dispactched time and agency arrival time are present
        if ($this->dispatched_time && $value) {
            $dispatched_time = Carbon::parse($this->dispatched_time);
            $arrivalTime = Carbon::parse($value);
            $this->attributes['agency_response_time'] = $dispatched_time->diff($arrivalTime)->format('%H:%I:%S'); // HH:MM:SS
            // Or for hours: $this->attributes['agency_response_time'] = $timeIn->diffInHours($timeOut, true);
        } else {
            $this->attributes['agency_response_time'] = null; // Clear agency response time if agency arrival time is unset
        }
    }
}
