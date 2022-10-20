<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwitterToken extends Model
{
    use HasFactory;

    protected $casts = [
        'stream_params' => 'array'
    ];

    protected $fillable = [
        'updated_at',
        'pid'
    ];
}
