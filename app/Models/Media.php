<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_name',
        'type',
        'size',
        'mime_type',
        'status',
        'disk',
        'model_type',
        'model_id',
        'collection_name',
        'name',
        'manipulations',
        'custom_properties',
        'generated_conversions',
        'responsive_images',
        'category_id'
    ];

    protected $casts = [
        'manipulations' => 'array',
        'custom_properties' => 'array',
        'generated_conversions' => 'array',
        'responsive_images' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($media) {
            try {
                $filePath = 'media/' . $media->file_name;
                $publicPath = public_path('storage/media/' . $media->file_name);
                $storagePath = storage_path('app/public/media/' . $media->file_name);

                // حذف الملف من المجلد العام
                if (file_exists($publicPath)) {
                    @chmod($publicPath, 0777);
                    @unlink($publicPath);
                }

                // حذف الملف من مجلد التخزين
                if (file_exists($storagePath)) {
                    @chmod($storagePath, 0777);
                    @unlink($storagePath);
                }

                // حذف باستخدام Storage Facade
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                return true;
            } catch (\Exception $e) {
                \Log::error('خطأ في حذف الملف: ' . $e->getMessage());
                return false;
            }
        });
    }

    public function getFileUrlAttribute()
    {
        return asset('storage/media/' . $this->file_name);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
