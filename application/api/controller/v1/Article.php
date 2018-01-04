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
use app\lib\validate\MonthFormat;
use app\lib\validate\PageParameter;
use think\Db;

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
     * @throws \think\Exception
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
     * 获取所有月份以及文章数量
     *
     * @return \think\response\Json
     * @throws ArticleException
     * @throws \think\Exception
     */
    public function getAllMonths()
    {
        // 根据月份分组，并获取文章数量
        $months = ArticleModel::getArticlesCountGroupByMonth();
        if ($months->isEmpty()) {
            throw new ArticleException();
        }
        return json($months);
    }

    /**
     * 根据月份获取文章
     *
     * @param $month
     * @return \think\response\Json
     * @throws \think\exception
     */
    public function getArticlesByMonth($month)
    {
        (new MonthFormat())->goCheck();

        $articles = ArticleModel::getArticlesByMonth($month);
        if ($articles->isEmpty()) {
            throw new ArticleException();
        }
        // 整理格式
        $articles = $articles->visible(['id', 'title', 'update_time'])->toArray();
        $articles = collection($articles)->each(function ($article) {
            $article['update_time'] = date('d', strtotime($article['update_time']));
            return $article;
        });
        return json($articles);
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
        if (is_null($id) || !is_numeric($id) || !is_int($id + 0)) {
            throw new ParameterException([
                'msg' => 'id有误'
            ]);
        }
        $validate = new EditorCreateOrUpdate();
        $validate->goCheck();
        $data = $validate->getDataByRule(input('post.'));
//        $data['body'] = input('post.body/s', '', null);

        // 整理标签数组
        $tags = Tag::normalizeTags($data['tags']);
        unset($data['tags']);

        // 显式指定新增/更新
        $id != 0 && $data['id'] = $id;
        $isUpdate = $id != 0 ? true : false;
        $article = new ArticleModel();
        $res = $article->isUpdate($isUpdate)->save($data);

        if ($res) {
            // sync方法：只有数组中的tag_id会存在中间表中
            $article->tags()->sync($tags);
        }

        return json([
            'id' => $article->id,
            'errorCode' => 0
        ], 201);
    }

    /**
     * 根据id获取文章
     *
     * @param $id
     * @param $isEdit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getArticleByID($id, $isEdit = null)
    {
        (new IDMustBePositiveInt())->goCheck();

        $article = ArticleModel::getArticleByID($id);
        if (!$article) {
            throw new ArticleException();
        }
        // 如果是编辑，则不使用获取器解析后的内容
        if ($isEdit && $isEdit == true) {
            $array = $article->toArray();
            $array['body'] = ArticleModel::defaultFilterDecode($article->getData('body'));
            return json($array);
        }
        return json($article);
    }

    /**
     * 根据id删除
     *
     * @param $id
     * @return \think\response\Json
     * @throws \think\Exception
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