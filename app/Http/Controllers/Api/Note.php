<?php

namespace App\Http\Controllers\Api;

use App\Dao\NoteDao;
use App\Http\Controllers\ApiController;
use Exception;
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
    /**
     * @param NoteDao $noteDao
     *
     * @return ResponseInterface
     */
    #[GetMapping(path: '', allowCrossDomain: ['*'])]
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
        $type  = pathinfo($thumb->getClientFilename(), PATHINFO_EXTENSION);
        $name  = md5(microtime(true)) . '.' . $type;
        $path  = '/upload/thumb/' . date('Ymd/') . $name;
        if ($thumb instanceof UploadedFile) {
            $thumb->moveTo(base_path('public/' . ltrim($path, '/')));
            return $this->success([
                'path' => $path,
            ]);
        }

        return $this->error();
    }

    /**
     * 新增或者编辑界面上传图片
     *
     * @return array
     * @throws Exception
     */
    #[PostMapping(path: '/uploadImage')]
    public function uploadImages(): array
    {
        $image = $this->request->file('editormd-image-file');
        $type  = pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);
        $name  = md5(microtime(true)) . '.' . $type;
        $path  = '/upload/images/' . date('Ymd/') . $name;
        if ($image instanceof UploadedFile) {
            $image->moveTo(base_path('public/' . ltrim($path, '/')));
            return [
                'success' => 1,
                'message' => '图片上传成功！',
                'url'     => $path
            ];
        }
        return [
            'success' => 0,
            'message' => '上传失败',
        ];
    }
}
