<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/6
 * Time: 11:14
 */
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
    public function index()
    {
        $this->loginCheckApi();
        $this->display();
    }

    public function out()
    {
        //清空session登陆信息
        session(C('SESSON_ADMIN'), null);

        if (I('get._format_') == 'json') {
            //解锁返回JSON
            $this->ajaxReturn(array('state' => 0));
        }
        $this->redirect('Login/index');
    }



    protected function loginCheckApi()
    {
        if (IS_POST) {
            $dataUserName = I('post.userName');
            $dataUserPassword = I('post.password');

            if ($dataUserName && $dataUserPassword) {
                $admin = M('admin');
                $resultData = $admin->where(array('user_name' => $dataUserName))
                    ->field('id,user_name,user_password,last_time')->find();
                if ($resultData && $dataUserPassword === $resultData['user_password']) {
                    //登陆成功 更新当前登陆时间
                    $admin->where(array('id' => $resultData['id']))->save(array('last_time' => time()));
                    $resultData['last_time'] = date('Y-m-d H:i:s', $resultData['last_time']);
                    $returnData = array(
                        'state' => 0,
                        'msg' => "<font color='#006400'> 登陆成功!</font> <br>你上次登陆时间为：{$resultData['last_time']}",
                    );
                    //注册session
                    session(C('SESSON_ADMIN'), $resultData);

                } else {
                    $returnData = array(
                        'state' => 1,
                        'msg' => '<font color="red">帐号或密码不正确</font>',
                    );
                    //清空session
                    session(C('SESSON_ADMIN'), null);
                }

                $this->ajaxReturn($returnData);

            }

        }
    }


}
