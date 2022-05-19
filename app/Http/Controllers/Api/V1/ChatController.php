<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Services\Uploader;
use Max\Http\Annotations\Controller;
use Max\Http\Annotations\PostMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix: 'api/chat')]
class ChatController extends ApiController
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
