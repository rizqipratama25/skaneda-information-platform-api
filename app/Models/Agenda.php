<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'name',
        'dateTime',
        'made_by',
        'updated_by'
    ];
}
