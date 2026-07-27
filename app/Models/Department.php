<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Department extends Model
{
    use HasFactory, Userstamps, SoftDeletes;
    
    protected $fillable = ['name'];

    protected static array $blockingRelations = [
        'users',
        'reports',
        'visitors',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Department $department) {
            $blockers = collect(static::$blockingRelations)
                ->filter(fn ($relation) => $department->{$relation}()->exists())
                ->all();

            if (! empty($blockers)) {
                Notification::make()
                    ->title('Cannot delete department')
                    ->body('This department still has related: ' . implode(', ', $blockers) . '.')
                    ->danger()
                    ->send();

                return false;
            }
        });
    }
    
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(Visitor::class);
    }
}
