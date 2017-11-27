<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/9
 * Time: 16:45
 */

namespace Admin\Controller;


class OrderController extends CommonController
{
    public function index()
    {
        $this->selectOrder();
        $this->display();
    }

    //缴费列表
    protected function selectOrder()
    {
        if (isFormat()) {
            $returnData = $this->pageSelect('Order');
            foreach ($returnData['data'] as $key => $value){
                $returnData['data'][$key]['system_time']=date('Y-m-d H:i:s',$value['system_time']);
            }
            //返回JSON
            $this->ajaxReturn($returnData);
        }
    }
}