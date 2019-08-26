<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallProductController extends BaseController {
    public function index(){
		$this->display();
    }
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $count = M('product a')
	        ->Field('a.id as id')
	        ->join('product_sort b on a.sort_id=b.id',"left")
	        ->join('store c on a.store_id=c.id',"left")
	        ->count();
        $content = M('product a') 
	        ->Field('a.id,a.title,a.recommend,a.is_sale,b.sort_name,c.name store_name')
	        ->join('product_sort b on a.sort_id=b.id',"left")
	        ->join('store c on a.store_id=c.id',"left")
            ->order('a.sequence_id desc')->limit(($page-1)*$rows,$rows)
            ->select();
		//$content=M("product")->order('sequence_id desc')->limit(($page-1)*$rows,$rows)->select();
        if(empty($content))
        {
        	$content = array();
        }
        $result = array("total"=>$count,"rows"=>$content);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
	}
	
	public function info(){
		$id=$_GET['id'];
		if($id==null)
		{
			$this->assign("caozuo",'add');
		}
		else
		{
			$product = M("product")->where("id=$id")->find();
			$this->assign('product',$product);
			$this->assign("caozuo",'edit');
			$this->assign("id",$id);
		}
		$this->display('MallProduct/ProductInfo');
	}
	public function add(){
		$title=$_POST["title"];
		$description=$_POST["description"];
		$picture=$_POST["picture"];
		$picturemore=$_POST["picturemore"];
		$content=$_POST["content"];
		$sort_id=$_POST["sort_id"];
		$store_id=$_POST["store_id"];

		$youke_price = $_POST["youke_price"];
		$huiyuan_price = $_POST["huiyuan_price"];
		$dianpu_price = $_POST["dianpu_price"];

		$reserve = $_POST["reserve"];
		
		$youke_unit = $_POST["youke_unit"];
		$huiyuan_unit = $_POST["huiyuan_unit"];
		$dianpu_unit = $_POST["dianpu_unit"];

		$fenxiao1 = $_POST["fenxiao1"];
		$fenxiao2 = $_POST["fenxiao2"];
		if($title==null)
		{
			exit("title_null");
		}
		if($sort_id==null)
		{
			exit("sort_id_null");
		}
		if($store_id==null)
		{
			exit("store_id_null");
		}
		if($reserve==null)
		{
			exit("reserve_null");
		}
		$picturemore = strip_tags($picturemore, '<img>' );
		$last = M("product")->order('sequence_id desc')->find();
		$result=M("product")
		->data(array(
			'title'=>$title,
			'description'=>$description,
			'picture'=>$picture,
			'picturemore'=>$picturemore,
			'content'=>$content,
			'sort_id'=>$sort_id,
			'store_id'=>$store_id,
			'reserve'=>$reserve,
			'youke_price'=>$youke_price,
			'huiyuan_price'=>$huiyuan_price,
			'dianpu_price'=>$dianpu_price,
			'youke_unit'=>$youke_unit,
			'huiyuan_unit'=>$huiyuan_unit,
			'dianpu_unit'=>$dianpu_unit,
			'fenxiao1'=>$fenxiao1,
			'fenxiao2'=>$fenxiao2,
			'sequence_id'=>$last['sequence_id']+1
		))
		->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function edit(){
		$id=$_POST["id"];
		$title=$_POST["title"];
		$description=$_POST["description"];
		$picture=$_POST["picture"];
		$picturemore=$_POST["picturemore"];
		$content=$_POST["content"];
		$sort_id=$_POST["sort_id"];
		$store_id=$_POST["store_id"];
		$reserve=$_POST["reserve"];

		$youke_price = $_POST["youke_price"];
		$huiyuan_price = $_POST["huiyuan_price"];
		$dianpu_price = $_POST["dianpu_price"];
		
		$youke_unit = $_POST["youke_unit"];
		$huiyuan_unit = $_POST["huiyuan_unit"];
		$dianpu_unit = $_POST["dianpu_unit"];

		$fenxiao1 = $_POST["fenxiao1"];
		$fenxiao2 = $_POST["fenxiao2"];
		if($id==null)
		{
			exit("id_null");
		}
		if($title==null)
		{
			exit("title_null");
		}
		if($sort_id==null)
		{
			exit("sort_id_null");
		}
		if($store_id==null)
		{
			exit("store_id_null");
		}
		if($reserve==null)
		{
			exit("reserve_null");
		}

		$picturemore = strip_tags($picturemore, '<img>' );
		$result=M("product")->where("id='{$id}'")
		->save(array(
			'title'=>$title,
			'description'=>$description,
			'picture'=>$picture,
			'picturemore'=>$picturemore,
			'content'=>$content,
			'sort_id'=>$sort_id,
			'store_id'=>$store_id,
			'reserve'=>$reserve,
			'youke_price'=>$youke_price,
			'huiyuan_price'=>$huiyuan_price,
			'dianpu_price'=>$dianpu_price,
			'youke_unit'=>$youke_unit,
			'huiyuan_unit'=>$huiyuan_unit,
			'dianpu_unit'=>$dianpu_unit,
			'fenxiao1'=>$fenxiao1,
			'fenxiao2'=>$fenxiao2
		));
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
            $result=M("product")->where("id in ({$id})")->delete();
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
	public function Attributes_info(){
		$id=$_GET['id'];
		$Attributes=$_GET['Attributes'];
        if($id!=null&&$Attributes!=null)
        {
        	$data=M("product")->where("id={$id}")->find();
        	if($data!=null)
        	{
        		$content=$data[$Attributes];
        		$this->assign('id',$id);
	        	$this->assign('Attributes',$Attributes);
	        	$this->assign('content',$content);
        	}
        	if($Attributes=="characteristic")
        	{
        		$this->CharacteristicInfo($id,$data['sort_id']);
        	}
        	else
        	{
        		$this->display('MallProduct/Attributes');
        	}
        }
	}
	public function save_Attributes(){
		$id=$_POST['id'];
		$Attributes=$_POST['Attributes'];
		$content=$_POST['content'];
        if($id!=null&&$Attributes!=null)
        {
        	$data=M("product")->where("id={$id}")->find();
        	if($data!=null)
        	{
        		$result=M("product")->where("id='{$id}'")->save(array("{$Attributes}"=>$content));
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
	public function CharacteristicInfo($id){
		// print_r($id);
		$product = M("product")
			->Field('id,spec,model_id,attr,spec_picture')
			->where("id=$id")
			->find();
		$model = M('product_model')->where("id={$product['model_id']}")->getField('model');
		$product = array("id"=>$product['id'],"model_id"=>$product['model_id'],"model"=>$model,"spec"=>$product['spec'],"attr"=>$product['attr'],"spec_picture"=>$product['spec_picture']);
		$this->assign('product',$product);
		// print_r($product);
		//产品规格
		$spec = M('product_spec')->where("model_id={$product['model_id']}")->select();
		if($spec!=null)
		{
			$array_spec = array();
			foreach ($spec as $key => $value) {
				$spec_key = $value['spec'];
				$spec_value = explode(",",$value['values']);
				$array = array($spec_key=>$spec_value);
				array_push($array_spec, $array);
			}
			$this->assign('model_spec',json_encode($array_spec));
		}
		//产品规格图
		//产品属性
		$attr = M('product_attr')->where("model_id={$product['model_id']}")->select();
		if($attr!=null)
		{
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
				$array = array($attr_key=>$attr_value,"entry_mode"=>$value["entry_mode"]);
				array_push($array_attr, $array);
			}
			// print_r($array_attr);
			$this->assign('model_attr',json_encode($array_attr));
			// $this->assign('attr',$array_attr);
		}
		$this->display('MallProduct/Characteristic');
	}
	public function save_Characteristic(){
		$id=$_POST['id'];
		$model_id=$_POST['model_id'];
		$name=$_POST['name'];
		$value=$_POST['value'];
		$spec_picture=$_POST['spec_picture'];
		$attr=$_POST['attr'];
		// print_r(json_encode($spec_picture));
		// exit();
        if($id!=null)
        {
        	//产品各规格
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
			//产品各规格图片
        	// print_r($str);
        	// print_r($spec_picture);
        	// print_r($attr);
        	// print_r($model_id);
			$result=M("product")
				->where("id='{$id}'")
				->data(array(
					"spec"=>$str,
					"spec_picture"=>json_encode($spec_picture,JSON_UNESCAPED_UNICODE),
					"attr"=>json_encode($attr,JSON_UNESCAPED_UNICODE),
					"model_id"=>$model_id
				))
				->save();
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
	public function is_true(){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$value=$_POST['value'];
        if($id!=null)
        {
            $result=M("product")->where("id=$id")->save(array("$name"=>$value));
            if(false !== $result || 0 !== $result){
                exit("ok");
            }
            else {
                exit("error");
            }
        }
        else
        {
            exit("id_null");
        }
	}
}