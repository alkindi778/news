<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'order' => 'integer'
    ];

    protected $appends = ['status'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'category_news');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order');
    }

    public function getNewsCountAttribute()
    {
        return $this->news()->count();
    }

    public function getStatusAttribute()
    {
        return !$this->deleted_at ? 'مفعل' : 'غير مفعل';
    }
}
