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
        	$where = "worker_circle.$name='$value'";
        }
        $count = M('worker_circle')
	        ->Field('worker_circle.id,worker_circle.title,worker_circle.time,worker_circle.audit,worker_circle.recommend,member.username as member')
	        ->join('member on worker_circle.member_id=member.id')
	        ->where($where)
	        ->count();

        $content = M('onebeltoneway')
	        ->Field('onebeltoneway.id as id,onebeltoneway.title,onebeltoneway.integral,onebeltoneway.time,onebeltoneway.audit,onebeltoneway.recommend,member.username as member,onebeltoneway_sort.title as sort')
	        ->join('member on onebeltoneway.member_id=member.id')
	        ->join('onebeltoneway_sort on onebeltoneway.navigation_id=onebeltoneway_sort.id')
	        ->where($where)
	        ->order('onebeltoneway.sequence_id desc')
	        ->limit(($page-1)*$rows,$rows)
            ->select();

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
			$onebeltoneway = M("onebeltoneway")->where("id=$id")->find();
			$this->assign('onebeltoneway',$onebeltoneway);
			$this->assign("caozuo",'edit');
			$this->assign("id",$id);
		}
		$onebeltoneway_sort = array();
        $sort_id_one = getChildrenID(0,"onebeltoneway_sort");
        $sort_id_one = explode(',',$sort_id_one);
        foreach ($sort_id_one as $sort_id) {
            $sort = M("onebeltoneway_sort")->where("id=$sort_id")->find();
            $sort_id_two = getChildrenID($sort_id,"onebeltoneway_sort");
            $sort_id_two = explode(',',$sort_id_two);
            $array2 = array();
            foreach ($sort_id_two as $sort_id2) {
                $sort2 = M("onebeltoneway_sort")->where("id=$sort_id2")->find();
                array_push($array2, $sort2);
            }
            //print_r($array2);
            $array = array("sort"=>$sort,"sort_children"=>$array2);
            array_push($onebeltoneway_sort, $array);
        }
        $this->assign("onebeltoneway_sort",$onebeltoneway_sort);
		$this->display('MallOneTeltOneWay/OneTeltOneWayInfo');
	}
	public function add(){
		$title=$_POST["title"];
		$navigation_id=$_POST["navigation_id"];
		$picture=$_POST["picture"];
		$content=$_POST["content"];
		if($title==null)
		{
			exit("title_null");
		}
		if($navigation_id==null)
		{
			exit("navigation_id_null");
		}
		if($picture==null)
		{
			exit("picture_null");
		}
		$sequence_id = M('onebeltoneway')
                ->order('sequence_id desc')
                ->limit(1)
                ->getField('sequence_id');
		$result=M("onebeltoneway")->data(array('title'=>$title,'navigation_id'=>$navigation_id,'picture'=>$picture,'content'=>$content,'sequence_id'=>$sequence_id+1))->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function edit(){
		$id=$_POST["id"];
		$title=$_POST["title"];
		$navigation_id=$_POST["navigation_id"];
		$picture=$_POST["picture"];
		$content=$_POST["content"];
		if($id==null)
		{
			exit("id_null");
		}
		if($title==null)
		{
			exit("title_null");
		}
		if($navigation_id==null)
		{
			exit("navigation_id_null");
		}
		if($picture==null)
		{
			exit("picture_null");
		}
		
		$result=M("onebeltoneway")->where("id='{$id}'")->save(array('title'=>$title,'navigation_id'=>$navigation_id,'picture'=>$picture,'content'=>$content));
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
            $result=M("onebeltoneway")->where("id in ({$id})")->delete();
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
	public function audit(){
		$id=$_POST['id'];
        if($id!=null)
        {
        	$caozuo = $_POST['caozuo'];
        	$value = $_POST['value'];
			if($caozuo=='tongguo')
			{
				//分享汇积分
				$integral_rule = M('integral_rule')->order('id desc')->find();
				$share_platform_integral = $integral_rule['share_platform'];
				$time = date("Y-m-d H:i");
				$data_onebeltoneway = M("onebeltoneway")->where("id=$id")->find();
				$member_id = $data_onebeltoneway['member_id'];
				$share_info = M();
                $share_info->startTrans();
				//修改审核状态
				$edit_onebeltoneway=M("onebeltoneway")->where("id=$id")->save(array('audit'=>$value,'integral'=>$share_platform_integral));
				//会员添加积分
				$give_audit_integral=M("member")->where("id=$member_id")->setInc('integral', $share_platform_integral);
				//添加积分记录
				$add_audit_record=M("integral_record")->data(array('integral'=>$share_platform_integral,'time'=>$time,"member_id"=>$member_id,"source"=>"共享平台","description"=>"共享平台发布信息审核通过","type"=>"收入"))->add();
				//添加到消息
            	$add_message = M('message')->data(array("user_id"=>$member_id,"category"=>"3","message"=>"恭喜签到获赠{$share_platform_integral}积分","url"=>"MyIntegral/search.html?id={$add_audit_record}"))->add();
				if($add_audit_record>0 && $edit_onebeltoneway!==false && $add_message>0)
                {
                    $share_info->commit();
                    exit("ok");
                }
                else
                {
                    $share_info->rollback();
                    exit("error");
                }
			}
			else
			{
				$result=M("onebeltoneway")->where("id=$id")->save(array('audit'=>$value));
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