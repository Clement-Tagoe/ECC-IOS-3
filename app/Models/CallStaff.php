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

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function callStaffAttendances(): HasMany
    {
        return $this->hasMany(CallStaffAttendance::class);
    }

    public function attendanceForDate(string $date): ?Attendance
    {
        return $this->attendances->firstWhere('date', $date);
    }

    // Convenience methods for summaries
    public function presentCountForMonth(int $month, int $year): int
    {
        return $this->attendances()
                    ->forMonth($month, $year)
                    ->present()
                    ->count();
    }

    public function absentCountForMonth(int $month, int $year): int
    {
        return $this->attendances()
                    ->forMonth($month, $year)
                    ->absent()
                    ->count();
    }
}
