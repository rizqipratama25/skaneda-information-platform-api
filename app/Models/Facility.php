<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'status_id'
    ];

    public function status(): BelongsTo {
        return $this->belongsTo(Status::class);
    }

    public function images(): HasMany {
        return $this->hasMany(FacilityImage::class);
    }
}
