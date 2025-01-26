<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'bio',
        'image',
        'status',
        'twitter_url',
        'facebook_url',
        'instagram_url',
        'linkedin_url'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // العلاقة مع مقالات الرأي
    public function opinions()
    {
        return $this->hasMany(Opinion::class, 'author_id');
    }

    // دالة مساعدة للحصول على مسار الصورة
    public function getImagePathAttribute()
    {
        if ($this->image) {
            return url('storage/' . $this->image);
        }
        return url('images/default-author.jpg');
    }
}