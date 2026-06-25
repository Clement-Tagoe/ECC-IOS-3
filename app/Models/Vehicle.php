<?php

namespace App\Models;

use App\Enums\VehicleAvailability;
use App\Enums\VehicleCategory;
use App\Enums\VehicleStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Vehicle extends Model
{
    use Userstamps, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status' => VehicleStatus::class,
        'category' => VehicleCategory::class,
        'availability' => VehicleAvailability::class,
    ];

    // Is the vehicle overdue for service?
    public function isServiceOverdue(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->next_service_date
                ? Carbon::parse($this->next_service_date)->isPast()
                : false,
        );
    }

    // Days until next service (negative if overdue)
    public function daysUntilService(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->next_service_date
                ? (int) now()->diffInDays(Carbon::parse($this->next_service_date), false)
                : null,
        );
    }

    // Human readable service status
    public function serviceStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->next_service_date) return 'No service date set';

                $days = $this->days_until_service;

                return match(true) {
                    $days < 0  => abs($days) . ' days overdue',
                    $days === 0 => 'Due today',
                    $days <= 7  => "Due in {$days} days",
                    $days <= 30 => "Due in {$days} days",
                    default     => 'Up to date',
                };
            }
        );
    }

    // Mileage formatted with commas e.g. 12,500 km
    public function formattedMileage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->mileage
                ? number_format($this->mileage) . ' km'
                : 'N/A',
        );
    }
}
