<?php

namespace App\Models;

use App\Enums\LogisticsUnit;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class LogisticsManagement extends Model
{
    use Userstamps, SoftDeletes;

    protected $guarded = [];

    protected $table = 'logistics_management';

    protected $casts = [
        'unit' => LogisticsUnit::class,
    ];

    public function logisticsDistribution(): HasMany
    {
        return $this->hasMany(LogisticsDistribution::class);
    }

        public function remainingStock(): Attribute
    {
        return Attribute::make(
            get: fn () => max(0, $this->quantity - $this->logisticsDistribution->sum('quantity')),
        );
    }

    public function quantityWithUnit(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->unit
                ? "{$this->quantity} {$this->unit->value}"
                : (string) $this->quantity,
        );
    }

    public function remainingStockWithUnit(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->unit
                ? "{$this->remaining_stock} {$this->unit->value}"
                : (string) $this->remaining_stock,
        );
    }

    public function stockPercentage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quantity > 0
                ? round(($this->remaining_stock / $this->quantity) * 100, 1)
                : 0,
        );
    }
}
