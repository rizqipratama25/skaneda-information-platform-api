<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Achievements extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'image',
        'description',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    
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
