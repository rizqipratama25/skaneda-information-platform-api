<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Agenda extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'dateTime',
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

        static::deleting(function ($agenda) {
            if (Auth::check()) {
                $agenda->updateQuietly(['deleted_by' => Auth::id()]);
            }
        });

        static::creating(function ($agenda) {
            if (Auth::check()) {
                $agenda->created_by = Auth::id();
                $agenda->updated_by = Auth::id();
            }
        });

        static::updating(function ($agenda) {
            if (Auth::check()) {
                $agenda->updated_by = Auth::id();
            }
        });
    }
}
