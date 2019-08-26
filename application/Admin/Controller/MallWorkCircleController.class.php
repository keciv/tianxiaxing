<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallWorkCircleController extends BaseController {
    public function index(){
		$this->display();
    }
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $name = $_POST['Search'];
        $value = $_POST['Value'];
        if($name!=null&&$value!=null)
        {
        	$where = "worker_circle.$name like '%$value%'";
        }
        $count = M('worker_circle')
	        ->Field('worker_circle.id')
	        ->join('member on worker_circle.member_id=member.id','LEFT')
	        ->where($where)
	        ->count();

        $content = M('worker_circle')
	        ->Field('worker_circle.id,worker_circle.title,worker_circle.create_time,worker_circle.audit,worker_circle.recommend,worker_circle.member_id,member.username as member')
	        ->join('member on worker_circle.member_id=member.id','LEFT')
	        ->where($where)
	        ->order('worker_circle.sequence_id desc')
	        ->limit(($page-1)*$rows,$rows)
            ->select();
        if($content!=null)
        {
        	foreach ($content as $key => $value) {
        		if($value['member']==null)
        		{
        			$content[$key]['member'] = "会员不存在";
        		}
        		if($value['member_id']==0)
        		{
        			$content[$key]['member'] = "管理员";
        		}
        	}
        }
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
	
	public function info(){
		$id=$_GET['id'];
		if($id==null)
		{
			$this->assign("caozuo",'add');
		}
		else
		{
			$circle = M("worker_circle")->where("id=$id")->find();
			$this->assign('circle',$circle);
			$this->assign("caozuo",'edit');
			$this->assign("id",$id);
		}

		$this->display('MallWorkCircle/info');
	}
	public function add(){
		$title=$_POST["title"];
		$content=$_POST["content"];
		if($title==null)
		{
			exit("title_null");
		}
		$sequence_id = M('worker_circle')
                ->order('sequence_id desc')
                ->limit(1)
                ->getField('sequence_id');
		$result=M("worker_circle")->data(array('title'=>$title,'content'=>$content,'sequence_id'=>$sequence_id+1))->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function edit(){
		$id=$_POST["id"];
		$title=$_POST["title"];
		$content=$_POST["content"];
		if($id==null)
		{
			exit("id_null");
		}
		if($title==null)
		{
			exit("title_null");
		}
		
		$result=M("worker_circle")->where("id=$id")->save(array('title'=>$title,'content'=>$content));
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
            $result=M("worker_circle")->where("id in ({$id})")->delete();
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
	
	public function is_true(){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$value=$_POST['value'];
        if($id!=null)
        {
            $result=M("worker_circle")->where("id=$id")->save(array("$name"=>$value));
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
            $result=M("onebeltoneway")->where("id=$id")->save(array("$name"=>$value));
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