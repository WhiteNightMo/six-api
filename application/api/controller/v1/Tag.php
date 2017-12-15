<?php
/**
 * Tag（文章标签）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\controller\v1;

use app\api\model\Tag as TagModel;

class Tag extends BaseController
{
    /**
     * 根据参数获取tag
     *
     * @param $q
     * @return \think\response\Json
     */
    public function getTagByParam($q)
    {
        $tags = TagModel::where('name', 'like', "%{$q}%")->select();
        return json($tags);
    }
}