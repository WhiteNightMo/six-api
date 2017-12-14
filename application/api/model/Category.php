<?php
/**
 * CategoryModel
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\model;


use traits\model\SoftDelete;

class Category extends BaseModel
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
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

    /**
     * 检查category_id是否合法
     *
     * @param $id
     * @return bool
     */
    public static function isValidCategoryID($id)
    {
        $category = self::find($id);
        if ($category) {
            return true;
        } else {
            return false;
        }
    }
}