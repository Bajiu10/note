<?php

namespace App\Services;

use Exception;
use Max\Http\Message\UploadedFile;

class Uploader
{
    /**
     * 允许的后缀
     */
    protected const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /**
     * @throws Exception
     */
    public function images(UploadedFile $image): string
    {
        $type = pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);
        if (!in_array($type, self::ALLOWED_EXTENSIONS)) {
            throw new Exception('类型不支持');
        }
        $name = md5(microtime(true)) . '.' . $type;
        $path = '/upload/images/' . date('Ymd/') . $name;
        $image->moveTo(base_path('public/' . ltrim($path, '/')));

        return $path;
    }
}
