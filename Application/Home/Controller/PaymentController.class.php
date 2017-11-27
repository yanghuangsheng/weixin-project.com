<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/11/14
 * Time: 17:00
 */

namespace Home\Controller;


class PaymentController extends AuthController
{
    public function index(){
        $this->display();
    }

    //确认认单
    public function confirm()
    {
        if (!IS_POST) {
            return false;
        }

        vendor('Wxpay.lib.WxPay#Api');
        vendor('Wxpay.example.WxPay#JsApiPay');
        vendor('Wxpay.example.log');

        //初始化日志
        $logHandler = new \CLogFileHandler("logs/" . date('Y-m-d') . '.log');
        $log = \Log::Init($logHandler, 15);

//        //打印输出数组信息
//       function printf_info($data)
//       {
//           foreach($data as $key=>$value){
//               echo "<font color='#00ff55;'>$key</font> : $value <br/>";
//           }
//       }

        //①、获取用户openid
        $tools = new \JsApiPay();
        //②、统一下单
        $input = new \WxPayUnifiedOrder();

        $fromData = I('post.');
        $fromData['user_id'] = $this->homeUser['userId'];
        $fromData['order_number'] = \WxPayConfig::MCHID . date("YmdHis");
        if (!$fromData['id'] = $this->addOrder($fromData)) {
            return false;
        }
        //商品支付简要描述
        $input->SetBody($fromData['explain']);
        //附加数据，在查询API和支付通知中原样返回
        $input->SetAttach($fromData['explain']);
        //商户系统内部订单号
        $input->SetOut_trade_no($fromData['order_number']);
        //订单金额，单位为分
        $input->SetTotal_fee($fromData['count_money'] * 100);
        $input->SetTime_start(date("YmdHis"));//生成订单时间
        $input->SetTime_expire(date("YmdHis", time() + 600));//订单失效时间
        //$input->SetGoods_tag("test");//商品标记，代金卷或立减优惠功能参数
        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");//接收微信异步通知地址
        $input->SetTrade_type("JSAPI");//交易类型
        $input->SetOpenid($this->homeUser['openId']);//用户openId
        $order = \WxPayApi::unifiedOrder($input);
//       echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//       printf_info($order);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        $this->assign('data', $fromData);
        $this->assign('jsApiParameters', $jsApiParameters);
        $this->display();
    }

    //创建订单
    protected function addOrder($data)
    {

        //dump($data);
        //return false;
        $orderModel=M('order');
        if($orderModel->where(['order_number'=>"{$data['order_number']}"])->count()){
            //重复提交订单
            return false;
        }

        $updata = [
            'user_id' => $data['user_id'],
            'order_number' => $data['order_number'],
            'count_money' => $data['count_money'],
            'explain' => $data['explain'],
            'name' => $data['name'],
            'system_time' => time()
        ];
        //payment_type 等于1时是缴纳费用 0是报名学车
        if($data['payment_type'] == 0 && 0 == M('Enroll')->where(['name'=>$data['name'],'phone' => $data['phone']])->count()){
            M('Enroll')->add([
                'system_time'=>$updata['system_time'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'user_id' => $data['user_id']
            ]);
        }
        $id=$orderModel->add($updata);
        //echo M()->getLastSql();
        return $id;




    }

    //支付同步回调
    public function replyPay(){
        if (!IS_POST) {
            return false;
        }
        $data=I('post.');
        if($data['order_number']){
            M('Order')->where(['order_number'=>$data['order_number']])->save(['status'=>1]);
        }
    }
}