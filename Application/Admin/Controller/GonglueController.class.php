<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/7
 * Time: 14:07
 */

namespace Admin\Controller;


class GonglueController extends CommonController
{
    protected $editId;

    public function edit()
    {
        $this->editId = I('get.id');
        $this->checkEditId();
        $this->updateEdit();
        //获取数据
        $gonglue = M('Gonglue');
        $data = $gonglue->where(array('id' => $this->editId))->find();
        $this->assign('data', $data);
        $this->display();
    }

    protected function checkEditId()
    {
        if (!$this->editId) {
            exit("非法访问！");
        }
    }

    protected function updateEdit()
    {
        if (IS_POST) {
            $data = I("post.");
            $gonglue = M('Gonglue');
            $gonglue->id=$data['id'];
            $gonglue->title = $data['title'];
            $gonglue->show_img = $data['show_img'];
            $gonglue->body_html = $data['editorValue'];
            $gonglue->update_time = time();
            if ($gonglue->save()) {
                $returnData = array(
                    'code' => 0,
                    'msg' => "<font color='#fff'> 更新成功!</font>",
                );
            } else {
                $returnData = array(
                    'code' => 1,
                    'msg' => "<font color='red'> 更新失败!</font>",
                );
            }
            $this->ajaxReturn($returnData);

        }

    }

}