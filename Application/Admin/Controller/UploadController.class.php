<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/7
 * Time: 23:52
 */

namespace Admin\Controller;

class UploadController extends CommonController
{
    //上传图片
    public function index()
    {
        $returnData=array(
            'code'=>1,
            'msg'=>'上传失败！',
        );
        if($imgData = uploadImage('images', 'file')){
            $returnData['code']=0;
            $returnData['msg']='上传成功！';
            $returnData['data']['src']=$imgData['rootPath'].$imgData['savepath'].$imgData['savename'];
        }

        $this->ajaxReturn($returnData);
    }
}