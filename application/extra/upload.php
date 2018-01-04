<?php
/**
 * 自定义文件上传配置文件
 *
 * @author xiaomo<i@nixiaomo.com>
 */

// 上传文件根目录：/public/uploads/
$uploads_path = ROOT_PATH . 'public' . DS . 'uploads' . DS;

return [
    // 图片前缀、路径、大小
    'imgs_prefix' => HOST . '/uploads/imgs',
    'imgs_path' => $uploads_path . 'imgs',
    'imgs_size' => 10 * 1024 * 1024,
];