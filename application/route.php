<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

// token
Route::post('api/:version/token/verify', 'api/:version.Token/verifyToken');
Route::post('api/:version/token/cms','api/:version.Token/getCmsToken');
Route::post('api/:version/token/cms_logout','api/:version.Token/deleteCmsToken');

// category
Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');

Route::get('cms/token/login','cms/Token/getToken');