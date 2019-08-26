<?php
namespace Phone\Controller;
use Think\Controller;
class WeixinPayController extends Controller{
    public function index() {
        $order_id=I("id");
        $order = M('order_form')->where("id=$order_id")->find();
        $this->assign("orderID",$order_id);
        $this->assign("order",$order);
        $this->display();
    }

    public function index_package() {
        $order_id=I("id");
        $order = M('order_package')->where("id=$order_id")->find();
        $this->assign("order_id",$order_id);
        $this->assign("order",$order);
        $this->display();
    }

    public function index_integral() {
        $order_id=I("id");
        $order = M('order_integral')->where("id=$order_id")->find();
        $this->assign("order_id",$order_id);
        $this->assign("order",$order);
        $this->display();
    }
       //在类初始化方法中，引入相关类库    
    public function _initialize() {
        vendor('Wxpay.Api');
        vendor('Wxpay.JsApiPay');
        vendor('Wxpay.Notify');
    }
    
    public function notify(){
        $notify = new \WxPayNotify();
        $notify->Handle(false);
        $time = date('Y-m-d H:i:s',time());
        $filename = './logs/'.date('Y_m_d').'.log';
        $word = "进入回调了 \r\n";
        file_put_contents($filename, $word,FILE_APPEND);
        $postStr=$GLOBALS['HTTP_RAW_POST_DATA'];
        $postObj = simplexml_load_string($postStr,"SimpleXMLElement",LIBXML_NOCDATA);
        $result_code=$postObj->result_code;
        if($result_code && $result_code=="SUCCESS"){
            $out_trade_no   = $postObj->out_trade_no;        //订单号
            $transaction_id = $postObj->transaction_id;      //微信支付编号
            //查找商城订单
            $order = M("order_form")->where("ordernum=$out_trade_no")->find();
            // $word = "订单：$order \r\n";
            // file_put_contents($filename, $word,FILE_APPEND);
            if($order!=null)
            {
                $member_id = $order['member_id']; 
                $payment_price = $order['payment_price']; 
                $member = M('member')->where("id=$member_id")->find();
                if($member!=null)
                {
                    //查询微信支付订单
                    $input = new \WxPayOrderQuery();

                    $input->SetTransaction_id($transaction_id);

                    $result = \WxPayApi::orderQuery($input);

                    if(array_key_exists("return_code", $result)
                        && array_key_exists("result_code", $result)
                        && $result["return_code"] == "SUCCESS"
                        && $result["result_code"] == "SUCCESS")
                    {
                        //交易金额
                        $total_fee = $result['total_fee'] / 100;
                        // $word = "交易金额：$total_fee \r\n";
                        // file_put_contents($filename, $word,FILE_APPEND);
                        //交易金额和订单金额不一样
                        // if($total_fee!=$payment_price)
                        // {
                        //     return false;
                        // }
                        //交易状态
                        $trade_state = $result['trade_state'];
                        // $word = "订单状态：$trade_state \r\n";
                        // file_put_contents($filename, $word,FILE_APPEND);
                        //未支付
                        if($trade_state=="SUCCESS")
                        {
                            $word = "订单id：{$order['id']} \r\n";
                            file_put_contents($filename, $word,FILE_APPEND);
                            if(notify($order['id'])){
                                $word = "结果：成功 \r\n";
                                file_put_contents($filename, $word, FILE_APPEND);
                                $resXml = "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";
                                return $resXml;
                            }
                            else
                            {
                                $word = "结果：失败 \r\n";
                                file_put_contents($filename, $word, FILE_APPEND);
                                $resXml = "<xml><return_code>FAIL</return_code><return_msg>处理业务时错误</return_msg></xml>"; 
                                return $resXml;
                            }
                        }
                        else
                        {
                            $word = "结果：订单状态不对 \r\n";
                            file_put_contents($filename, $word, FILE_APPEND);
                        }
                    }
                }
                else
                {
                    $word = "结果：会员不存在 \r\n";
                    file_put_contents($filename, $word, FILE_APPEND);
                }
            }
            else
            {
                $word = "结果：订单不存在 \r\n";
                file_put_contents($filename, $word, FILE_APPEND);
            }
        }
    } 

    public function package_notify_url(){
        $notify = new \WxPayNotify();
        $notify->Handle(false);
        $time = date('Y-m-d H:i:s',time());
        $filename = './logs/'.date('Y_m_d').'.log';
        $postStr=$GLOBALS['HTTP_RAW_POST_DATA'];
        $postObj = simplexml_load_string($postStr,"SimpleXMLElement",LIBXML_NOCDATA);
        $result_code=$postObj->result_code;
        if($result_code && $result_code=="SUCCESS"){
            $out_trade_no   = $postObj->out_trade_no;        //订单号
            $transaction_id = $postObj->transaction_id;      //微信支付编号
            //查找商城订单
            $order = M("order_package")->where("ordernum=$out_trade_no")->find();
            // $word = "订单：$order \r\n";
            // file_put_contents($filename, $word,FILE_APPEND);
            if($order!=null)
            {
                $member_id = $order['member_id']; 
                $member = M('member')->where("id=$member_id")->find();
                if($member!=null)
                {
                    //查询微信支付订单
                    $input = new \WxPayOrderQuery();

                    $input->SetTransaction_id($transaction_id);

                    $result = \WxPayApi::orderQuery($input);

                    if(array_key_exists("return_code", $result)
                        && array_key_exists("result_code", $result)
                        && $result["return_code"] == "SUCCESS"
                        && $result["result_code"] == "SUCCESS")
                    {
                        //交易金额
                        $total_fee = $result['total_fee'] / 100;
                        // $word = "交易金额：$total_fee \r\n";
                        // file_put_contents($filename, $word,FILE_APPEND);
                        //交易金额和订单金额不一样
                        // if($total_fee!=$payment_price)
                        // {
                        //     return false;
                        // }
                        //交易状态
                        $trade_state = $result['trade_state'];
                        // $word = "订单状态：$trade_state \r\n";
                        // file_put_contents($filename, $word,FILE_APPEND);
                        //未支付
                        if($trade_state=="SUCCESS")
                        {
                            if(package_notify($order['id'])){
                                $word = "结果：成功 \r\n";
                                file_put_contents($filename, $word, FILE_APPEND);
                                $resXml = "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";
                                return $resXml;
                            }
                            else
                            {
                                $word = "结果：失败 \r\n";
                                file_put_contents($filename, $word, FILE_APPEND);
                                $resXml = "<xml><return_code>FAIL</return_code><return_msg>处理业务时错误</return_msg></xml>"; 
                                return $resXml;
                            }
                        }
                        else
                        {
                            $word = "结果：订单状态不对 \r\n";
                            file_put_contents($filename, $word, FILE_APPEND);
                        }
                    }
                }
                else
                {
                    $word = "结果：会员不存在 \r\n";
                    file_put_contents($filename, $word, FILE_APPEND);
                }
            }
            else
            {
                $word = "结果：订单不存在 \r\n";
                file_put_contents($filename, $word, FILE_APPEND);
            }
        }
    } 

    public function integral_notify_url(){
        $notify = new \WxPayNotify();
        $notify->Handle(false);
        $time = date('Y-m-d H:i:s',time());
        $filename = './logs/'.date('Y_m_d').'.log';
        $word = "进入回调了 \r\n";
        file_put_contents($filename, $word,FILE_APPEND);
        $postStr=$GLOBALS['HTTP_RAW_POST_DATA'];
        $postObj = simplexml_load_string($postStr,"SimpleXMLElement",LIBXML_NOCDATA);
        $result_code=$postObj->result_code;
        if($result_code && $result_code=="SUCCESS"){
            $out_trade_no   = $postObj->out_trade_no;        //订单号
            $transaction_id = $postObj->transaction_id;      //微信支付编号
            //查找商城订单
            $order = M("order_integral")->where("ordernum=$out_trade_no")->find();
            // $word = "订单：$order \r\n";
            // file_put_contents($filename, $word,FILE_APPEND);
            if($order!=null)
            {
                $member_id = $order['member_id']; 
                $payment_price = $order['payment_price']; 
                $member = M('member')->where("id=$member_id")->find();
                if($member!=null)
                {
                    //查询微信支付订单
                    $input = new \WxPayOrderQuery();

                    $input->SetTransaction_id($transaction_id);

                    $result = \WxPayApi::orderQuery($input);

                    if(array_key_exists("return_code", $result)
                        && array_key_exists("result_code", $result)
                        && $result["return_code"] == "SUCCESS"
                        && $result["result_code"] == "SUCCESS")
                    {
                        //交易金额
                        $total_fee = $result['total_fee'] / 100;
                        // $word = "交易金额：$total_fee \r\n";
                        // file_put_contents($filename, $word,FILE_APPEND);
                        //交易金额和订单金额不一样
                        // if($total_fee!=$payment_price)
                        // {
                        //     return false;
                        // }
                        //交易状态
                        $trade_state = $result['trade_state'];
                        $word = "订单状态：$trade_state \r\n";
                        file_put_contents($filename, $word,FILE_APPEND);
                        //未支付
                        if($trade_state=="SUCCESS")
                        {
                            if(integral_notify($order['id'])){
                                $word = "结果：成功 \r\n";
                                file_put_contents($filename, $word, FILE_APPEND);
                                $resXml = "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";
                                return $resXml;
                            }
                            else
                            {
                                $word = "结果：失败 \r\n";
                                file_put_contents($filename, $word, FILE_APPEND);
                                $resXml = "<xml><return_code>FAIL</return_code><return_msg>处理业务时错误</return_msg></xml>"; 
                                return $resXml;
                            }
                        }
                        else
                        {
                            $word = "结果：订单状态不对 \r\n";
                            file_put_contents($filename, $word, FILE_APPEND);
                        }
                    }
                }
                else
                {
                    $word = "结果：会员不存在 \r\n";
                    file_put_contents($filename, $word, FILE_APPEND);
                }
            }
            else
            {
                $word = "结果：订单不存在 \r\n";
                file_put_contents($filename, $word, FILE_APPEND);
            }
        }
    } 
}
?>