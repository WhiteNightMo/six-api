<?php
/**
 * EditorCreateOrUpdate（Markdown/富文本编辑器创建或更新时验证）
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\lib\validate;


class EditorCreateOrUpdate extends BaseValidate
{
    protected $rule = [
        'title' => 'require|isNotEmpty',
        'tags' => 'isNotSet',
        'body' => 'require|isNotEmpty'
//        'body' => 'require|editorIsNotEmpty'  、
    ];

    protected $message = [
        'title' => '标题不能为空',
        'tags' => '标签不能省略',
        'body' => '内容不能为空'
    ];

    /**
     * 富文本编辑器内容不能为空
     *
     * @param $value
     * @return bool|string
     */
    protected function editorIsNotEmpty($value)
    {
        // htmlspecialchars函数解码，再去除html标签
        $value = strip_tags(htmlspecialchars_decode($value));
        if (empty($value)) {
            return false;
        } else {
            return true;
        }
    }
}