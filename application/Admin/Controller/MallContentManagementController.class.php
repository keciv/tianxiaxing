<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallContentManagementController extends BaseController {
	public function index(){
		$navigation_id=$_GET["navigation_id"];
		$this->assign('navigation_id',$navigation_id);
		$this->display();
	}
	public function getData(){
		$navigation_id = $_POST["navigation_id"];
		$page = $_POST['page'];
        $rows = $_POST['rows'];
		$controller = $_POST['controller'];
		if ($controller == "NewList" || $controller == "VideoList" || $controller == "PictureList")
        {
            $table="mall_new";
        }

        $count = M($table)->where("navigation_id='{$navigation_id}'")->count();

		$content=M($table)->where("navigation_id='{$navigation_id}'")->order('sequence_id desc')->limit(($page-1)*$rows,$rows)->select();
		
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
}