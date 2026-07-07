<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class ContactList extends Model
{
    use Userstamps, SoftDeletes;

    protected $guarded = [];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
    
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

}
