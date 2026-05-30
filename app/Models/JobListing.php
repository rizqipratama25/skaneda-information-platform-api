<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobListing extends Model
{
    protected $fillable = [
        'name',
        'open_positions',
        'position',
        'type_id',
        'location',
        'description',
        'registration_link',
        'status_id'
    ];

    public function type(): BelongsTo {
        return $this->belongsTo(JobType::class);
    }
}
