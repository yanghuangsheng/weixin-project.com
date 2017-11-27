<?php

/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/12
 * Time: 10:59
 */
namespace wechat;
class Wx
{
    protected static $_config = [];
    protected $message;
    protected $accessToken;
    protected $openId;
    protected $apiUrl;
    protected $webUrl;

    public function __construct(array $config)
    {
        if( $config){
            self::$_config = $config;
        }
        $this->apiUrl='https://api.weixin.qq.com';
        $this->webUrl='http://ya.56gou.com';
        $this->message = $this->parsePostRequestData();

        $this->getAccessToken();

    }

    public function getAccessToken()
    {
        $cacheName = md5(self::$_config['appId'] . self::$_config['appSecret']);
        $file = __DIR__ . '/cache/' . $cacheName . '.php';
        if (is_file($file) && filemtime($file) + 1 > time()) {
            $data = include $file;
        } else {
            $url = $this->apiUrl.'/cgi-bin/token?grant_type=client_credential&appid='.self::$_config['appId'].'&secret='.self::$_config['appSecret'];
            $data = $this->curl($url);
            $data = json_decode($data, true);
            if (isset($data['errcode'])) {
                return false;
            }
            file_put_contents($file, '<?php return ' . var_export($data, true) . ';?>');
        }
        return $this->accessToken = $data['access_token'];
    }


    public function valid()
    {
        $get = I('get.');
        if (isset($get['signature']) && isset($get['timestamp']) && isset($get['nonce']) && isset($get['echostr'])) {
            $signature = $get['signature'];
            $timetamp = $get['timestamp'];
            $nonce = $get['nonce'];
            $token = self::$_config['token'];
            $tmpArr = [$token, $timetamp, $nonce];
            sort($tmparr, SORT_STRING);
            $tmpStr = sha1(implode($tmpArr));
            if ($tmpStr == $signature) {
                echo $get['echostr'];
            }
        }
    }

    public function getMessage()
    {
        return $this->message;
    }

    //关注操作
    public function isSubscribeEvent($event='subscribe')
    {
        if ($this->message->Event == $event && $this->message->MsgType == 'event') {
            //返回用户openID
            return $this->message->FromUserName;
        }
        return false;
    }

    //获取粉丝发来的信息内容
    public function parsePostRequestData()
    {
        if (isset($GLOBALS['HTTP_RAW_POST_DATA'])) {
            return simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA);
        }
    }

    //获取用户信息
    public function getUserInfo($openId)
    {
        $userInfoUrl = "{$this->apiUrl}/cgi-bin/user/info?access_token={$this->accessToken}&openid={$openId}&lang=zh_CN";
        $data = $this->curl($userInfoUrl);
        return json_decode($data, true);
    }

    public function getOpenid()
    {
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $url = $this->__CreateOauthUrlForCode($baseUrl);
            Header("Location: $url");
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $openid = $this->getOpenidFromMp($code);
            return $openid;
        }
    }

    //获取OPENID
    public function getOpenidFromMp($code)
    {
        $url = $this->__CreateOauthUrlForOpenid($code);
        $res=$this->curl($url);
        $data = json_decode($res,true);
        $this->data = $data;
        $openid = $data['openid'];
        return $openid;
    }

    //构造获取code的url连接
    private function __CreateOauthUrlForCode($redirectUrl)
    {
        $urlObj["appid"] = self::$_config['appId'];
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_base";
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }

    //构造获取open和access_toke的url地址
    private function __CreateOauthUrlForOpenid($code)
    {
        $urlObj["appid"] = self::$_config['appId'];
        $urlObj["secret"] = self::$_config['appSecret'];
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }

    //拼接签名字符串
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    public function curl($url, $fields = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //不直接显示数据
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //禁止证书校验
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //post数据
        if ($fields) {
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }
        $data = '';
        if (curl_exec($ch)) {
            $data = curl_multi_getcontent($ch);
        }
        curl_close($ch);
        return $data;
    }

    public function instance($name)
    {
        include __DIR__ . '/build/' . ucfirst($name) . '.php';
        $className = 'wechat\build\\' . ucfirst($name);
        return new $className;
    }
}