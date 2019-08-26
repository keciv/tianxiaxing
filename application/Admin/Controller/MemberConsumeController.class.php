<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MemberConsumeController extends BaseController {
    public function index(){
		
    	$this->display();
    }
	public function getData(){
    	$page = $_POST['page'];
        $rows = $_POST['rows'];

        $name = $_POST['parameterType'];
        $value = $_POST['parameter'];
        if($name!=null&&$value!=null)
        {
        	$where = "$name='$value'";
        }

        $count = M("consume_record")->where($where)->count();
        
		$content = M("consume_record as a")
			->field("a.id,a.title,a.money,a.create_time,b.username,b.phone")
			->join("member as b on a.member_id = b.id")
			->where($where)
			->order('a.id desc')
			->limit(($page-1)*$rows,$rows)
			->select();
		if($content==null)
		{
			$content = array();
		}

		$result = array("total"=>$count,"rows"=>$content);
		$result = json_encode($result);
		exit($result);
    }
}