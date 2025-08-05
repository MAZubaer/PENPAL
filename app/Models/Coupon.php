<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'active', 'expires_at'
    ];
    protected $casts = [
        'active' => 'boolean',
        'expires_at' => 'datetime',
    ];
}
