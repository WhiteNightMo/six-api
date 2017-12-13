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
// cms
Route::post('api/:version/cms','api/:version.CmsToken/getCmsToken');
Route::put('api/:version/cms/secret','api/:version.CmsToken/updateSecret');
Route::post('api/:version/cms/logout','api/:version.CmsToken/deleteCmsToken');

// user
Route::get('api/:version/user_login/paginate', 'api/:version.UserLogin/getLoginLogs');

// category
Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');