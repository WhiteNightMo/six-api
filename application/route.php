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
Route::post('/:version/token/verify', 'api/:version.Token/verifyToken');
// cms
Route::post('/:version/cms', 'api/:version.CmsToken/getCmsToken');
Route::put('/:version/cms/secret', 'api/:version.CmsToken/updateSecret');
Route::post('/:version/cms/logout', 'api/:version.CmsToken/deleteCmsToken');

// upload
Route::post('/:version/upload_image', 'api/:version.Upload/uploadImage');

// user
Route::get('/:version/user_login/paginate', 'api/:version.UserLogin/getLoginLogs');

// article
Route::get('/:version/article', 'api/:version.Article/getAllArticles');
Route::get('/:version/article/:id', 'api/:version.Article/getArticleByID', [], ['id' => '\d+']);
Route::post('/:version/article', 'api/:version.Article/createOrUpdateArticle');
Route::delete('/:version/article/:id', 'api/:version.Article/delete');
Route::get('/:version/article/months', 'api/:version.Article/getAllMonths');
Route::get('/:version/article/by_month', 'api/:version.Article/getArticlesByMonth');

// tag
Route::get('/:version/tag/q', 'api/:version.Tag/getTagByParam');

// category
Route::get('/:version/category/all', 'api/:version.Category/getAllCategories');
Route::post('/:version/category', 'api/:version.Category/createOrUpdateCategory');
Route::delete('/:version/category/:id', 'api/:version.Category/delete');

// link
Route::post('/:version/link', 'api/:version.Link/createOrUpdateLink');
Route::delete('/:version/link/:id', 'api/:version.Link/delete');