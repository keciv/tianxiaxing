<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallAdvertisementController extends BaseController {
	public function index(){
		$this->display();
	}
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $count = M("advertisement")->count();

		$content=M("advertisement")->order('sequence_id desc')->limit(($page-1)*$rows,$rows)->select();
		
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
	public function add(){
		$title = $_POST["title"];
		$link = $_POST["link"];
		$picture = $_POST["picture"];
		$location = $_POST["location"];
		$last = M("advertisement")->order('sequence_id desc')->find();
		$result = M("advertisement")->data(array('title'=>$title,'link'=>$link,'picture'=>$picture,'location'=>$location, 'sequence_id'=>$last['sequence_id']+1))
	->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function info(){
        $id=$_GET['id'];
		if($id==null)
		{
			$this->assign("caozuo",'add');
			$this->display('MallAdvertisement/info');
		}
		else
		{
			$advertisement = M("advertisement")->where("id=$id")->find();
			$this->assign('advertisement',$advertisement);
			$this->assign("caozuo",'edit');
			$this->assign("id",$id);
			$this->display('MallAdvertisement/info');
		}
        
    }
	public function edit(){
		$id=$_POST["id"];
		$title=$_POST["title"];
		$link=$_POST["link"];
		$picture=$_POST["picture"];
		$location = $_POST["location"];
		if($id==null)
		{
			exit("id_null");
		}
		$result=M("advertisement")->where("id=$id")->save(array('title'=>$title,'link'=>$link,'picture'=>$picture,'location'=>$location));
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
            $result=M("advertisement")->where("id in ({$id})")->delete();
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