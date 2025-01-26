<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class NewspaperCover extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'newspaper_name',
        'cover_image',
        'pdf_link',
        'publish_date',
        'status',
        'views'
    ];

    protected $casts = [
        'publish_date' => 'date',
        'views' => 'integer',
    ];

    // Events
    protected static function booted()
    {
        static::saved(function ($cover) {
            Cache::forget('latest_newspaper_cover');
        });

        static::deleted(function ($cover) {
            Cache::forget('latest_newspaper_cover');
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('publish_date', 'desc');
    }

    // Accessors
    public function getCoverImageUrlAttribute()
    {
        return asset($this->cover_image);
    }

    public function getFormattedPublishDateAttribute()
    {
        return $this->publish_date->format('Y-m-d');
    }

    public function getFormattedViewsAttribute()
    {
        return number_format($this->views);
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public static function getLatestCover()
    {
        return Cache::remember('latest_newspaper_cover', 60 * 24, function () {
            return static::active()->latest()->first();
        });
    }
}
