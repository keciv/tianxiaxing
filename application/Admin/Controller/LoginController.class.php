<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{
	function index(){//展现登录页面
		$this->display();	
	}
	function check(){
		//检查用户名密码是否正确
		$admin=M('admin');
		$username=$_POST['username'];
		$password=$_POST['password'];
		$result=$admin->where("username='%s' and password='%s'",$username,$password)->find();
		$code=I('code');
		$verify = new \Think\Verify();
		if(check_code($code) === false)
		{
			$this->success("验证码错误");
			die;
		}
		if($result)
		{
			$_SESSION['admin']=$result;
			$this->redirect('__APP__/Index/index');
		}
		else
		{
			$this->success("用户名或密码不正确");
		}
		
	}
	function drop_out(){
		session('admin',null);
        session_unset();
        exit("ok");
	}
	public function verify(){
		ob_clean();
		$verify = new \Think\Verify();
		$verify->fontSize=20;
		$verify->useCurve=false;
		$verify->imageH=50;
		$verify->imageW=160;
		$verify->length=4;
		$verify->entry();
	
	}
}