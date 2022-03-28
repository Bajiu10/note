<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Services\Uploader;
use Max\Foundation\Http\Annotations\Controller;
use Max\Foundation\Http\Annotations\PostMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix: 'api/chat')]
class Chat extends ApiController
{
    #[PostMapping(path: '/upload')]
    public function upload(Uploader $uploader): ResponseInterface
    {
        try {
            $path = $uploader->images($this->request->file('chat-image'));
            return $this->success([
                'url' => $path,
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
