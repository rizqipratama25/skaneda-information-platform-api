<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $fillable = [
        'name',
        'open_positions',
        'position',
        'type',
        'location',
        'description',
        'registration_link',
        'status_id'
    ];
}
