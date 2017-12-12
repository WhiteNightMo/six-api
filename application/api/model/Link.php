<?php
/**
 * LinkModel
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\model;


class Link extends BaseModel
{
    protected $hidden = ['category_id', 'create_time', 'update_time', 'delete_time'];
}