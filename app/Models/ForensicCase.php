<?php

namespace App\Models;

use App\Enums\ForensicCaseReviewStatus;
use App\Enums\ForensicCaseStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\Commentions\Contracts\Commentable;
use Kirschbaum\Commentions\HasComments;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ForensicCase extends Model implements HasMedia, Commentable
{
    use SoftDeletes, InteractsWithMedia, HasComments;

    protected $guarded = [];

    protected $casts = [
        'status' => ForensicCaseStatus::class,
        'review_status' => ForensicCaseReviewStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'forensic_case_collaborator', 'forensic_case_id', 'user_id');
    }

    public function receivers()
    {
        return $this->belongsToMany(User::class, 'forensic_case_user', 'forensic_case_id', 'user_id');
    }

}
