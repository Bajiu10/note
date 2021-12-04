<?php

namespace App\Http\Controllers\Api;

use App\Http\Controller;
use Max\Http\Request\UploadedFile;
use Max\Routing\Annotations\PostMapping;

class Chat extends Controller
{
    #[PostMapping(path: '/api/chat/upload')]
    public function uploadImage()
    {
        $image = $this->request->file('chat-image');
        $name  = md5(microtime(true));
        if ($image instanceof UploadedFile && 'php' !== $image->getExtention() && $image->move(env('public_path') . 'upload/chat/images/' . date('Ymd'), $name)) {
            return [
                'success' => 1,
                'message' => '图片上传成功！',
                'url'     => '/upload/chat/images/' . date('Ymd') . '/' . $name . '.' . $image->getExtention()
            ];
        }
        return [
            'success' => 0,
            'message' => '上传失败',
        ];
    }
}