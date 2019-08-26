<?php
namespace Phone\Controller;
session_start();
class MobileCodeController extends BaseController{
    public function index(){
    	$this->display();
    }
	public function send(){
		$reg = "/^1[3|4|5|7|8]\d{9}$/";
        $phone = $_POST['phone'];
        if(!preg_match($reg,$phone)){
            exit("phone_error");
        }
        $userid = "13465";
        $account = "13103555527";
        $pwd = "13103555527";
        $randStr = str_shuffle('1234567890');  
        $code = substr($randStr,0,6);
        $msg = "您的验证码为：".$code."【佳源建材】";
        $result = sendSMS($userid,$account,$pwd,$phone,$msg);
        if($result)
        {
            $_SESSION["{$phone}"] = $code;
            exit("ok");
        }
        else
        {
            exit("error");
        }
	}
    public function verify(){
        $phone = $_POST['phone'];
        $code = $_POST['code'];
        if($phone==null||$code==null)
        {
            exit("buwanzheng");
        }
        $phone_code = $_SESSION["{$phone}"];
        if($phone_code==$code)
        {
            cookie('phone',$phone);
            exit("ok");
        }
        else
        {
            exit("codeError");
        }
    }
}