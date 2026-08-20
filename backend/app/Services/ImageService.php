<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    protected $manager;

    public function __construct()
    {
        // Use GD driver as it is standard in most environments
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Process and store an image.
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @param int $width
     * @param int $quality
     * @return string Path to the stored image
     */
    public function storeProcessedImage($file, $directory = 'images', $width = 1200, $quality = 80)
    {
        $filename = Str::random(40) . '.webp';
        $path = $directory . '/' . $filename;

        // Read image from file path
        $image = $this->manager->read($file->getRealPath());

        // Resize image maintaining aspect ratio
        $image->scale(width: $width);

        // Encode as WebP with specified quality
        $encoded = $image->toWebp($quality);

        // Store in public disk
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }
}
