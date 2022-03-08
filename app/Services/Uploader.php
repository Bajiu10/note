<?php

namespace App\Services;

use Exception;
use Max\Http\Message\UploadedFile;

class Uploader
{
    /**
     * @throws Exception
     */
    public function images(UploadedFile $image): string
    {
        $type = pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);
        $name = md5(microtime(true)) . '.' . $type;
        $path = '/upload/images/' . date('Ymd/') . $name;
        $image->moveTo(base_path('public/' . ltrim($path, '/')));

        return $path;
    }
}
