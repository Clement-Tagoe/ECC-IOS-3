<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class ReportType extends Model
{
    use Userstamps, SoftDeletes;

    protected $guarded = [];

    protected static array $blockingRelations = [
        'reports',
    ];

    protected static function booted(): void
    {
        static::deleting(function (ReportType $reportType) {
            $blockers = collect(static::$blockingRelations)
                ->filter(fn ($relation) => $reportType->{$relation}()->exists())
                ->all();

            if (! empty($blockers)) {
                Notification::make()
                    ->title('Cannot delete report type')
                    ->body('This report type still has related: ' . implode(', ', $blockers) . '.')
                    ->danger()
                    ->send();

                return false;
            }
        });
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
