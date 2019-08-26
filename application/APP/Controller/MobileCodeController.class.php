<?php
namespace APP\Controller;
session_start();
class MobileCodeController extends BaseController{
    /**
    * @api {GET} MobileCode/send  发送手机短信验证码
    * @apiGroup 短信
    * @apiDescription 发送手机短信验证码
    * @apiParam {string} phone 手机号
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *   }
    */
	public function send(){
		$reg = "/^1[3|4|5|7|8]\d{9}$/";
        $phone = $_GET['phone'];
        if(!preg_match($reg,$phone)){
            exit("phone_error");
        }
        $userid = "13465";
        $account = "13103555527";
        $pwd = "13103555527";
        $randStr = str_shuffle('1234567890');  
        $code = substr($randStr,0,6);
        $msg = "您的验证码为：".$code."【车管家】";
        // $result = sendSMS($userid,$account,$pwd,$phone,$msg);
        $result = true;
        if($result)
        {
            $_SESSION["phone"] = $phone;
            $_SESSION["code"] = $code;
            $result = array("code"=>"200","msg"=>"短信发送成功","data"=>$code);
        }
        else
        {
            $result = array("code"=>"400","msg"=>"发送短信验证码失败，请重新发送");
        }
        exit(json_encode($result));
	}
    /**
    * @api {GET} MobileCode/verify 验证 短信验证码 
    * @apiGroup 短信
    * @apiDescription 验证 短信验证码 
    * @apiParam {string} phone 手机号
    * @apiParam {string} code 验证码
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *   }
    */
    public function verify(){
        $phone = $_POST['phone'];
        $code = $_POST['code'];
        if(empty($phone))
        {   
            $result = array("code"=>"404","msg"=>"请输入手机号");
            exit(json_encode($result));
        }
        if(empty($code))
        {
            $result = array("code"=>"404","msg"=>"请输入短信验证码");
            exit(json_encode($result));
        }

        $s_phone = $_SESSION["phone"];
        $s_code = $_SESSION["code"];

        if($s_phone==$phone && $s_code==$code)
        {
            $result = array("code"=>"200","msg"=>"验证成功");
            exit(json_encode($result));
        }
        else
        {
            $result = array("code"=>"500","msg"=>"验证失败，请输入正确的验证码或者重新获取验证码");
            exit(json_encode($result));
        }
    }
}