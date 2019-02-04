<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'posts_collection';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'v',
        'live_chat_id',
        'published_at',
        'message',
        'autor_channel_id',
        'autor_channel_url',
        'autor_display_name',
        'autor_profile_image_url',
    ];
}
