<?php
/**
 * Upload（上传）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\controller\v1;


use app\lib\exception\UploadException;

class Upload extends BaseController
{
    /**
     * 上传图片
     *
     * @return \think\response\Json
     * @throws UploadException
     */
    public function uploadImage()
    {
        // 获取上传文件
        $files = request()->file('image');
        $this->_fileIsNotEmpty($files);
        $urls = [];
        foreach ($files as $file) {
            // 移动到框架应用根目录/public/uploads/imgs/Ymd目录下
            $info = $file
                ->validate(['size' => config('upload.imgs_size')])
                ->move(config('upload.imgs_path'));
            if ($info) {
                // 成功上传后 获取上传信息
                $pathname = $info->getSaveName();
                $pathname = str_replace('\\', '/', $pathname);
                $urls[] = config('upload.imgs_prefix') . '/' . $pathname;
            } else {
                // 上传失败抛出错误信息
                throw new UploadException([
                    'msg' => $file->getError()
                ]);
            }
        }
        return json([
            'urls' => $urls,
            'code' => 200
        ]);
    }

    /**
     * 上传文件不能为空
     *
     * @param $file
     * @throws UploadException
     */
    private function _fileIsNotEmpty($file)
    {
        if (!$file) {
            throw new UploadException([
                'msg' => '文件不存在'
            ]);
        }
    }
}