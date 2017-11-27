<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/15
 * Time: 8:14
 */

namespace Home\Controller;


class OrderController extends AuthController
{
    public function index()
    {
        $userData = M('User')->where(['id' => $this->homeUser['userId']])->find();
        //echo M()->getLastSql();
        $orderData = M('Order')->where(['status' => 1, 'user_id' => $this->homeUser['userId']])->order('id desc')->select();

        $this->assign('user', $userData);
        $this->assign('order', $orderData);
        $this->display();
    }
}