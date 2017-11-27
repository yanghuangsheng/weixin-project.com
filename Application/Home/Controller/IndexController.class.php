<?php
namespace Home\Controller;

class IndexController extends CommonController
{

    public function index()
    {
        //关注成功
        if ($openId = $this->wx->isSubscribeEvent()) {
            $this->addUser($this->wx->getUserInfo($openId));
            $this->replyJianjie();
            return false;
        }
        //取消关注
        if ($openId = $this->wx->isSubscribeEvent('unsubscribe')) {
            $this->unUser($openId);
            return false;
        }
        $this->eventClick();
        $this->replyJianjie();

    }

    //统一回复简介
    protected function replyJianjie()
    {
        $content = M('settings')->where(['id' => 1])->getField('content');
        $this->wx->instance('message')->text($content, $this->wx->getMessage());
    }

    //其他事件
    protected function eventClick()
    {
        if ($this->wx->getMessage()->Event == 'CLICK') {
            switch ($this->wx->getMessage()->EventKey) {
                case 'kemu_0_1':
                    $this->replyKemu(1);
                    break;
                case 'kemu_0_2':
                    $this->replyKemu(2);
                    break;
                case 'kemu_0_3':
                    $this->replyKemu(3);
                    break;
                case 'kemu_0_4':
                    $this->replyKemu(4);
                    break;
                case 'jihua_0_1':
                    $this->replyJihua(15);
                    break;
                case 'jihua_0_2':
                    $this->replyJihua(16);
                    break;
                case 'jihua_0_3':
                    $this->replyJihua(17);
                    break;
                case 'jihua_0_4':
                    $this->replyJihua(18);
                    break;

            }
            exit;
        }

    }

    protected function replyKemu($kemuXum)
    {
        $data = M('Gonglue')->where(['kemu' => $kemuXum])->select();
        $this->wx->instance('message')->news($data, $this->wx->getMessage());
    }

    protected function replyJihua($jihuaId)
    {
        $data = M('Gonglue')->where(['id' => $jihuaId])->select();
        $this->wx->instance('message')->news($data, $this->wx->getMessage());
    }


}