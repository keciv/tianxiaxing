<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MemberIntegralController extends BaseController {
    public function index(){
    	$this->display();
    }
	public function getData(){
    	$page = $_POST['page'];
        $rows = $_POST['rows'];

        // $name = $_POST['parameterType'];
        // $value = $_POST['parameter'];
        // if($name!=null&&$value!=null)
        // {
        // 	$where = "$name='$value'";
        // }
        $phone = $_POST['phone'];
        if($phone!=null)
        {
        	$where = "b.phone='{$phone}'";
        }
        $time = $_POST['time'];
        if($time!=null)
        {	if($phone==null)
        	{
        		$where = "a.create_time like '%{$time}%'";
        	}
        	else
        	{
        		$where .= " and a.create_time like '%{$time}%'";
        	}
        }

        $count = M("integral_record as a")
        	->field("a.integral,a.create_time,a.source,a.description,a.type,b.username,b.phone")
			->join("member as b on a.member_id = b.id")
			->where($where)
			->count();

		$content = M("integral_record as a")
			->field("a.integral,a.create_time,a.source,a.description,a.type,b.username,b.phone")
			->join("member as b on a.member_id = b.id")
			->where($where)
			->order('a.id desc')
			->limit(($page-1)*$rows,$rows)
			->select();
        if($content==null)
        {
            $content = array();
        }

        if($where!=null)
        {
            $where_add = $where." and a.type=1";
        }
        else
        {
            $where_add = "a.type=1";
        }
        $total = M("integral_record as a")
            ->field("a.integral,a.create_time,a.source,a.description,a.type,b.username,b.phone")
            ->join("member as b on a.member_id = b.id")
            ->where($where_add)
            ->sum('a.integral');
        if($total==null)
        {
            $total = 0;
        }

        if($where!=null)
        {
            $where_min = $where." and a.type=0";
        }
        else
        {
            $where_min = "a.type=0";
        }
        $withdrawal = M("integral_record as a")
            ->field("a.integral,a.create_time,a.source,a.description,a.type,b.username,b.phone")
            ->join("member as b on a.member_id = b.id")
            ->where($where_min)
            ->sum('a.integral');
        if($withdrawal==null)
        {
            $withdrawal = 0;
        }
		
        $footer = array(array("create_time"=>"总佣金","integral"=>$total),array("create_time"=>"已提现","integral"=>$withdrawal));
		// $result = array("total"=>$count,"rows"=>$content,"footer"=>$footer);
        $result = array("total"=>$count,"rows"=>$content);
		$result = json_encode($result);
		exit($result);
    }
}