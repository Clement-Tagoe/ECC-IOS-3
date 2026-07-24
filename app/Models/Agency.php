<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Agency extends Model
{
    use Userstamps, SoftDeletes;
    
    protected $guarded = [];

    public function ValidCases(): HasMany
    {
        return $this->hasMany(ValidCase::class);
    }
}
