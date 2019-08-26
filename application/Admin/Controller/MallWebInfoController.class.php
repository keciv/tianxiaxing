<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallWebInfoController extends BaseController {
    public function index(){
		$webinfo=M("mall_webinfo")->order("id desc")->find();
		$this->assign("webinfo",$webinfo);
    	$this->display();
    }
	public function save(){
		$id=$_POST['id'];
		$title=$_POST['Title'];
		$keywords=$_POST['Keywords'];			
		$description=$_POST['Description'];
		if($id!=null)
		{
			$result=M("mall_webinfo")->where("id={$id}")->save(array('title'=>$title,'keywords'=>$keywords,description=>$description));	
		}
		else
		{
			$result=M("mall_webinfo")->data(array('title'=>$title,'keywords'=>$keywords,description=>$description))->add();	
		}
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
    }
}