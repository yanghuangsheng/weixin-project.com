<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/6
 * Time: 14:11
 */
function uploadImage($typePath, $name = "files")
{
    $mtRand = mt_rand(100000, 900000);
    $saveName = time() . $mtRand;
    $config = array(
        'rootPath' => './Public/Uploads/' . $typePath . '/',
        'maxSize' => 2048000,
        'autoSub' => true,
        'subName' => array('date', 'Ymd'),
        'saveName' => $saveName,
        'exts' => array('jpg', 'gif', 'png', 'jpeg')
    );
    $upload = new \Think\Upload($config);
    is_file($upload->rootPath) || mkdir($upload->rootPath, 0777, true);
    $info = $upload->upload();
    if ($info[$name]) {
        $info[$name]['rootPath'] = $upload->rootPath;
        return $info[$name];
    } else {
        return false;
    }

}

//返回获取数据的位置
function limit($page, $limit)
{
    $page || $page = 1;
    $pageNum = ($page - 1) * $limit;
    return "{$pageNum},{$limit}";
}

//重组数据 去掉数组的空值
function unWhereMapArray($data)
{
    $returnData=[];
    foreach ($data as $key => $value) {
        if($value){
            $returnData[$key]=$value;
        }
    }
    return $returnData;
}
//是否获取Json
function isFormat($text='json'){
    return I('get._format_') == $text;
}