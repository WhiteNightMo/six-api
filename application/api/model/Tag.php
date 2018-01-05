<?php
/**
 * TagModel
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\model;


use traits\model\SoftDelete;

class Tag extends BaseModel
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
    protected $hidden = ['intro', 'create_time', 'update_time', 'delete_time', 'pivot'];

    public function articles()
    {
        return $this->belongsToMany('Article');
    }

    /**
     * 获取所有标签
     *
     * @throws \think\Exception
     */
    public static function getAllTags()
    {
        return self::alias('t')
            ->join('__ARTICLE_TAG__ a', 't.id = a.tag_id', 'LEFT')
            ->field(['t.id', 't.name', 'COUNT(t.id)' => 'count'])
            ->group('t.id')
            ->select();
    }

    /**
     * 整理标签
     *
     * @param $tags
     * @return array
     */
    public static function normalizeTags($tags)
    {
        // 数组转集合，挨个回调
        return collection($tags)->each(function ($tag) {
            // 如果是数字，且存在，直接返回
            if (is_numeric($tag)) {
                $tag = (int)$tag;
                $isValidTag = self::find($tag);
                if ($isValidTag) {
                    return $tag;
                }
            }
            // 如果不是数字，或者是数字但不存在，则新增
            $newTag = self::create(['name' => $tag]);
            return $newTag->id;
        })->toArray();
    }
}