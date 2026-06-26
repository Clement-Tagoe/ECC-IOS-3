<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Illuminate\Database\Eloquent\Builder;

class Attendance extends Model
{
    use Userstamps, SoftDeletes;

    protected $guarded = [];

    public function callStaff(): BelongsTo
    {
        return $this->belongsTo(CallStaff::class);
    }

    // ─── Scopes ──────────────────────────────────────────────

    public function scopePresent(Builder $query): Builder
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsent(Builder $query): Builder
    {
        return $query->where('status', 'absent');
    }

    public function scopeForMonth(Builder $query, int $month, int $year): Builder
    {
        return $query->whereMonth('date', $month)
                     ->whereYear('date', $year);
    }

    public function scopeForDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('date', $date);
    }
}
