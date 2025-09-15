<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserStatus extends Model
{
    protected $fillable = ['name'];

    protected $table = 'user_statuses';
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'status_id');
    }
}
