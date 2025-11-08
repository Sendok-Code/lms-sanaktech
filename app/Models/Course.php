<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'category_id',
        'instructor_id',
        'is_published',
        'published',
        'thumbnail',
        'preview_video_url',
        'resource_file',
        'resource_file_name',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('sort_order');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Calculate average progress percentage for this course
     * Progress = (completed videos / total videos) per student, averaged
     */
    public function getAverageProgressAttribute()
    {
        $totalVideos = $this->videos()->count();

        if ($totalVideos === 0 || $this->enrollments_count === 0) {
            return 0;
        }

        $totalCompletedVideos = \App\Models\Progress::whereHas('enrollment', function($query) {
                $query->where('course_id', $this->id);
            })
            ->where('completed', true)
            ->count();

        $totalPossibleProgress = $this->enrollments_count * $totalVideos;

        return $totalPossibleProgress > 0
            ? round(($totalCompletedVideos / $totalPossibleProgress) * 100)
            : 0;
    }

    /**
     * Get YouTube embed URL from preview_video_url
     * Supports formats:
     * - https://www.youtube.com/watch?v=VIDEO_ID
     * - https://youtu.be/VIDEO_ID
     * - https://www.youtube.com/embed/VIDEO_ID
     */
    public function getYoutubeEmbedUrlAttribute()
    {
        if (empty($this->preview_video_url)) {
            return null;
        }

        $url = $this->preview_video_url;

        // Extract video ID from different YouTube URL formats
        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
            return 'https://www.youtube.com/embed/' . $id[1];
        } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
            return 'https://www.youtube.com/embed/' . $id[1];
        } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
            return 'https://www.youtube.com/embed/' . $id[1];
        }

        return null;
    }
}
