<?php
/**
 * Category（友链分类）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\api\model\Link;
use app\lib\exception\CategoryException;
use app\lib\exception\SuccessMessage;
use app\lib\validate\CategoryCreateOrUpdate;
use app\lib\validate\IDMustBePositiveInt;

class Category extends BaseController
{
    protected $beforeActionList = [
        'checkSuperScope' => ['only' => 'createOrUpdateCategory']
    ];

    /**
     * 获取所有分类和友链
     *
     * @return \think\response\Json
     */
    public function getAllCategories()
    {
        $data = CategoryModel::getAllCategoriesWithLinks();
        return json($data);
    }

    /**
     * 新增或者更新category
     *
     * @return \think\response\Json
     */
    public function createOrUpdateCategory()
    {
        $validate = new CategoryCreateOrUpdate();
        $validate->goCheck();

        // 获取过滤后的用户提交的数据
        $data = $validate->getDataByRule(input('post.'));
        // 显式指定新增/更新
        $isUpdate = $data['id'] ? true : false;
        $category = new CategoryModel();
        $category->isUpdate($isUpdate)->save($data);

        return json(new SuccessMessage(), 201);
    }

    /**
     * 删除
     *
     * @param $id
     * @return \think\response\Json
     * @throws CategoryException
     */
    public function delete($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        // 关联删除
        CategoryModel::destroyByID($id);
        Link::deleteByCategoryID($id);
        return json((new SuccessMessage()));
    }
}