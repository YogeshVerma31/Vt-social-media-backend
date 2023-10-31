<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistVideo extends Model
{
    use HasFactory;

    public function videos()
    {
        return $this->hasOne(Video::class, 'id','video_id');
    }
}
