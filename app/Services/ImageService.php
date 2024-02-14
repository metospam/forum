<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageService
{
    function toBase64(UploadedFile $file): ?string;
}
