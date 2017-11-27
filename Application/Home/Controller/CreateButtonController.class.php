<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/13
 * Time: 23:34
 */

namespace Home\Controller;


class CreateButtonController extends CommonController
{
    protected $jsonData;
    public function index(){
        $this->createJsonData();
        $this->wx->instance('Button')->create($this->jsonData);
    }

    protected function createJsonData(){
            $this->jsonData = <<<php
{
    "button": [
        {
            "name": "驾考攻略",
            "sub_button": [
                {
                    "type": "click",
                    "name": "科目一",
                    "key": "kemu_0_1"
                },
                {   
                    "type": "click",
                    "name": "科目二",
                    "key": "kemu_0_2"
                },
                {   
                    "type": "click",
                    "name": "科目三",
                    "key": "kemu_0_3"
                },
                {   
                    "type": "click",
                    "name": "科目四",
                    "key": "kemu_0_4"
                }
            ]
        },
        {
            "name": "约考计划",
            "sub_button": [
                {
                    "type": "click",
                    "name": "科一约考计划",
                    "key": "jihua_0_1"
                },
                {
                    "type": "click",
                    "name": "科二约考计划",
                    "key": "jihua_0_2"
                },
                {
                    "type": "click",
                    "name": "科三约考计划",
                    "key": "jihua_0_3"
                },
                {
                    "type": "click",
                    "name": "科四约考计划",
                    "key": "jihua_0_4"
                }
            ]
        },
        {
            "name": "报名学车",
            "sub_button": [
                {
                    "type": "view",
                    "name": "缴费记录",
                    "url": "http://ya.56gou.com/?index.php&c=order"
                },
                {
                    "type": "view",
                    "name": "我要缴费",
                    "url": "http://ya.56gou.com/?index.php&c=payment"
                },
                {
                    "type": "view",
                    "name": "在线报名",
                    "url": "http://ya.56gou.com/?index.php&c=baoming"
                }
            ]
        }
    ]
}
php;

            
}
}