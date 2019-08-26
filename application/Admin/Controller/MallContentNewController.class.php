<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallContentNewController extends BaseController {
	public function index(){
		$navigation_id=$_GET["navigation_id"];
		if($navigation_id!=null)
		{
			$navigation = M('mall_navigation')->where("id=$navigation_id")->find();
			$this->assign('navigation',$navigation);
			$this->assign('navigation_id',$navigation_id);
			$this->assign('caozuo','add');
			$this->display();
		}
	}
	public function add(){
		$navigation_id=$_POST["navigation_id"];
		$title=$_POST["title"];
		$author=$_POST["author"];
		$source=$_POST["source"];
		$content=$_POST["content"];
		$picture=$_POST["picture"];
		$video=$_POST["video"];
		$video_url=$_POST["video_url"];
		$time=$_POST["time"];
		if($navigation_id==null)
		{
			exit("id_null");
		}
		if($time==null)
		{
			$time=date('Y-m-d');
		}
		$last = M("mall_new")->order('sortid desc')->find();
		$result=M("mall_new")->data(array('title'=>$title,'author'=>$author,'source'=>$source,'picture'=>$picture,'content'=>$content,'video'=>$video,'video_url'=>$video_url,'navigation_id'=>$navigation_id,'time'=>$time,'sequence_id'=>$last['sequence_id']+1))
	->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function info(){

        $id=$_GET['id'];
        $new = M("mall_new")->where("id='{$id}'")->find();
        $this->assign('new',$new);

        $navigation = M('mall_navigation')->where("id={$new['navigation_id']}")->find();
		$this->assign('navigation',$navigation);

        $this->assign("caozuo",'edit');
		$this->assign("id",$id);
		// print_r($id);
        $this->display('MallContentNew/index');
    }
	public function edit(){
		$id=$_POST["id"];
		$title=$_POST["title"];
		$author=$_POST["author"];
		$source=$_POST["source"];
		$content=$_POST["content"];
		$picture=$_POST["picture"];
		$video=$_POST["video"];
		$video_url=$_POST["video_url"];
		$time=$_POST["time"];
		if($id==null)
		{
			exit("id_null");
		}
		if($time==null)
		{
			$time=date('Y-m-d');
		}
		$result=M("mall_new")->where("id='{$id}'")->save(array('title'=>$title,'author'=>$author,'source'=>$source,'picture'=>$picture,'content'=>$content,'video'=>$video,'video_url'=>$video_url,'time'=>$time));
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
            $result=M("mall_new")->where("id in ({$id})")->delete();
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