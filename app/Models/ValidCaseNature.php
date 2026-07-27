<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class ValidCaseNature extends Model
{
    use Userstamps, SoftDeletes;

    protected $guarded = [];

    protected static array $blockingRelations = [
        'validCase',
    ];

    protected static function booted(): void
    {
        static::deleting(function (ValidCaseNature $validCaseNature) {
            $blockers = collect(static::$blockingRelations)
                ->filter(fn ($relation) => $validCaseNature->{$relation}()->exists())
                ->all();

            if (! empty($blockers)) {
                Notification::make()
                    ->title('Cannot delete valid case nature')
                    ->body('This valid case nature still has related: ' . implode(', ', $blockers) . '.')
                    ->danger()
                    ->send();

                return false;
            }
        });
    }

    public function validCase(): HasMany
    {
        return $this->hasMany(ValidCase::class);
    }
}
