<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/8
 * Time: 15:07
 */

namespace Admin\Controller;


class SettingsController extends CommonController
{
    public function edit()
    {
        $settings = M('Settings');
        $this->updateEdit($settings);
        $returnData = $settings->where(array('id' => 1))->find();
        $this->assign('data', $returnData);
        $this->display();

    }

    protected function updateEdit($model)
    {
        if(IS_POST){
            $data = I("post.");
            $model->name = $data['name'];
            $model->logo = $data['logo'];
            $model->content = $data['content'];
            $model->baoming_money = $data['baoming_money'];
            $model->baoming_explain = $data['baoming_explain'];
            $model->ad_url = $data['ad_url'];
            $model->ad_image = $data['ad_image'];
            if($model->where(array('id'=>1))->save() !== false){
                $returnData = array(
                    'code' => 0,
                    'msg' => "<font color='#fff'> 更新成功!</font>",
                );
            } else {
                $returnData = array(
                    'code' => 1,
                    'msg' => "<font color='red'> 更新失败!</font>",
                    'sql' => $model->getLastSql(),
                );
            }
            $this->ajaxReturn($returnData);
        }
    }

}