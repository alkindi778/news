<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Section;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'video_url',
        'thumbnail_url',
        'status',
        'section_id'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the section that owns the video
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * استخراج معرف فيديو YouTube من الرابط
     */
    public function getYoutubeVideoId()
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        if (preg_match($pattern, $this->video_url, $match)) {
            return $match[1];
        }
        return null;
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        if (preg_match($pattern, $this->video_url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        return $this->video_url;
    }

    public function generateThumbnail()
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        if (preg_match($pattern, $this->video_url, $matches)) {
            $this->thumbnail_url = "https://img.youtube.com/vi/{$matches[1]}/maxresdefault.jpg";
            $this->save();
        }
    }

    public function getThumbnailUrl()
    {
        if ($this->thumbnail_url) {
            return $this->thumbnail_url;
        }

        $videoId = $this->getYoutubeVideoId();
        return $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : null;
    }

    public function getVideoUrl()
    {
        return $this->video_url;
    }
}
