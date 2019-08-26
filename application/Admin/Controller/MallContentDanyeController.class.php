<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallContentDanyeController extends BaseController {
	public function index(){
		$navigation_id=$_GET["navigation_id"];
		if($navigation_id!=null)
		{
			$data = M("mall_danye")->where("navigation_id='{$navigation_id}'")->find();
			$this->assign('data',$data);
			$this->assign('navigation_id',$navigation_id);
			$this->display();
		}
	}
	public function save(){
		$navigation_id=$_POST["navigation_id"];
		if($navigation_id!=null)
		{
			$content=$_POST["content"];
			$isHaveData = M("mall_danye")->where("navigation_id='{$navigation_id}'")->find();

			if($isHaveData==null)
			{	
				$result=M("mall_danye")->data(array('navigation_id'=>$navigation_id,'content'=>$content))->add();
				if($result!=null)
				{
					exit("ok");
				}
				else
				{
					exit("error");
				}
			}
			else
			{
				$result=M("mall_danye")->where("navigation_id='{$navigation_id}'")->save(array('content'=>$content));
				if(false !== $result || 0 !== $result)
				{
					exit("ok");
				}
				else
				{
					exit("error");
				}
			}
			
		}
	}
}