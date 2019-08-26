<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallProductModelController extends BaseController {
    public function index(){
		$this->display();
    }
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $model = M("product_model")->order('id desc')->select();
        exit(json_encode($model));
	}
	public function getModelList(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];

        $attrArray = array();
        $attr = M("product_model")->order('sequence desc')->select();
        if($attr!=null)
        {
        	foreach ($attr as $attr) {
        		$array = array("id"=>$attr['id'],"text"=>$attr['model']);
        		array_push($attrArray, $array);
        	}
        }
        exit(json_encode($attrArray));
	}
	public function info(){
		$id=$_POST["id"];
		if($id==null)
		{
			exit(json_encode(array("status"=>"id_null")));
		}
		$productType = M("product_model")->where("id='{$id}'")->find();
		if ($productType>0){
			exit(json_encode($productType));
		}else {
			exit(json_encode(array("status"=>"data_null")));
		}
	}
	public function add(){
		$model=$_POST["model"];

		if($model==null)
		{
			exit("model_null");
		}

		$last = M("product_model")->order('sequence desc')->find();
		$result=M("product_model")->data(array('model'=>$model,'sequence'=>$last['sequence']+1))
	->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function edit(){
		$id=$_POST["id"];
		$model = $_POST["model"];
		
		if($id==null)
		{
			exit("id_null");
		}
		if($model==null)
		{
			exit("model_null");
		}
		
		$result=M("product_model")->where("id='{$id}'")->save(array('model'=>$model));
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
            $result=M("product_model")->where("id in ({$id})")->delete();
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
	public function CharacteristicInfo($id){
		$characteristic = M("product")->where("id=$id")->getField("spec");
		$this->assign('characteristic',$characteristic);
		$this->assign('id',$id);
		$this->display('MallProduct/Characteristic');
	}
	public function save_Characteristic(){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$value=$_POST['value'];
        if($id!=null)
        {
        	$str="[";
        	for($i=0;$i<count($value);$i++)
        	{
        		$str.="{";
        		for($j=0;$j<count($name);$j++)
        		{

        			$str.="'".$name[$j]."'";
    				$str.=":";
        			$str.="'".$value[$i][$j]."'";
        			$str.=",";
        		}
        		$str= substr($str,0,$str.length-1);
        		$str.="}";
	        	$str.=",";
        	}
        	$str= substr($str,0,$str.length-1);
			$str= str_replace("'","\"",$str);
        	$str.="]";
			
			$result=M("product")->where("id='{$id}'")->save(array("characteristic"=>$str));
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