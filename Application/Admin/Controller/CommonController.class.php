<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/6
 * Time: 16:17
 */

namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{
    protected $adminAuthData = array();

    public function _initialize()
    {
        $this->adminAuthData = session(C('SESSON_ADMIN'));
        if (!$this->adminAuthData['id']) {
            exit ('<script language=JavaScript> top.location.href="'.U("Login/index").'"; </script>');
            //$this->redirect('Login/index');
        }
    }

    public function pageSelect($model)
    {
        $getData = I('get.');
        $model = M($model);
        $map = [];
        //如果有查询值
        if (isset($getData['key'])) {
            $map = unWhereMapArray($getData['key']);
        }
        $returnData['data'] = $model->where($map)->order('id desc')
            ->limit(limit($getData['page'], $getData['limit']))->select();
        $returnData['sql'] = $model->getLastSql();
        $returnData['count'] = $model->where($map)->order('id desc')->count();
        $returnData['code'] = 0;
        $returnData['msg'] = '获取数据成功';

        return $returnData;
    }
}