<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonitoringStaffAttendance extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
    ];

    public function monitoringStaff(): BelongsTo
    {
        return $this->belongsTo(MonitoringStaff::class);
    }

    public static function statusOptions(): array
    {
        return [
            'present'               => 'Present',
            'absent'                => 'Absent',
            'absent_with_permission'=> 'Absent w/ Permission',
            'sick'                  => 'Sick',
        ];
    }
 
    public static function statusColor(string $status): string
    {
        return match ($status) {
            'present'                => 'success',
            'absent'                 => 'danger',
            'absent_with_permission' => 'warning',
            'sick'                   => 'info',
            default                  => 'gray',
        };
    }
 
    public static function statusIcon(string $status): string
    {
        return match ($status) {
            'present'                => 'heroicon-m-check-circle',
            'absent'                 => 'heroicon-m-x-circle',
            'absent_with_permission' => 'heroicon-m-clock',
            'sick'                   => 'heroicon-m-heart',
            default                  => 'heroicon-m-minus-circle',
        };
    }
}
