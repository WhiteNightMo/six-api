<?php
/**
 * CategoryModel
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];

    public function links()
    {
        return $this->hasMany('Link', 'category_id', 'id');
    }

    /**
     * 获取所有分类以及其下的友链
     *
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getAllCategoriesWithLinks()
    {
        return self::with(['links'])->select();
    }
}