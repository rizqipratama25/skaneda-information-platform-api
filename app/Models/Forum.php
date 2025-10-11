<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Forum extends Model
{
    protected $fillable = [
        'forum_name',
        'description',
        'status_id'
    ];

    public function status(): BelongsTo {
        return $this->belongsTo(Status::class);
    }
}
