<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SidebarSection extends Model
{
    protected $fillable = [
        'title',
        'type',
        'category_id',
        'ad_id',
        'content',
        'posts_count',
        'order_num',
        'is_visible'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'posts_count' => 'integer',
        'order_num' => 'integer'
    ];

    /**
     * العلاقة مع التصنيف
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * العلاقة مع الإعلان
     */
    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * الحصول على محتوى القسم حسب نوعه
     */
    public function getContent()
    {
        switch ($this->type) {
            case 'category':
                return Post::whereHas('categories', function ($query) {
                    $query->where('categories.id', $this->category_id);
                })
                ->latest()
                ->take($this->posts_count)
                ->get();

            case 'popular':
                return Post::orderBy('views', 'desc')
                    ->take($this->posts_count)
                    ->get();

            case 'latest':
                return Post::latest()
                    ->take($this->posts_count)
                    ->get();

            case 'ads':
                return $this->ad;

            case 'custom':
                return $this->content;

            default:
                return null;
        }
    }

    /**
     * الحصول على نص نوع القسم
     */
    public function getTypeText(): string
    {
        return match($this->type) {
            'category' => 'تصنيف',
            'popular' => 'الأكثر قراءة',
            'latest' => 'آخر الأخبار',
            'ads' => 'إعلان',
            'custom' => 'محتوى مخصص',
            default => $this->type
        };
    }

    /**
     * إعادة ترتيب الأقسام
     */
    public static function reorder(array $ids): bool
    {
        try {
            foreach ($ids as $index => $id) {
                static::where('id', $id)->update(['order_num' => $index + 1]);
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('Error reordering sidebar sections: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * الحصول على الأقسام المرئية مرتبة
     */
    public static function getVisibleSections()
    {
        return static::where('is_visible', true)
            ->orderBy('order_num')
            ->get();
    }
}
