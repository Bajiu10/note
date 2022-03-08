<?php

namespace App\Http\Controllers\Api;

use App\Dao\NoteDao;
use App\Http\Controllers\ApiController;
use App\Services\Uploader;
use Exception;
use Max\Di\Annotations\Inject;
use Max\Http\Message\UploadedFile;
use Max\Routing\Annotations\Controller;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Note
 *
 * @package App\Http\Controllers\Api
 */
#[Controller(prefix: 'api/notes')]
class Note extends ApiController
{
    #[Inject]
    protected Uploader $uploader;

    /**
     * @param NoteDao $noteDao
     *
     * @return ResponseInterface
     */
    #[GetMapping(path: '')]
    public function index(NoteDao $noteDao): ResponseInterface
    {
        return $this->success($noteDao->getSome($this->request->get('p', 1))->toArray());
    }

    /**
     * 上传缩略图
     *
     * @return ResponseInterface
     * @throws Exception
     */
    #[PostMapping(path: '/upload-thumb')]
    public function uploadImage(): ResponseInterface
    {
        /* @var UploadedFile $thumb */
        $thumb = $this->request->file('thumb');

        try {
            $path = $this->uploader->images($thumb);
            return $this->success([
                'path' => $path,
            ]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 新增或者编辑界面上传图片
     *
     * @return ResponseInterface
     * @throws Exception
     */
    #[PostMapping(path: '/uploadImage')]
    public function uploadImages(): ResponseInterface
    {
        $image = $this->request->file('editormd-image-file');

        try {
            $path = $this->uploader->images($image);
            return $this->response->json([
                'success' => 1,
                'message' => '图片上传成功！',
                'url'     => $path
            ]);
        } catch (Exception $e) {
            return $this->response->json([
                'success' => 0,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
