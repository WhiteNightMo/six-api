<?php
/**
 * Article（文章）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\controller\v1;


use app\api\model\Article as ArticleModel;
use app\api\model\Tag;
use app\lib\exception\ArticleException;
use app\lib\exception\ParameterException;
use app\lib\exception\SuccessMessage;
use app\lib\validate\EditorCreateOrUpdate;
use app\lib\validate\IDMustBePositiveInt;
use app\lib\validate\PageParameter;
use think\Db;
use think\Loader;

Loader::import('parsedown.Parsedown', EXTEND_PATH);

class Article extends BaseController
{
    protected $beforeActionList = [
        'checkSuperScope' => ['only' => 'createOrUpdateArticle']
    ];

    /**
     * 分页获取文章列表
     *
     * @param int $page
     * @param int $size
     * @return array
     */
    public function getAllArticles($page = 1, $size = 15)
    {
        (new PageParameter())->goCheck();

        // 分页获取登录日志
        $pagingArticles = ArticleModel::getAllArticles($page, $size);
        // pivot
        return $this->getPaginatorData($pagingArticles);
    }

    /**
     * 新增或编辑文章
     *
     * @param $id
     * @return \think\response\Json
     * @throws ParameterException
     */
    public function createOrUpdateArticle($id = null)
    {
        if (empty($id) || !is_numeric($id) || !is_int($id + 0)) {
            throw new ParameterException([
                'msg' => 'id有误'
            ]);
        }
        $validate = new EditorCreateOrUpdate();
        $validate->goCheck();
        $data = $validate->getDataByRule(input('post.'));

        // 整理标签数组
        $tags = Tag::normalizeTags($data['tags']);
        unset($data['tags']);

        // 显式指定新增/更新
        $data['id'] = $id;
        $isUpdate = $id != 0 ? true : false;
        $category = new ArticleModel();
        $res = $category->isUpdate($isUpdate)->save($data);

        if ($res) {
            // sync方法：只有数组中的tag_id会存在中间表中
            $category->tags()->sync($tags);
        }

        return json([
            'id' => $category->id,
            'errorCode' => 0
        ], 201);
    }

    /**
     * 根据id获取文章
     *
     * @param $id
     * @return \think\response\Json
     * @throws ArticleException
     */
    public function getArticleByID($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $article = ArticleModel::getArticleByID($id);
        if (!$article) {
            throw new ArticleException();
        }
        return json($article);
    }

    /**
     * 根据id删除
     *
     * @param $id
     * @return \think\response\Json
     */
    public function delete($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        // 关联删除
        ArticleModel::destroyByID($id);
        // 按照官方文档的$article->pivot，我竟然无法获取到中间表的数据Orz
        Db::name('article_tag')->where('article_id', '=', $id)->delete();
        return json(new SuccessMessage(), 200);
    }
}