<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'tweet_id',
        'user_id',
        'user_title',
        'user_name',
        'text',
        'publish_at',
    ];
}
