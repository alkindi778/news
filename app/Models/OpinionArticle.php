<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class OpinionArticle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'author_id',
        'status',
        'tags',
        'meta_description',
        'meta_keywords',
        'views'
    ];

    protected $casts = [
        'views' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // العلاقات
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('tags', 'like', "%{$search}%")
              ->orWhereHas('author', function($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              });
        });
    }

    // Events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = static::generateUniqueSlug($article->title);
            }
            if (empty($article->tags)) {
                $article->tags = static::generateTags($article->title, $article->content);
            }
        });
    }

    // Methods
    public static function generateUniqueSlug($title)
    {
        $arabic_chars = ['أ', 'إ', 'آ', 'ة', 'ي', 'ى', 'ؤ', 'ئ', 'ء', 'ع', 'ح', 'ة'];
        $latin_chars = ['a', 'e', 'a', 'h', 'y', 'a', 'o', 'e', 'a', 'a', 'h', 't'];
        $title = str_replace($arabic_chars, $latin_chars, $title);
        
        $slug = Str::slug($title);
        $count = static::where('slug', 'REGEXP', "^{$slug}(-[0-9]+)?$")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    public static function generateTags($title, $content)
    {
        $stop_words = config('app.arabic_stop_words', []);
        
        // Remove HTML and combine title and content
        $text = strip_tags($title . ' ' . $title . ' ' . $content);
        
        // Clean text
        $text = preg_replace('/[^\p{Arabic}a-zA-Z0-9\s]/u', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = mb_strtolower($text, 'UTF-8');
        
        // Split into words and count frequencies
        $words = collect(explode(' ', $text))
            ->map(fn($word) => trim($word))
            ->filter(fn($word) => mb_strlen($word, 'UTF-8') > 2 && !in_array($word, $stop_words))
            ->countBy()
            ->sortDesc()
            ->take(10)
            ->keys()
            ->implode('، ');
            
        return $words;
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    // Accessors & Mutators
    public function getFormattedViewsAttribute()
    {
        return number_format($this->views);
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function getStatusTextAttribute()
    {
        return [
            'published' => 'منشور',
            'draft' => 'مسودة',
            'pending' => 'معلق'
        ][$this->status] ?? 'معلق';
    }

    public function getStatusClassAttribute()
    {
        return [
            'published' => 'bg-green-500/10 text-green-400 border-green-500/30',
            'draft' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/30',
            'pending' => 'bg-gray-500/10 text-gray-400 border-gray-500/30'
        ][$this->status] ?? 'bg-gray-500/10 text-gray-400 border-gray-500/30';
    }
}
