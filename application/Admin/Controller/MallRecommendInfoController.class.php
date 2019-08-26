<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallRecommendInfoController extends BaseController {
	public function index(){
		$this->assign('caozuo','add');
		$this->display();
	}
	public function add(){
		$title=$_POST["title"];
		$content=$_POST["content"];
		$picture=$_POST["picture"];
		$time=$_POST["time"];
		if($title==null)
		{
			exit("title_null");
		}
		if($picture==null)
		{
			exit("picture_null");
		}
		if($time==null)
		{
			$time=date('Y-m-d');
		}
		$last = M("recommend_info")->order('sequence_id desc')->find();
		$result=M("recommend_info")->data(array('title'=>$title,'content'=>$content,'time'=>$time,'picture'=>$picture,'sequence_id'=>$last['sequence_id']+1))
	->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function info(){
        $id=$_GET['id'];
        $new = M("recommend_info")->where("id=$id")->find();
        $this->assign('new',$new);

        $this->assign("caozuo",'edit');
		$this->assign("id",$id);
        $this->display('MallRecommendInfo/index');
    }
	public function edit(){
		$id=$_POST["id"];
		$title=$_POST["title"];
		$content=$_POST["content"];
		$picture=$_POST["picture"];
		$time=$_POST["time"];
		if($id==null)
		{
			exit("id_null");
		}
		if($title==null)
		{
			exit("title_null");
		}
		if($picture==null)
		{
			exit("picture_null");
		}
		if($time==null)
		{
			$time=date('Y-m-d');
		}
		$result=M("recommend_info")->where("id=$id")->save(array('title'=>$title,'content'=>$content,'time'=>$time,'picture'=>$picture));
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
            $result=M("recommend_info")->where("id in ({$id})")->delete();
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