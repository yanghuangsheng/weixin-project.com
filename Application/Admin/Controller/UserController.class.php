<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/8
 * Time: 18:36
 */

namespace Admin\Controller;


class UserController extends CommonController
{
    public function index()
    {
        $this->selectUser();
        $this->display();
    }

    //用户列表
    protected function selectUser()
    {
        if (isFormat()) {
            $returnData = $this->pageSelect('user');
            //组装
            foreach ($returnData['data'] as $key =>$value){
                $returnData['data'][$key]['register_time']=date('Y-m-d H:i:s',$value['register_time']);
                $returnData['data'][$key]['status']=$value['status']?'关注中':'已取消';
            }
            //返回JSON
            $this->ajaxReturn($returnData);
        }
    }

}