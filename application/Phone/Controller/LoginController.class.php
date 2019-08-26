<?php
namespace Phone\Controller;
class LoginController extends BaseController{
    public function index(){
        $this->display();
    }
	public function login(){
		$username = $_POST['username'];
		$password = $_POST['password'];
        $password = md5($password);
        if($username==null)
        {
            exit("username_null");
        }
        if($password==null)
        {
            exit("password_null");
        }
		//用户是否存在
        $member=M('member')->where("username='$username' or phone='$username'")->find();
        //存在
        if($member!=null)
        {
            //判断密码是否一致
            if($password==$member["password"])
            {
                cookie('member_id',$member["id"],3600*24*7);
                exit("ok");
            }
            else
            {
                exit("error");
            }
        }
        else
        {
            exit("member_null");
        }
	}
    
	public function drop_out(){
		cookie("memberID", NULL);
        header('location:http://www.jythjc.com/login.html');
        exit();
	}
	
}