<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Forum extends Model
{
    protected $fillable = [
        'forum_name',
        'description',
        'status_id'
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class)->whereHas('status', function ($q) {
            $q->where('status', 'Active');
        });
    }
}
