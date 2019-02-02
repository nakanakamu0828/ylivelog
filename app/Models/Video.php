<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'v', 'title',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
