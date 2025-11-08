<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $fillable = [
        'enrollment_id',
        'video_id',
        'completed',
        'watched_seconds',
        'watched_at',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'watched_at' => 'datetime',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
