<?php
namespace APP\Controller;
class PasswordController extends BaseController {
    
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
    public function edit(){
        $memberID = $_COOKIE['memberID'];
        $old_password = $_POST['old_password'];
        $password = $_POST['password'];
        $passwordRepeat = $_POST['passwordRepeat'];
        if($memberID==null)
        {
            exit("login_null");
        }
        if($old_password==null)
        {
            exit("old_pwd_null");
        }
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
        
        $member = M("member")->where("id=$memberID")->find();
        if($member==null)
        {
            exit("member_null");
        }
        if(md5($OldPassword)!=$member["password"])
        {
            exit("pwd_error");
        }
        $result=M("member")->where("id=$memberID")->data(array('password'=>md5($password)))->save();
        if($result>0)
        {
            exit("ok");
        }
        else
        {
            exit("error");
        }
    }

    public function edit_pay(){
        $member_id = $_COOKIE['member_id'];
        $caozuo = $_POST['caozuo'];
        $password = $_POST['password'];
        $passwordRepeat = $_POST['passwordRepeat'];

        if(empty($passwordRepeat))
        {
            $result = array("code"=>"400","msg"=>"请再次输入新密码");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
        if($password!=$passwordRepeat)
        {
            $result = array("code"=>"400","msg"=>"两次密码输入不一致");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }

        $member = M("member")->where("id=$member_id")->find();
        if($member==null)
        {
            $result = array("code"=>"400","msg"=>"会员不存在");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
        if($caozuo=="edit")
        {
            $old_password = $_POST['old_password'];
            if(empty($password))
            {
                $result = array("code"=>"400","msg"=>"清输入新密码");
                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
            if(md5($old_password)!=$member["pay_password"])
            {
                $result = array("code"=>"400","msg"=>"原始支付密码输入不正确");
                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
        }

        $save_pay_pwd = M('member')->where("id=$member_id")->data(array("pay_password"=>md5($password)))->save();
        
        if($save_pay_pwd!==false||$save_pay_pwd!==0)
        {
            $result = array("code"=>"200","msg"=>"修改支付密码成功");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
        else
        {
            $result = array("code"=>"500","msg"=>"修改支付密码失败");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
    }

    public function yanzheng(){
        $member_id = $_COOKIE["member_id"];
        $password = $_POST["password"];

        $member = M("member")->field("id,pay_password")->where("id=$member_id")->find();
        if(!empty($member['pay_password']))
        {
            if($member['pay_password']==md5($password))
            {
                $result = array("code"=>"200","msg"=>"二级密码正确");
                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
            else
            {
                $result = array("code"=>"500","msg"=>"二级密码错误");
                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
        }
        else
        {
            $result = array("code"=>"404","msg"=>"尚未设置二级密码");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
    }
}
