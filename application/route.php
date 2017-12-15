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
Route::post('api/:version/cms', 'api/:version.CmsToken/getCmsToken');
Route::put('api/:version/cms/secret', 'api/:version.CmsToken/updateSecret');
Route::post('api/:version/cms/logout', 'api/:version.CmsToken/deleteCmsToken');

// upload
Route::post('api/:version/upload_image', 'api/:version.Upload/uploadImage');

// user
Route::get('api/:version/user_login/paginate', 'api/:version.UserLogin/getLoginLogs');

// article
Route::get('api/:version/article', 'api/:version.Article/getAllArticles');
Route::get('api/:version/article/:id', 'api/:version.Article/getArticleByID');
Route::post('api/:version/article', 'api/:version.Article/createOrUpdateArticle');
Route::delete('api/:version/article/:id', 'api/:version.Article/delete');

// tag
Route::get('api/:version/tag/q', 'api/:version.Tag/getTagByParam');

// category
Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');
Route::post('api/:version/category', 'api/:version.Category/createOrUpdateCategory');
Route::delete('api/:version/category/:id', 'api/:version.Category/delete');

// link
Route::post('api/:version/link', 'api/:version.Link/createOrUpdateLink');
Route::delete('api/:version/link/:id', 'api/:version.Link/delete');