<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Opinion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'author_id',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($opinion) {
            if (!$opinion->slug) {
                $opinion->slug = Str::slug($opinion->title);
            }
        });

        static::updating(function ($opinion) {
            if ($opinion->isDirty('title') && !$opinion->isDirty('slug')) {
                $opinion->slug = Str::slug($opinion->title);
            }
        });
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
