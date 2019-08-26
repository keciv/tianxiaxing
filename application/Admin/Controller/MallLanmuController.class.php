<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallLanmuController extends BaseController {
	public function index(){
		$data=M("mall_navigation")->where("parent_id=0")->select();
		if($data!=null)
		{
			$lanmeArray=array();
			$table="mall_navigation";
			$field="title";
			foreach ($data as $lanmu) {
				$children = getChildren($lanmu['id'],$table,$field);
				$array = array("id"=>$lanmu['id'],"text"=>$lanmu[$field],children=>$children);
				array_push($lanmeArray, $array);
			}
			exit(json_encode($lanmeArray));
		}
	}
	public function getController(){
		$id=$_POST['id'];
		if($id!=null)
		{
			$data=M("mall_navigation")->where("id={$id}")->find();
			if($data!=null)
			{
				exit($data["controller"]);
			}
			else
			{
				exit("data_null");
			}
		}
		else
		{
			exit("id_null");
		}
	}
	public function getData($id){
		$childrenID="";
        $lanmus=M("mall_navigation")->where("parent_id={$id}")->select();
        if($lanmus>0)
        {
            foreach($lanmus as $lanmu){
                $childrenID.="'".$lanmu['id']."'";
                $childrenID.=",";
                $childrenID.=getAllChildrenID($lanmu['id']);
            }
        }

		exit(json_encode($content));
	}
	
}