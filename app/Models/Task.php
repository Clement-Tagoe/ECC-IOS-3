<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\Commentions\Contracts\Commentable;
use Kirschbaum\Commentions\HasComments;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Task extends Model implements HasMedia, Commentable
{
    use HasComments, InteractsWithMedia, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status' => TaskStatus::class,
        'priority' => TaskPriority::class,
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function collaborators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_collaborator', 'task_id', 'user_id'); // ->where('users.id', '!=', Auth::user()->id)
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
