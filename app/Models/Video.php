<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'status',
        'path',
        'length',
        'transcription',
        'summary',
        'trim_from',
        'trim_to',
    ];

    /**
     * Get the user that owns the video.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
