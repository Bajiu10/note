<?php

namespace App\Controllers\Api;

use App\Controllers\ApiController;
use App\Model\Dao\NoteDao;
use App\Services\Uploader;
use Exception;
use Max\Di\Annotations\Inject;
use Max\Di\Exceptions\NotFoundException;
use Max\Http\Annotations\Controller;
use Max\Http\Annotations\GetMapping;
use Max\Http\Annotations\PostMapping;
use Max\Http\Message\UploadedFile;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Throwable;

/**
 * Class Note
 *
 * @package App\Http\Controllers\Api
 */
#[Controller(prefix: 'api/notes')]
class NoteController extends ApiController
{
    #[Inject]
    protected Uploader $uploader;

    #[GetMapping(path: '')]
    public function index(NoteDao $noteDao): ResponseInterface
    {
        return $this->success($noteDao->getSome($this->request->get('p', 1))->toArray());
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     * @throws Throwable
     */
    #[GetMapping(path: '/<id>')]
    public function show($id): ResponseInterface
    {
        return $this->success(\App\Model\Entities\Note::findOrFail($id)->toArray());
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
