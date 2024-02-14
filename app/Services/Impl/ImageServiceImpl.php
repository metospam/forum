<?php

namespace App\Services\Impl;

use App\Services\ImageService;
use Exception;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageServiceImpl implements ImageService
{

    /**
     * Converts the given uploaded file to its base64 representation after resizing it.
     *
     * @param UploadedFile $file The uploaded file to be converted.
     *
     * @return string|null The base64 representation of the resized image, or null if an error occurs.
     */
    public function toBase64(UploadedFile $file): ?string
    {
        try {
            $resizedImage = $this->resizeImage($file);
            $imageContent = $resizedImage->encode()->encoded;

            return base64_encode($imageContent);
        } catch (Exception $e) {
            Log::error('Failed to encode the image: ' . $e);
            return null;
        }
    }

    /**
     * Resizes the given uploaded file using Imagick and returns the resized image.
     *
     * @param UploadedFile $file The uploaded file to be resized.
     *
     * @return Image The resized image.
     */
    private function resizeImage(UploadedFile $file): Image
    {
        $manager = new ImageManager(['driver' => 'imagick']);

        $image = $manager->make($file);
        $image->resize(150, 150);

        return $image;
    }
}
