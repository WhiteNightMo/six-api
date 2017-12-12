<?php
/**
 * Category（友链分类）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;

class Category
{
    public function getAllCategories()
    {
        $data = CategoryModel::getAllCategoriesWithLinks();
        return json($data);
    }
}