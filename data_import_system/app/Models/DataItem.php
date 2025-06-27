<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataItem extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'dob',
        'registered_at',
        'is_active',
        'balance',
        'parent_id',
    ];
}
