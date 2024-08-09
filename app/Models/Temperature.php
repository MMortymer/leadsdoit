<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    use HasFactory;

    protected $fillable = ['city', 'temperature', 'recorded_at'];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];
}
