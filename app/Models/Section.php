<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Section extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'template',
        'style',
        'category_id',
        'content',
        'items_count',
        'order',
        'is_active',
        'show_title'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_title' => 'boolean',
        'style' => 'array',
        'order' => 'integer',
        'items_count' => 'integer'
    ];

    public static $templates = [
        'grid' => 'شبكة عادية',
        'featured' => 'مميز',
        'featured_with_list' => 'مميز مع قائمة',
        'fullwidth' => 'عرض كامل',
        'masonry' => 'شبكة متداخلة',
        'news_grid' => 'شبكة أخبار',
        'infographic' => 'انفوجرافيك',
        'videos' => 'فيديوهات'
    ];

    /**
     * العلاقة مع التصنيف
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * الحصول على محتوى القسم حسب نوعه
     */
    public function getContent()
    {
        switch ($this->type) {
            case 'category':
                return News::whereHas('categories', function ($query) {
                    $query->where('categories.id', $this->category_id);
                })
                ->published()
                ->latest()
                ->take($this->items_count)
                ->get();

            case 'popular':
                return News::published()
                    ->orderBy('views_count', 'desc')
                    ->take($this->items_count)
                    ->get();

            case 'latest':
                return News::published()
                    ->latest()
                    ->take($this->items_count)
                    ->get();

            case 'featured':
                return News::published()
                    ->where('is_featured', true)
                    ->latest()
                    ->take($this->items_count)
                    ->get();

            case 'videos':
                return Video::latest()
                    ->take($this->items_count)
                    ->get();

            case 'custom':
                return $this->content;

            default:
                if (Str::startsWith($this->type, 'category_')) {
                    $categoryId = substr($this->type, 9);
                    return News::whereHas('categories', function ($query) use ($categoryId) {
                        $query->where('categories.id', $categoryId);
                    })
                    ->published()
                    ->latest()
                    ->take($this->items_count)
                    ->get();
                }
                return null;
        }
    }

    /**
     * الحصول على نص نوع القسم
     */
    public function getTypeText()
    {
        switch ($this->type) {
            case 'latest':
                return 'آخر الأخبار';
            case 'popular':
                return 'الأكثر قراءة';
            case 'featured':
                return 'الأخبار المميزة';
            case 'custom':
                return 'محتوى مخصص';
            case 'videos':
                return 'قسم الفيديوهات';
            default:
                if (Str::startsWith($this->type, 'category_')) {
                    $categoryId = substr($this->type, 9);
                    $category = Category::find($categoryId);
                    return $category ? $category->name : 'تصنيف محذوف';
                }
                return $this->type;
        }
    }

    /**
     * الحصول على اسم القالب
     */
    public function getTemplateNameAttribute()
    {
        return static::$templates[$this->template] ?? $this->template;
    }

    /**
     * إعادة ترتيب الأقسام
     */
    public static function reorder(array $ids): bool
    {
        try {
            foreach ($ids as $index => $id) {
                static::where('id', $id)->update(['order' => $index + 1]);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
