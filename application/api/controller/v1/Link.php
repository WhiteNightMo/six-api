<?php
/**
 * Link（友链）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\controller\v1;


use app\api\model\Category;
use app\api\model\Link as LinkModel;
use app\lib\exception\CategoryException;
use app\lib\exception\SuccessMessage;
use app\lib\validate\LinkCreateOrUpdate;

class Link extends BaseController
{
    protected $beforeActionList = [
        'checkSuperScope' => ['only' => 'createOrUpdateLink']
    ];

    /**
     * 新增或者更新link
     *
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function createOrUpdateLink()
    {
        $validate = new LinkCreateOrUpdate();
        $validate->goCheck();

        // 获取过滤后的用户提交的数据
        $data = $validate->getDataByRule(input('post.'));
        // 检查category_id是否合法
        $isValid = Category::isValidCategoryID($data['category_id']);
        if (!$isValid) {
            throw new CategoryException();
        }

        // 显式指定新增/更新
        $isUpdate = $data['id'] ? true : false;
        $link = new LinkModel();
        $link->isUpdate($isUpdate)->save($data);

        return json(new SuccessMessage(), 201);
    }

    /**
     * 删除
     *
     * @param $id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function delete($id)
    {
        LinkModel::destroyByID($id);
        return json((new SuccessMessage()));
    }
}