<?php

/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/13
 * Time: 16:52
 */
namespace wechat\build;
use wechat\Wx;

class Message extends Wx
{


    //回复文本
    public function text($content, $message)
    {
        $xml = '
        <xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
         </xml>';
        $text = sprintf($xml, $message->FromUserName, $message->ToUserName, time(), $content);
        echo $text;
    }

    //回复图片消息
    public function images($content, $message)
    {
        $xml = '
        <xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[image]]></MsgType>
            <Image>
                <MediaId><![CDATA[media_id]]></MediaId>
            </Image>
        </xml>';
        echo sprintf($xml, $message->FromUserName, $message->ToUserName, time(), $content);
    }

    //回复图文信息
    public function news($data, $message)
    {
        foreach ($data as $key => $value) {
            $item .= "
            <item>
            <Title><![CDATA[{$value['title']}]]></Title> 
            <Description><![CDATA[{$value['title']}]]></Description>
            <PicUrl><![CDATA[{$this->webUrl}/{$value['show_img']}]]></PicUrl>
            <Url><![CDATA[{$this->webUrl}/index.php?c=gonglue&id={$value['id']}]]></Url>
            </item>
            ";
        }
        $xml = '
            <xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%d</CreateTime>
            <MsgType><![CDATA[news]]></MsgType>
            <ArticleCount>' . count($data) . '</ArticleCount>
            <Articles>
            '.$item.'
            </Articles>
            </xml>';
        echo sprintf($xml, $message->FromUserName, $message->ToUserName, time());
    }
}