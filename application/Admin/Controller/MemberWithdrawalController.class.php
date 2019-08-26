<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MemberWithdrawalController extends BaseController {
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

        $count = M("withdrawal_record")->where($where)->count();
        
		$content = M("withdrawal_record as a")
			->field("a.id,a.money,a.alipay,a.create_time,a.end_time,a.audit,b.username,b.phone")
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
	public function audit(){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$value = $_POST['value'];
		if($id!=null)
        {
        	$time = date('Y-m-d h:i:s', time()); 

            $result = M("withdrawal_record")->where("id=$id")->save(array("$name"=>$value,"end_time"=>$time));
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