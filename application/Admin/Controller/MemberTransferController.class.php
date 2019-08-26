<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MemberTransferController extends BaseController {
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

        $count = M("transfer_record")->where($where)->count();
        
		$content = M("transfer_record as a")
			->field("a.id,a.integral,a.target,a.create_time,a.end_time,a.audit,b.username,b.phone")
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
            $record = M('transfer_record')->where("id=$id")->find();
            $target_id = M('member')->where("username='{$record['target']}'")->getField("id");
            $member = M('member')->where("id='{$record['member_id']}'")->getField("username");
        	$time = date('Y-m-d h:i:s', time());
            //开始事务
            $transfer = M();
            $transfer->startTrans();
            //修改转账记录
            $result = M("transfer_record")->where("id=$id")->save(array("$name"=>$value,"end_time"=>$time));
            
            //添加积分记录
            $add_integral_record = M('integral_record')
                ->data(array("integral"=>$record['integral'],"member_id"=>$target_id,"source"=>"转账","description"=>"{$member}转来{$record['integral']}积分","type"=>1))
                ->add();
            //修改会员积分
            
            $edit_integral = M('member')->where("id=$target_id")->setInc("keyong",$record['integral']);

            if($result!==false&&$add_integral_record>0&&$edit_integral!==false){
                $transfer->commit();
                exit("ok");
            }
            else {
                $transfer->rollback();
                exit("error");
            }
        }
        else
        {
        	exit("id_null");
        }
	}
}