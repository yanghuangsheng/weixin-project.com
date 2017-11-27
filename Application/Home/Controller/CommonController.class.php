<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/13
 * Time: 23:49
 */

namespace Home\Controller;


use Think\Controller;

class CommonController extends Controller
{
    protected $wx;
    protected $settings;
    public function _initialize(){
        $this->getSettings();
        $this->assign('appName',$this->settings['name']);
        vendor('wechat.Wx');
        $config=[
            'appId'=>'wx7da03a1e72bb4054',
            'appSecret'=>'d6f7cd2e66df2cdd33015caa3ae23f3c',
        ];
        $this->wx = new \wechat\Wx($config);
    }

    protected function getSettings(){
        $this->settings = M('settings')->where(['id' => 1])->find();
    }

    protected function addUser($userInfoData)
    {
        //dump($userInfoData);
        if (!isset($userInfoData['errcode'])) {
            $data = [
                'openid' => $userInfoData['openid'],
                'name' => $userInfoData['nickname'],
                'sex' => $userInfoData['sex'],
                'city' => $userInfoData['city'],
                'province' => $userInfoData['province'],
                'country' => $userInfoData['country'],
                'avatar' => $userInfoData['headimgurl'],
                'register_time' => $userInfoData['subscribe_time'],
                'status' => 1,
            ];
            $user = M('User');
            $map = ['openid' => $data['openid']];
            if ($user->where($map)->count()) {
                unset($data['openid']);
                $user->where($map)->save($data);
            } else {
                $user->add($data);
            }

        }

    }

    protected function unUser($openId)
    {
        M('User')->where(['openid' => "{$openId}"])->save(['status' => 0]);
    }

}