<?php

namespace App\Http\Controllers\Api;

use App\Http\Controller;
use App\Models\Notes;
use Max\Cache\Cache;
use Max\Http\Request\UploadedFile;

class Note extends Controller
{
    public function list(Notes $notes)
    {
        $page = $this->request->get('p', 1);
        return $notes->list($page, 8)->map(function($value) {
            if(empty($value['thumb'])) {
                $value['thumb'] = '/static/bg/bg'. rand(1, 18). '.jpg';
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
    public function uploadImage(): array
    {
        $thumb = $this->request->file('thumb');
        $name  = md5(microtime(true));
        if ($thumb instanceof UploadedFile && $thumb->move(env('public_path') . 'upload/thumb/' . date('Ymd'), $name)) {
            return ['status' => true, 'path' => '/upload/thumb/' . date('Ymd/') . $name . '.' . $thumb->getExtention()];
        }
        return ['status' => false, 'path' => ''];
    }

    /**
     * 新增或者编辑界面上传图片
     *
     * @return array
     * @throws \Exception
     */
    public function uploadImages(): array
    {
        $image = $this->request->file('editormd-image-file');
        $name  = md5(microtime(true));
        if ($image instanceof UploadedFile && $image->move(env('public_path') . 'upload/images/' . date('Ymd'), $name)) {
            return [
                'success' => 1,
                'message' => '图片上传成功！',
                'url'     => '/upload/images/' . date('Ymd') . '/' . $name . '.' . $image->getExtention()
            ];
        }
        return [
            'success' => 0,
            'message' => '上传失败',
        ];
    }
}
