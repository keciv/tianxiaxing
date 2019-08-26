<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class PackageController extends BaseController {
    public function index(){
		$this->display();
    }
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $count = M('package')
	        ->count();
        $content = M('package')
            ->order('id desc')
            ->limit(($page-1)*$rows,$rows)
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
			$package = M("package")->where("id=$id")->find();
			$this->assign('package',$package);
			$this->assign("caozuo",'edit');
			$this->assign("id",$id);
		}
		$this->display();
	}
	public function add(){
		$title=$_POST["title"];
		$description=$_POST["description"];
		$picture=$_POST["picture"];
		$price=$_POST["price"];
		$withdrawal=$_POST["withdrawal"];
		$integral=$_POST["integral"];
		$picture_div=$_POST["picture_div"];
		$content=$_POST["content"];
		$count=$_POST["count"];

		if($title==null)
		{
			exit("title_null");
		}
	
		// $last = M("package")->order('sequence_id desc')->find();
		$result=M("package")
			->data(array(
				'name'=>$title,
				'description'=>$description,
				'picture'=>$picture,
				'price'=>$price,
				'withdrawal'=>$withdrawal,
				'integral'=>$integral,
				'picture_more'=>$picture_div,
				'count'=>$count,
				'content'=>$content
				// 'sequence_id'=>$last['sequence_id']+1
			))
			->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function edit(){
		$id = $_POST['id'];
		$title=$_POST["title"];
		$description=$_POST["description"];
		$picture=$_POST["picture"];
		$price=$_POST["price"];
		$withdrawal=$_POST["withdrawal"];
		$integral=$_POST["integral"];
		$picture_div=$_POST["picture_div"];
		$content=$_POST["content"];
		$count=$_POST["count"];

		if($id==null)
		{
			exit("id_null");
		}
		if($title==null)
		{
			exit("title_null");
		}
		
		// $last = M("package")->order('sequence_id desc')->find();
		$result=M("package")
			->data(array(
				'name'=>$title,
				'description'=>$description,
				'picture'=>$picture,
				'price'=>$price,
				'withdrawal'=>$withdrawal,
				'integral'=>$integral,
				'picture_more'=>$picture_div,
				'count'=>$count,
				'content'=>$content
				// 'sequence_id'=>$last['sequence_id']+1
			))
			->where("id=$id")
			->save();
		if ($result!==false){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function delete(){
		$id=$_POST['id'];
        if($id!=null)
        {
            $result=M("package")->where("id in ({$id})")->delete();
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