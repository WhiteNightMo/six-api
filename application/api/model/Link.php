<?php
/**
 * LinkModel
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\model;


use traits\model\SoftDelete;

class Link extends BaseModel
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
    protected $hidden = ['category_id', 'create_time', 'update_time', 'delete_time'];

    /**
     * 根据category_id删除link
     *
     * @param $id
     */
    public static function deleteByCategoryID($id)
    {
        // 正常关联删除只能真删除- -
        // $category->links()->delete();
        // 使用这种方式实现软删除的我，内心很绝望
        $idArr = self::where('category_id', '=', $id)->column('id');
        self::destroy($idArr);
    }
}