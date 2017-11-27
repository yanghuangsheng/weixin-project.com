<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/14
 * Time: 17:09
 */

namespace Home\Controller;


class AuthController extends CommonController
{
    protected $homeUser;

    public function _initialize()
    {
        parent::_initialize();
        $this->homeUser = session(C('SESSON_USER'));
        if (!$this->homeUser) {
            $openId = $this->wx->getOpenid();
            $this->addUser($this->wx->getUserInfo($openId));
            if ($userId = M('User')->where(['openid' => "{$openId}"])->getField('id')) {
                $this->homeUser = ['openId' => $openId, 'userId' => $userId];
                session(C('SESSON_USER'), $this->homeUser);
            }
        }
        //dump($this->homeUser);

    }
}