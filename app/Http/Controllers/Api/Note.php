<?php

namespace App\Http\Controllers\Api;

use App\Http\Controller;
use App\Models\Notes;
use Max\Http\UploadedFile;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\PostMapping;

#[\Max\Routing\Annotations\Controller(prefix: 'api/notes', middleware: ['api'])]
class Note extends Controller
{
    #[GetMapping(path: '/list')]
    public function list(Notes $notes)
    {
        $page = $this->request->get('p', 1);
        return $notes->list($page, 8)->map(function($value) {
            if (empty($value['thumb'])) {
                $value['thumb'] = '/static/bg/bg' . rand(1, 18) . '.jpg';
            }
            return $value;
        })->toArray();
    }

    /**
     * 上传缩略图
     *
     * @return array
     * @throws \Exception
     */
    #[PostMapping(path: '/upload-thumb')]
    public function uploadImage(): array
    {
        /* @var UploadedFile $thumb */
        $thumb = $this->request->file('thumb');
        $type  = pathinfo($thumb->getClientFilename(), PATHINFO_EXTENSION);
        $name  = md5(microtime(true)) . '.' . $type;
        $path  = '/upload/thumb/' . date('Ymd/') . $name;
        if ($thumb instanceof UploadedFile) {
            $thumb->moveTo(public_path(ltrim($path, '/')));
            return ['status' => true, 'path' => $path];
        }
        return ['status' => false, 'path' => ''];
    }

    /**
     * 新增或者编辑界面上传图片
     *
     * @return array
     * @throws \Exception
     */
    #[PostMapping(path: '/uploadImage')]
    public function uploadImages(): array
    {
        $image = $this->request->file('editormd-image-file');
        $type  = pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);
        $name  = md5(microtime(true)) . '.' . $type;
        $path  = '/upload/images/' . date('Ymd/') . $name;
        if ($image instanceof UploadedFile) {
            $image->moveTo(public_path(ltrim($path, '/')));
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
