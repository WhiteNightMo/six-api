<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 密码加密
 *
 * @param $pwd
 * @return string
 */
function pwd_encrypt($pwd)
{
    if (empty($pwd)) {
        $pwd = config('secure.default_pwd');
    }
    $hash = $pwd . config('secure.pwd_salt');
    $chars = md5(hash('sha256', $hash));
    return $chars;
}

/**
 * 获取指定长度的随机字符串
 *
 * @param $length
 * @return null|string
 */
function get_rand_chars($length = 32)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)];
    }

    return $str;
}

/**
 * 获取当前时间戳
 *
 * @return mixed
 */
function get_current_time()
{
    return $_SERVER['REQUEST_TIME'];
}

/**
 * 获取登录ip
 *
 * @return mixed
 */
function get_login_ip()
{
    // 本地部署为127.0.0.1
    $request = \think\Request::instance();
    $ip = $request->ip();
    return $ip;
}

/**
 * 根据ip地址获取坐标
 *
 * @param $ip
 * @return mixed
 */
function get_login_address($ip)
{
    // 根据百度地图普通IP定位API服务获取坐标
    $content = file_get_contents(sprintf(config('secure.bd_location_url'), config('secure.bd_location_ak'), $ip));
    $json = json_decode($content, true);
    return $json['content']['address']; // 按层级关系提取address数据
}