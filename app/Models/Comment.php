<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'news_id',
        'name',
        'email',
        'content',
        'approved',
        'is_visible',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'approved' => 'integer',
        'is_visible' => 'boolean',
    ];

    // العلاقة مع المحتوى (مقال أو خبر)
    public function commentable()
    {
        return $this->morphTo();
    }

    // العلاقة مع الأخبار
    public function news()
    {
        return $this->belongsTo(News::class);
    }

    // نطاقات البحث
    public function scopeApproved($query)
    {
        return $query->where('approved', 1);
    }

    public function scopePending($query)
    {
        return $query->where('approved', 0);
    }

    public function scopeRejected($query)
    {
        return $query->where('approved', -1);
    }

    public function scopeSpam($query)
    {
        return $query->where('approved', -2);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    // الخصائص المحسوبة
    public function getStatusTextAttribute()
    {
        return match($this->approved) {
            1 => 'موافق عليه',
            0 => 'قيد المراجعة',
            -1 => 'مرفوض',
            -2 => 'سبام',
            default => 'غير معروف'
        };
    }

    public function getStatusClassAttribute()
    {
        return match($this->approved) {
            1 => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            0 => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            -1 => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            -2 => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
        };
    }

    // دوال مساعدة
    public function approve()
    {
        $this->update(['approved' => 1]);
    }

    public function reject()
    {
        $this->update(['approved' => -1]);
    }

    public function markAsSpam()
    {
        $this->update(['approved' => -2]);
    }

    public function toggleVisibility()
    {
        $this->update(['is_visible' => !$this->is_visible]);
    }
}
