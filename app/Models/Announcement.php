<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title', 'content', 'image', 'is_published', 'published_at', 'posted_by',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', 1)->orderByDesc('published_at');
    }
}