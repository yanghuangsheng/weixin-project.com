<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/13
 * Time: 22:34
 */

namespace wechat\build;

use wechat\Wx;

class Button extends Wx
{

    public function create($jsonData)
    {
        $url="{$this->apiUrl}/cgi-bin/menu/create?access_token={$this->accessToken}";
        $result=$this->curl($url,$jsonData);
        print_r($result);

    }
}