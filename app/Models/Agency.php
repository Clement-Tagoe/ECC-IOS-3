<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Agency extends Model
{
    use Userstamps, SoftDeletes;
    
    protected $guarded = [];

    protected static array $blockingRelations = [
        'validCases',
        'contactLists',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Agency $agency) {
            $blockers = collect(static::$blockingRelations)
                ->filter(fn ($relation) => $agency->{$relation}()->exists())
                ->all();

            if (! empty($blockers)) {
                Notification::make()
                    ->title('Cannot delete agency')
                    ->body('This agency still has related: ' . implode(', ', $blockers) . '.')
                    ->danger()
                    ->send();

                return false;
            }
        });
    }

    public function validCases(): HasMany
    {
        return $this->hasMany(ValidCase::class);
    }

    public function contactLists(): HasMany
    {
        return $this->hasMany(ContactList::class);
    }
}
