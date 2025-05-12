<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;
    protected $guarded = [ ];
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'comment_on');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
