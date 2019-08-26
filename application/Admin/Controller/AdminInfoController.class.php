<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class AdminInfoController extends BaseController {
	public function index(){
		$this->display();
	}
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];

        $count = M("admin")->count();

		$content=M("admin")->where("quanxian=1")->order('id desc')->limit(($page-1)*$rows,$rows)->select();
		$str.="{";
		$str.="'total'";
		$str.=":";
		$str.="'".$count."'";
		$str.=",";
		$str.="'rows'";
		$str.=":";
		if($content==null)
		{
			$content="[]";
		}
		else
		{
			$content=json_encode($content);
		}
		$str.=$content;
		$str.="}";
		$str= str_replace("'","\"",$str);
		exit($str);
	}
	public function add(){
		$username=$_POST["username"];
		$password=$_POST["password"];
		if($username==null)
		{
			exit("username_null");
		}
		if($password==null)
		{
			exit("password_null");
		}
		$last = M("admin")->order('id desc')->find();
		$result=M("admin")->data(array('username'=>$username,'password'=>$password))
	->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function info(){
        $id=$_GET['id'];
		if($id==null)
		{
			$this->assign("caozuo",'add');
			$this->display('AdminInfo/AdminInfo');
		}
		else
		{
			$admin = M("admin")->where("id='{$id}'")->find();
			$this->assign('admin',$admin);
			$this->assign("caozuo",'edit');
			$this->assign("id",$id);
			$this->display('AdminInfo/AdminInfo');
		}
        
    }
	public function edit(){
		$id=$_POST["id"];
		$username=$_POST["username"];
		$password=$_POST["password"];
		$time=date('Y-m-d');
		if($id==null)
		{
			exit("id_null");
		}
		if($username==null)
		{
			exit("username_null");
		}
		if($password==null)
		{
			exit("password_null");
		}
		$result=M("admin")->where("id={$id}")->save(array('username'=>$username,'password'=>$password,'time'=>$time));
		if(false !== $result || 0 !== $result)
		{
			exit("ok");
		}
		else
		{
			exit("error");
		}
    }
	public function delete(){
		$id=$_POST['id'];
        if($id!=null)
        {
            $result=M("admin")->where("id in ({$id})")->delete();
            if ($result>0) {
                exit("ok");
            }else {
                exit("error");
            }
        }
        else
        {
            exit("id_null");
        }
    }
}