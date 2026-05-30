<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    protected $fillable = [
        'chat',
        'user_id',
        'forum_id',
        'status_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            if (Auth::check()) {
                $data->user_id = Auth::id();
            }
        });

    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo {
        return $this->belongsTo(Status::class);
    }

    public function forum(): BelongsTo {
        return $this->belongsTo(Forum::class);
    }

    
}
