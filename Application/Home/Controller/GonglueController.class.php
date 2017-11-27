<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/14
 * Time: 5:21
 */

namespace Home\Controller;


class GonglueController extends CommonController
{
    public function index(){
        $id=I('get.id');
        if(!$id) return false;
        $data = M('Gonglue')->where(['id' => $id])->find();

        $this->assign('settings', $this->settings);
        $this->assign('data', $data);
        $this->display();
    }
}