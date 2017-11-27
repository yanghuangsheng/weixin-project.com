<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/9
 * Time: 11:28
 */

namespace Admin\Controller;


class EnrollController extends CommonController
{
    public function index()
    {
        $this->selectEnroll();
        $this->display();
    }

    //报名列表
    protected function selectEnroll()
    {
        if (isFormat()) {
            $returnData = $this->pageSelect('Enroll');
            foreach ($returnData['data'] as $key => $value){
                $returnData['data'][$key]['system_time']=date('Y-m-d H:i:s',$value['system_time']);
            }
            //返回JSON
            $this->ajaxReturn($returnData);
        }
    }
}