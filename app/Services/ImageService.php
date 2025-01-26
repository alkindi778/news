<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ImageService
{
    protected $manager;
    protected const MAX_FILE_SIZE = 500 * 1024; // 500KB in bytes
    protected const MIN_QUALITY = 60; // Minimum acceptable quality
    protected const INITIAL_SCALE = 100; // Start with full size
    protected const MAX_WIDTH = 1200; // Maximum width for any image
    protected const MAX_HEIGHT = 800; // Maximum height for any image

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Convert image to WebP format and optimize while maintaining quality
     */
    public function saveOriginalImage(UploadedFile $image, string $path): string
    {
        try {
            // Create intervention image instance
            $img = $this->manager->read($image);

            // Generate unique filename for WebP
            $filename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $webpFilename = $filename . '_' . time() . '.webp';
            $fullPath = $path . '/' . $webpFilename;

            // Get original dimensions
            $originalWidth = $img->width();
            $originalHeight = $img->height();
            
            // Calculate target dimensions while maintaining aspect ratio
            $ratio = min(
                self::MAX_WIDTH / $originalWidth,
                self::MAX_HEIGHT / $originalHeight,
                1
            );
            
            $newWidth = (int)($originalWidth * $ratio);
            $newHeight = (int)($originalHeight * $ratio);
            
            // Resize if necessary
            if ($ratio < 1) {
                $img->resize($newWidth, $newHeight, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            // Try different quality levels starting from high quality
            for ($quality = 90; $quality >= self::MIN_QUALITY; $quality -= 5) {
                $tempPath = tempnam(sys_get_temp_dir(), 'img');
                $img->toWebp($quality)->save($tempPath);
                $size = filesize($tempPath);
                unlink($tempPath);

                if ($size <= self::MAX_FILE_SIZE) {
                    // Found a good quality level
                    $storagePath = Storage::disk('public')->path($fullPath);
                    File::ensureDirectoryExists(dirname($storagePath));
                    $img->toWebp($quality)->save($storagePath);

                    Log::info('Image saved successfully', [
                        'original_name' => $image->getClientOriginalName(),
                        'path' => $fullPath,
                        'final_size' => $size,
                        'quality' => $quality,
                        'dimensions' => [
                            'width' => $img->width(),
                            'height' => $img->height()
                        ],
                        'original_dimensions' => [
                            'width' => $originalWidth,
                            'height' => $originalHeight
                        ]
                    ]);

                    return $fullPath;
                }
            }

            // If we still haven't reached target size, use minimum quality
            $storagePath = Storage::disk('public')->path($fullPath);
            File::ensureDirectoryExists(dirname($storagePath));
            $img->toWebp(self::MIN_QUALITY)->save($storagePath);
            
            Log::warning('Image saved with minimum quality', [
                'original_name' => $image->getClientOriginalName(),
                'path' => $fullPath,
                'quality' => self::MIN_QUALITY,
                'dimensions' => [
                    'width' => $img->width(),
                    'height' => $img->height()
                ]
            ]);

            return $fullPath;

        } catch (\Exception $e) {
            Log::error('Error saving image', [
                'error' => $e->getMessage(),
                'file' => $image->getClientOriginalName()
            ]);
            throw $e;
        }
    }
}
