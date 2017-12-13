<?php
/**
 * cms令牌业务
 *
 * @author xiaomo<i@nixiaomo.com>
 */

namespace app\api\service;


use app\api\model\User;
use app\api\model\UserLogin;
use app\lib\exception\TokenException;

class CmsToken extends Token
{
    /**
     * 获取cms token
     *
     * @param $ac
     * @param $se
     * @return mixed
     * @throws TokenException
     */
    public function get($ac, $se)
    {
        $user = User::check($ac, $se);
        if (!$user) {
            throw new TokenException([
                'msg' => '账号或密码有误',
                'errorCode' => 10004
            ]);
        } else {
            // 记录登录日志
            $this->_recordLoginLog();
            // 将用户数据存储到缓存
            $scope = $user->scope;
            $uid = $user->id;
            $nickname = $user->nickname;
            $values = [
                'scope' => $scope,
                'uid' => $uid,
                'nickname' => $nickname
            ];
            $token = $this->_saveToCache($values);
            return $token;
        }
    }

    /**
     * 修改密码
     *
     * @param $uid
     * @param $se
     * @param $newSe
     * @throws TokenException
     */
    public function updateSecret($uid, $se, $newSe)
    {
        $user = $this->_updateSecret($uid, $se, $newSe);
        if (!$user) {
            throw new TokenException([
                'msg' => '原密码错误或与新密码相同',
                'errorCode' => 10004
            ]);
        }
    }

    /**
     * 更新密码
     *
     * @param $uid
     * @param $se
     * @param $newSe
     * @return User|false|int
     */
    private function _updateSecret($uid, $se, $newSe)
    {
        // 加密
        $se = pwd_encrypt($se);
        $newSe = pwd_encrypt($newSe);
        // 更新
        $user = new User();
        // 原密码正确，且不能和新密码相同
        $user->save(['pwd' => $newSe], function ($query) use ($uid, $se, $newSe) {
            // 更新status值为1 并且id大于10的数据
            $query->where('id', '=', $uid)
                ->where('pwd', '=', $se)
                ->where('pwd', '<>', $newSe);
        });
        return $user;
    }

    /**
     * 删除cms token
     *
     * @param $token
     */
    public function delete($token)
    {
        cache($token, null);
    }

    /**
     * 保存到缓存
     *
     * @param $values
     * @return mixed
     * @throws TokenException
     */
    private function _saveToCache($values)
    {
        $key = self::generateToken();
        $value = json_encode($values);
        $expire_in = config('setting.token_expire_in');
        // 存储
        $request = cache($key, $value, $expire_in);
        if (!$request) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    /**
     * 记录登录日志
     */
    private function _recordLoginLog()
    {
        // 获取并保存当前登录时间、ip、地址等
        $time = get_current_time();
        $ip = get_login_ip();
        $address = get_login_address($ip);
        $data = [
            'login_time' => $time,
            'login_ip' => $ip,
            'login_address' => $address,
        ];
        // 新增UserLogin
        UserLogin::create($data);
    }
}