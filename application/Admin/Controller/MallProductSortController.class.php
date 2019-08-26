<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallProductSortController extends BaseController {
    public function index(){
		$this->display();
    }
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $id = $_POST['id'];
        if($id==null)
        {
        	$id=0;
        }
        $yijisort=M("product_sort")->where("parent_id={$id}")->order('sequence_id desc')->select();
        if($yijisort!=null)
        {
        	$retureArray=array();
        	foreach ($yijisort as $yijisort) {
        		$array=array("id"=>$yijisort['id'],"sort_name"=>$yijisort['sort_name'],"description"=>$yijisort['description'],"index_recommend"=>$yijisort['index_recommend'],"_parentId"=>$yijisort['parent_id'],"is_sale"=>$yijisort['is_sale'],"state"=>"closed");
        		array_push($retureArray, $array);
        	}
        	exit(json_encode($retureArray));
        }
	}
	public function getProductSortList(){
		$id = $_POST['id'];
		$is_root = $_POST['is_root'];
		$typeArray = array();
		if($id==0&&$is_root==1)
		{
			$array = array("id"=>$id,"text"=>"一级栏目","children"=>"");
			array_push($typeArray, $array);
		}
		
		$data = M("product_sort")->where("parent_id=$id")->select();
		if($data != null){
			foreach ($data as $type) {
				$array = array("id"=>$type['id'],"text"=>$type["sort_name"],"state"=>"closed","children"=>"");
				array_push($typeArray, $array);
			}
			exit(json_encode($typeArray));
		}
		else
		{
			if(count($typeArray)>0)
			{
				exit(json_encode($typeArray));
			}
			else
			{
				exit("[]");
			}
		}
	}

	// public function getProductSortList(){
	// 	$array=array("id"=>"0","text"=>"一级栏目","children"=>"");
	// 	$data=M("product_sort")->where("parent_id=0")->select();
	// 	if($data!=null)
	// 	{
	// 		$typeArray=array();
	// 		$table="product_sort";
	// 		$field="sort_name";
	// 		array_push($typeArray, $array);
	// 		foreach ($data as $type) {
	// 			$children = getChildren($type['id'],$table,$field);
	// 			$array = array("id"=>$type['id'],"text"=>$type[$field],"children"=>$children);
	// 			array_push($typeArray, $array);
	// 		}
	// 		print_r($typeArray);
	// 		exit(json_encode($typeArray));
	// 	}
	// 	else
	// 	{
	// 		exit("[".json_encode($array)."]");
	// 	}
	// }
	public function info(){
		$id=$_POST["id"];
		if($id==null)
		{
			exit(json_encode(array("status"=>"id_null")));
		}
		$productType = M("product_sort")->where("id='{$id}'")->find();
		if ($productType>0){
			exit(json_encode($productType));
		}else {
			exit(json_encode(array("status"=>"data_null")));
		}
	}
	public function add(){
		$sort_name=$_POST["sort_name"];
		$Description=$_POST["Description"];
		$parent_id=$_POST["parent_id"];
		$picture=$_POST["picture"];
		if($sort_name==null)
		{
			exit("sort_name_null");
		}
		if($parent_id==null)
		{
			exit("parent_id_null");
		}
		$last = M("product_sort")->order('sequence_id desc')->find();
		$result=M("product_sort")->data(array('sort_name'=>$sort_name,'parent_id'=>$parent_id,'picture'=>$picture,'description'=>$Description,'sequence_id'=>$last['sequence_id']+1))
	->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function edit(){
		$id=$_POST["id"];
		$sort_name=$_POST["sort_name"];
		$Description=$_POST["Description"];
		$parent_id=$_POST["parent_id"];
		$picture=$_POST["picture"];
		if($id==null)
		{
			exit("id_null");
		}
		if($sort_name==null)
		{
			exit("sort_name_null");
		}
		if($parent_id==null)
		{
			exit("parent_id_null");
		}
		$result=M("product_sort")->where("id='{$id}'")->save(array('sort_name'=>$sort_name,'parent_id'=>$parent_id,'picture'=>$picture,'description'=>$Description));
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
            $result=M("product_sort")->where("id in ({$id})")->delete();
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
	public function recommend(){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$value=$_POST['value'];
        if($id!=null)
        {
            $result=M("product_sort")->where("id=$id")->save(array("$name"=>$value));
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
	public function sale(){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$value=$_POST['value'];
        if($id!=null)
        {
            $result = M("product_sort")->where("id=$id")->save(array("$name"=>$value));
            $children_sort_id = getAllChildrenID($id,"product_sort");
	        $children_sort_id = "'$id',".$children_sort_id;
	        $children_sort_id = substr($children_sort_id,0,mb_strlen($children_sort_id)-1);
	        //print_r($children_sort_id);
            $product_result = M('product')->where("sort_id in ($children_sort_id)")->save(array("$name"=>$value));
            if($result!==false&&$product_result!==false){
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
	public function sequence(){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$value=$_POST['value'];
        if($id!=null)
        {
        	//查找当前分类
        	$sort =  M("product_sort")->where("id=$id")->find();
        	if($sort!==null)
        	{
        		//当前序号
        		$sequence_id = $sort['sequence_id'];
        		$parent_id = $sort['parent_id'];
        		//置顶
        		if($value==0)
        		{
        			//目标
        			$target = M("product_sort")->where("parent_id=$parent_id")->order("sequence_id desc")->find();
        		}
        		//上移
        		else if($value==1)
        		{
        			//目标
        			$target = M("product_sort")->where("parent_id=$parent_id and sequence_id>$sequence_id")->order("sequence_id asc")->find();
        		}
        		//下移
        		else if($value==2)
        		{
        			//目标
        			$target = M("product_sort")->where("parent_id=$parent_id and sequence_id>$sequence_id")->order("sequence_id desc")->find();
        		}
        		//底部
        		else if($value==3)
        		{
        			//目标
        			$target = M("product_sort")->where("parent_id=$parent_id")->order("sequence_id asc")->find();
        		}
        	}
        	$target_id = $target['id'];
        	$sequence_target = $target['sequence_id'];
        	$transaction = M();
            $transaction->startTrans();
        	$edit_sort = M('product_sort')->where("id=$id")->setField("sequence_id",$sequence_target);

            $edit_target = M('product_sort')->where("id=$target_id")->setField("sequence_id",$sequence_id);

            if($edit_sort!==false && $edit_target!==false){
            	$transaction->commit();
                exit("ok");
            }
            else {
            	$transaction->rollback();
                exit("error");
            }
        }
        else
        {
            exit("id_null");
        }
	}
}