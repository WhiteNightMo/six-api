<?php
/**
 * ArticleModel
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\model;


use traits\model\SoftDelete;

//Loader::import('parsedown.Parsedown', EXTEND_PATH);

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
        $value = self::defaultFilterDecode($value);
        //  Parsedown会对代码区域内的html代码进行转义，代码区域外的却不进行转义
//        $Parsedown = new \Parsedown();
        // 转义下面这句话时，会执行script语句
//        $value = $Parsedown->text("<script>alert(1);</script>\n```\n<script>alert(1);</script>\n```";);
        return $value;
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
     * @throws \think\Exception
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
     * @throws \think\Exception
     */
    public static function getArticleByID($id)
    {
        return self::with(['tags'])->find($id);
    }

    /**
     * 根据月份分组，并获取文章数量
     *
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\Exception
     */
    public static function getArticlesCountGroupByMonth()
    {
        return self::field(["FROM_UNIXTIME(update_time, '%Y%m')" => "month", "COUNT(id)" => "count"])
            ->group('month')
            ->order(['month' => 'desc'])
            ->select();
    }

    /**
     * 根据月份获取文章
     *
     * @param $month
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\exception\DbException
     */
    public static function getArticlesByMonth($month)
    {
        return self::where("CONCAT(
                    LEFT(FROM_UNIXTIME(update_time, '%Y%m'), 4),
                    RIGHT(FROM_UNIXTIME(update_time, '%Y%m'), 2)
                  ) = :month", ['month' => $month])
            ->order(['update_time' => 'desc', 'create_time' => 'desc'])
            ->select();
    }
}