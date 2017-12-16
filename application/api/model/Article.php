<?php
/**
 * ArticleModel
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\model;


use traits\model\SoftDelete;

class Article extends BaseModel
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
    protected $hidden = ['delete_time'];
    // 类型转换
    protected $type = [
        'create_time,update_time' => 'timestamp'
    ];

    // 解码
    public function getBodyAttr($value)
    {
        return htmlspecialchars_decode($value);
    }

    // 多对多关联
    public function tags()
    {
        return $this->belongsToMany('Tag');
    }

    /**
     * 获取文章列表
     *
     * @param int $page
     * @param int $size
     * @return \think\Paginator
     */
    public static function getAllArticles($page = 1, $size = 15)
    {
        return self::with(['tags'])
            ->order(['update_time' => 'desc', 'create_time' => 'desc'])
            ->paginate($size, false, ['page' => $page]);
    }

    /**
     * 根据id获取文章
     *
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public static function getArticleByID($id)
    {
        return self::with(['tags'])->find($id);
    }
}