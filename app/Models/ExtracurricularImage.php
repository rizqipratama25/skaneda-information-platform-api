<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExtracurricularImage extends Model
{
    protected $fillable = [
        'image',
        'extracurricular_id'
    ];

    public function extracurricular(): BelongsTo {
        return $this->belongsTo(Extracurricular::class);
    }
} 
