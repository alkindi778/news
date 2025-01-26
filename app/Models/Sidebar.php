<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sidebar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'type',
        'category_id',
        'ad_id',
        'posts_count',
        'layout_type',
        'image',
        'link',
        'order',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'posts_count' => 'integer'
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        return url('storage/' . $this->image);
    }
}
