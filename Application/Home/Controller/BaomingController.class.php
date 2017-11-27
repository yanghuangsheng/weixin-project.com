<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/15
 * Time: 4:09
 */

namespace Home\Controller;


class BaomingController extends AuthController
{
    public function index(){
        $data['explain']=$this->settings['baoming_explain'];
        $data['money']=explode(' ',$this->settings['baoming_money']);
        //dump($data);
        $this->assign('data',$data);
        $this->display();
    }
}