<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class StoreController extends BaseController {
    public function index(){
		$this->display();
    }
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $count = M('store')->count();
        $store = M("store")
        	->order('id desc')
        	->select();
        
        if(empty($store))
		{
			$store = array();
		}

		// $result = array("total"=>$count,"rows"=>$content,"footer"=>$footer);
		$result = array("total"=>$count,"rows"=>$store);
		$result = json_encode($result);

		exit($result);
	}
	public function info(){
		$id = $_POST["id"];
		if($id==null)
		{
			exit(json_encode(array("status"=>"id_null")));
		}
		$store = M("store")
			->where("id=$id")
			->find();
		if ($store>0){
			exit(json_encode($store));
		}else {
			exit(json_encode(array("status"=>"data_null")));
		}
	}
	public function add(){
		$name = $_POST["name"];
		$yunfei = $_POST["yunfei"];
		$mianyou = $_POST["mianyou"];
		if(empty($name))
		{
			exit("name_null");
		}
		if($yunfei<0)
		{
			exit("yunfei_null");
		}
		if($mianyou<0)
		{
			exit("mianyou_null");
		}
		
		$result = M("store")
			->data(array('name'=>$name,'yunfei'=>$yunfei,'mianyou'=>$mianyou))
			->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function edit(){
		$id=$_POST["id"];
		$name = $_POST["name"];
		$yunfei = $_POST["yunfei"];
		$mianyou = $_POST["mianyou"];
		if($id==null)
		{
			exit("id_null");
		}
		if(empty($name))
		{
			exit("name_null");
		}
		if($yunfei<0)
		{
			exit("yunfei_null");
		}
		if($mianyou<0)
		{
			exit("mianyou_null");
		}
		
		$result=M("store")->where("id=$id")->save(array('name'=>$name,'phone'=>$phone,'address'=>$address));
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
            $result=M("store")->where("id in ({$id})")->delete();
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

	public function getStoreList(){
		$store = M("store")->field("id,name as text")->order("id desc")->select();
		$result = json_encode($store);
		exit($result);
	}
}