<?php

namespace App\Models;

use App\Enums\ForensicReportReviewStatus;
use App\Enums\ForensicReportStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\Commentions\Contracts\Commentable;
use Kirschbaum\Commentions\HasComments;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ForensicReport extends Model implements HasMedia, Commentable
{
    use Userstamps, SoftDeletes, InteractsWithMedia, HasComments;

    protected $guarded = [];

    protected $casts = [
        'status' => ForensicReportStatus::class,
        'review_status' => ForensicReportReviewStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'forensic_report_collaborator', 'forensic_report_id', 'user_id');
    }

    public function receivers()
    {
        return $this->belongsToMany(User::class, 'forensic_report_user', 'forensic_report_id', 'user_id');
    }

}
