<?php
namespace Phone\Controller;
class PasswordController extends BaseController {
    public function index(){
        $this->assign("title","忘记密码");
        $this->display("phone_verify");
    }   
    public function edit_mode(){
        $this->assign("title","修改方式");
        $this->display();
    }
    public function phone_verify(){
        $this->assign("title","绑定手机验证");
        $this->display();
    }
    public function reset_show(){
        $phone = $_COOKIE['phone'];
        if($phone!=null)
        {
            $new_phone = substr_replace($phone,"****",3,4);
            $this->assign("phone",$new_phone);
            $this->assign("title","重置密码");
            $this->display("reset_pwd");
        }
        else
        {
            $this->redirect("phone_verify");
        }
	}
    public function reset(){
        $phone = $_COOKIE['phone'];
        $password=$_POST['password'];
        $passwordRepeat=$_POST['passwordRepeat'];
        if($phone!=null)
        {
            if($password==null)
            {
                exit("new_pwd_null");
            }
            if($passwordRepeat==null)
            {
                exit("repeat_pwd_null");
            }
            if($password!=$passwordRepeat)
            {
                exit("no_alike");
            }
            $isHaveMember=M("member")->where("phone=$phone")->find();
            if($isHaveMember==null)
            {
                exit("member_null");
            }
            else
            {
                $result=M("member")->where("phone=$phone")->data(array('password'=>md5($password)))->save();
                if($result>0)
                {
                    exit("ok");
                }
                else
                {
                    exit("error");
                }
            }
        }
        else
        {
            exit("phone_null");
        }
    }
    public function pwd_pwd(){
        $this->assign("title","原密码修改");
        $this->display();
    }
    public function pwd_pay(){
        $member_id = $_COOKIE["member_id"];
        $member = M('member')->where("id=$member_id")->find();
        if(!empty($member))
        {
            $pay_password = $member['pay_password'];
            if(!empty($pay_password))
            {
                $caozuo = "edit";
            }
            else
            {
                $caozuo = "add";
            }
            $this->assign("caozuo",$caozuo);
        }
        $this->assign("title","二级密码");
        $this->display("MyCenter/password");
    }
}
