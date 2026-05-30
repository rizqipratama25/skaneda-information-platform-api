<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Extracurricular extends Model
{
    protected $fillable = [
        'name',
        'image',
        'status_id'
    ];

    public function status(): BelongsTo {
        return $this->belongsTo(Status::class);
    }
}
