<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallCharacteristicController extends BaseController {
	public function index(){
		$sort_id=$_GET['sort_id'];
		$this->assign("sort_id",$sort_id);
		$this->display();
	}
	public function getData(){
		$sort_id = $_POST['sort_id'];
		$content=M("product_sort")->where("id={$sort_id}")->find();
		if($content!=null)
		{
			$characeristic=$content['characteristic'];
			exit($characeristic);
		}
	}
	public function get_model_spec(){
		$model_id = $_GET['model_id'];
		$content = M("product_spec")
			->field("spec,values")
			->where("model_id=$model_id")
			->select();
		exit(json_encode($content));
		// if($content!=null)
		// {
		// 	$characeristic = $content['values'];
		// 	exit($characeristic);
		// }
	}
	public function get_model_attr(){
		$model_id = $_GET['model_id'];
		$attr = M("product_attr")
			->field("attr,values,entry_mode")
			->where("model_id=$model_id")
			->select();
		$array_attr = array();
		foreach ($attr as $key => $value) {
			$attr_key = $value['attr'];
			if($value['entry_mode']==2)
			{
				$attr_value = explode(",",$value['values']);
			}
			else
			{
				$attr_value = $value['values'];
			}
			$obj = array($attr_key=>$attr_value,"entry_mode"=>$value['entry_mode']);
			array_push($array_attr, $obj);
		}
		exit(json_encode($array_attr));
	}
	public function save(){
		$sort_id=$_POST['sort_id'];
		$data=$_POST['data'];
		if($data!=null)
		{
			$str="[";
			for($a=0;$a<count($data);$a++)
			{
				$array=$data[$a];
				//替换回车换行
				$order=array("\r\n","\n","\r");
				$replace='<br>';
				$array[3]=str_replace($order,$replace,$array[3]); 

				$str.="{";
				$str.="'fangshi'";
				$str.=":";
				$str.="'".$array[0]."'";
				$str.=",";
				$str.="'showImg'";
				$str.=":";
				$str.="'".$array[1]."'";
				$str.=",";
				$str.="'name'";
				$str.=":";
				$str.="'".$array[2]."'";
				$str.=",";
				$str.="'value'";
				$str.=":";
				$str.="'".$array[3]."'";
				$str.="}";
				$str.=",";
				$msg.=$array[$b];
			}
			$str= substr($str,0,$str.length-1);
			$str= str_replace("'","\"",$str);
			$str.="]";
		}
		$result=M("product_sort")->where("id='{$sort_id}'")->data(array('characteristic'=>$str))->save();
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
		$sort_id=$_GET['sort_id'];

		$content=M("product_sort")->where("id={$sort_id}")->find();
		if($content!=null)
		{
			$sort_name=$content['sort_name'];
			$this->assign("sort_name",$sort_name);
			$characteristic=$content['characteristic'];
			$this->assign("characteristic",$characteristic);
		}
		$this->assign("sort_id",$sort_id);
		$this->display();
	}
}
