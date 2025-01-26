<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'link',
        'image',
        'position',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    // دالة مساعدة للحصول على نص الموقع
    public function getPositionTextAttribute()
    {
        return [
            'header' => 'أعلى الصفحة',
            'sidebar' => 'الشريط الجانبي',
            'footer' => 'أسفل الصفحة'
        ][$this->position] ?? $this->position;
    }

    /**
     * Get the full URL for the advertisement image.
     *
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        return url('storage/' . $this->image);
    }
}
