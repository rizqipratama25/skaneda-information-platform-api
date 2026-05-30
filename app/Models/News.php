<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class News extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'contents',
        'image',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function createdBy() : BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy() : BelongsTo {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy() : BelongsTo {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($news) {
            if (Auth::check()) {
                $news->updateQuietly(['deleted_by' => Auth::id()]);
            }
        });

        static::creating(function ($news) {
            if (Auth::check()) {
                $news->created_by = Auth::id();
                $news->updated_by = Auth::id();
            }
        });

        static::updating(function ($news) {
            if (Auth::check()) {
                $news->updated_by = Auth::id();
            }
        });
    }
}
