<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityImage extends Model
{
    protected $fillable = [
        'image',
        'facility_id'
    ];

    public function facility(): BelongsTo {
        return $this->belongsTo(Facility::class);
    }
}
