<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MemberInfoController extends BaseController {
	public function index(){
		$proportion = M('integral_rule')->order("id desc")->limit(1)->getField('proportion');
		$this->assign('proportion',$proportion);
		$this->display();
	}
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];

        $phone = $_POST['phone'];
        if($phone!=null)
        {
        	$where = "a.phone='{$phone}'";
        	$where_tongji = "b.phone='{$phone}'";
        }
        $time = $_POST['time'];
        if($time!=null)
        {	if($phone==null)
        	{
        		$where = "a.create_time like '%{$time}%'";
        		$where_tongji = "a.create_time like '%{$time}%'";
        	}
        	else
        	{
        		$where .= " and a.create_time like '%{$time}%'";
        		$where_tongji .= " and a.create_time like '%{$time}%'";
        	}
        }

        $count = M("member as a")
        	->field("a.*,b.username as inviter_name")
			->join("member as b on a.inviter_id=b.id","left")
			->where($where)
			->count();
        
		$content = M("member as a")
			->field("a.*,b.username as inviter_name")
			->join("member as b on a.inviter_id=b.id","left")
			->where($where)
			->order('a.id desc')
			->limit(($page-1)*$rows,$rows)
			->select();
		if($content==null)
		{
			$content = array();
		}

		if($where_tongji!=null)
        {
            $where_tongji_add = $where_tongji." and a.type=1";
        }
        else
        {
            $where_tongji_add = "a.type=1";
        }
		if($where_tongji!=null)
        {
            $where_tongji_min = $where_tongji." and a.type=0";
        }
        else
        {
            $where_tongji_min = "a.type=0";
        }
        $total = M("integral_record as a")
            ->field("a.integral,a.create_time,a.source,a.description,a.type,b.username,b.phone")
            ->join("member as b on a.member_id = b.id")
            ->where($where_tongji_add)
            ->sum('a.integral');
        if($total==null)
        {
            $total = 0;
        }

        $withdrawal = M("integral_record as a")
            ->field("a.integral,a.create_time,a.source,a.description,a.type,b.username,b.phone")
            ->join("member as b on a.member_id = b.id")
            ->where($where_tongji_min)
            ->sum('a.integral');
        if($withdrawal==null)
        {
            $withdrawal = 0;
        }

        $join = M('integral_rule')->order('id desc')->getField('join'); 
        $shouru = $count*$join;

		$footer = array(array("phone"=>"总收入","keyong"=>"$shouru","create_time"=>"总佣金","inviter_name"=>$total,"open_bank"=>"总提现","bank_card"=>$withdrawal));


		// $result = array("total"=>$count,"rows"=>$content,"footer"=>$footer);
		$result = array("total"=>$count,"rows"=>$content);
		$result = json_encode($result);

		exit($result);
	}
	public function add(){
		$password=$_POST["password"];
		$surepassword=$_POST["surepassword"];
		$phone=$_POST["phone"];
		$inviter=$_POST["inviter"];
		$time=date('Y-m-d');
		if($password==null||$surepassword==null||$phone==null)
		{
			exit("buwanzheng");
		}
		if($password!=$surepassword)
		{
			exit("buyizhi");
		}
		$havePhone=M("member")->where("phone={$phone}")->find();
		if($havePhone!=null)
		{
			exit("havePhone");
		}
		$inviter_id = 0;
		
		if($phone!="15135288066")
		{
			if($inviter==null)
			{
				$inviter = "15135288066";
			}
			//推荐人是否存在
			$one_inviter=M("member")->where("phone={$inviter}")->find();
			if($one_inviter==null)
			{
				exit("inviter_null");
			}
			$inviter_id = $one_inviter['id'];
			$last_username = M('member')->order("id desc")->getField('username');
			$last_number = (int)substr($last_username, 3);
			$now_number = get_serial_number($last_number+1);
			//添加分销奖励
			$join = M('integral_rule')->order('id desc')->getField('join'); 
            $rule = M('distribution_rule')->order('id asc')->select();
			//开始事务
			$add_member = M();
			$add_member->startTrans();

			$inviter_phone = $inviter;
            foreach ($rule as $key => $value) {
            	if($inviter_phone!=null)
            	{
            		$inviter_member = M("member")->where("phone={$inviter_phone}")->find();
            		if($inviter_member!=null)
            		{
            			$reward = $join*$value['ratio']/100;
		                $add_record = M('integral_record')
		                    ->data(array("integral"=>$reward,"member_id"=>$inviter_member['id'],"source"=>"推荐","description"=>"推荐一人进入平台，奖励{$reward}积分","type"=>1))
		                    ->add();
		                $add_integral = M('member')->where("id={$inviter_member['id']}")->setInc("keyong",$reward);
		                if(!$add_record>0&&!$add_integral>0)
		                {
		                    $add_member->rollback();
		                    exit("error");
		                }
		                $inviter_phone = $inviter_member['inviter'];
            		}
            	}
            }
			
			$result=M("member")
				->data(array('password'=>md5($password),'phone'=>$phone,'inviter'=>$inviter,'inviter_id'=>$inviter_id))
				->add();
			$edit_username = M("member")->where("id=$result")->setField('username',$now_number);
			if ($result>0&&$edit_username!==false){
				$add_member->commit();
				exit("ok");
			}else {
				$add_member->rollback();
				exit("error");
			}
		}
		else
		{
			$result=M("member")
				->data(array('password'=>md5($password),'phone'=>$phone))
				->add();
			$edit_username = M("member")->where("id=$result")->setField('username','zg0000000');
			if ($result>0&&$edit_username!==false){
				$add_member->commit();
				exit("ok");
			}
			else {
				$add_member->rollback();
				exit("error");
			}
		}
	}
	public function info(){
        $id=$_GET['id'];
		if($id==null)
		{
			$this->assign("caozuo",'add');
			$this->display('MemberInfo/MemberInfo');
		}
		else
		{
			$member = M("member")->where("id='{$id}'")->find();
			$this->assign('member',$member);
			$this->assign("id",$id);
			$this->display('MemberInfo/MemberInfo');
		}
        
    }
    public function shopinfo(){
        $id = $_GET['id'];
		if($id==null)
		{
			$this->assign("caozuo",'add');
			$this->display('MemberInfo/shopinfo');
		}
		else
		{
			$member = M("shop")->where("id='{$id}'")->find();
			$this->assign('member',$member);
			$this->assign("id",$id);
			$this->display('MemberInfo/shopinfo');
		}
        
    }
	public function edit(){
		$id = $_POST["id_member"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$pay_password = $_POST["pay_password"];
		$nickname = $_POST["nickname"];
		$name = $_POST["name"];
		$sex = $_POST["sex"];
		$phone = $_POST["phone"];
		$id_card = $_POST["id_card"];

		$address = $_POST["address"];
		$open_bank = $_POST["open_bank"];
		$bank_card = $_POST["bank_card"];
		// $QQ=$_POST["QQ"];
		// $WeChat=$_POST["WeChat"];
		// $email=$_POST["email"];
		// $Audit=$_POST["Audit"];
		// $grade=$_POST["grade"];
		// $keyong=$_POST["keyong"];
		// $zhiding=$_POST["zhiding"];
		$headportrait = $_POST["hidden_headportrait"];
		if($password=="**********")
		{
			$old_pwd = M('member')->where("id=$id")->getField('password');
			$password = $old_pwd;
		}
		else
		{
			$password = md5($password);
		}
		if($pay_password=="**********")
		{
			$old_pay_pwd = M('member')->where("id=$id")->getField('pay_password');
			$pay_password = $old_pay_pwd;
		}
		else
		{
			$pay_password = md5($pay_password);
		}

		$result=M("member")->where("id='{$id}'")->save(array('username'=>$username,'nickname'=>$nickname,'password'=>$password,'pay_password'=>$pay_password,'name'=>$name,'sex'=>$sex,'phone'=>$phone,'headportrait'=>$headportrait,'id_card'=>$id_card,'open_bank'=>$open_bank,'bank_card'=>$bank_card,'address'=>$address));
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
            $result=M("member")->where("id in ({$id})")->delete();
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
        $id = $_POST['id'];
        if($id!=null)
        {
        	$audit = $_POST['audit'];
        	if($audit=="2")
        	{
        		$member = M('member')->where("id=$id")->find();
        		if($member==null)
        		{
        			exit("member_null");
        		}
        		$inviter = $member['inviter'];
        		//推荐人是否存在
				$one_inviter=M("member")->where("phone={$inviter}")->find();
				if($one_inviter==null)
				{
					exit("inviter_null");
				}
				$inviter_id = $one_inviter['id'];
				$last_username = M('member')->order("id desc")->getField('username');
				$last_number = (int)substr($last_username, 3);
				$now_number = get_serial_number($last_number+1);
				//添加分销奖励
				$join = M('integral_rule')->order('id desc')->getField('join'); 
	            $rule = M('distribution_rule')->order('id asc')->select();
				//开始事务
				$audit_member = M();
				$audit_member->startTrans();

				$inviter_phone = $inviter;
	            foreach ($rule as $key => $value) {
	            	if($inviter_phone!=null)
	            	{
	            		$inviter_member = M("member")->where("phone={$inviter_phone}")->find();
	            		if($inviter_member!=null)
	            		{
	            			$reward = $join*$value['ratio']/100;
			                $add_record = M('integral_record')
			                    ->data(array("integral"=>$reward,"member_id"=>$inviter_member['id'],"source"=>"推荐","description"=>"推荐一人进入平台，奖励{$reward}积分","type"=>1))
			                    ->add();
			                $add_integral = M('member')->where("id={$inviter_member['id']}")->setInc("keyong",$reward);

			                if(!$add_record>0&&!$add_integral>0)
			                {
			                    $audit_member->rollback();
			                    exit("error");
			                }
			                $inviter_phone = $inviter_member['inviter'];
	            		}
	            	}
	            }
        	}

        	$result=M("member")->where("id=$id")->save(array('audit'=>$audit));
        	if(false !== $result || 0 !== $result)
			{
				$audit_member->commit();
				exit("ok");
			}
			else
			{
				$audit_member->rollback();
				exit("error");
			}
        }
        else
        {
        	exit("id_null");
        }
    }
    public function recharge(){
    	$id = $_POST["id"];
    	$keyong = $_POST["keyong"];
    	$zhiding = $_POST["zhiding"];
    	if($id==null)
    	{
    		exit("id_null");
    	}
    	if($keyong==null)
    	{
    		exit("keyong_null");
    	}
    	if($zhiding==null)
    	{
    		exit("zhiding_null");
    	}
    	
    	//会员
    	$member = M('member')->where("id=$id")->find();
    	if($member!=null)
    	{
    		$new_keyong = $member['keyong'] + $keyong;
    		$new_zhiding = $member['zhiding'] + $zhiding;

    		$recharge = M();
    		$recharge->startTrans();

    		//会员积分增加
    		$result = M('member')->where("id=$id")->data(array("keyong"=>$new_keyong,"zhiding"=>$new_zhiding))->save();
    		if(!$result)
    		{
    			$recharge->rollback();
    			exit("error");
    		}
    		//增加积分记录
    		if($keyong!=0){
    			$add_record = M('integral_record')
	    			->data(array("integral"=>$keyong,"member_id"=>$id,"source"=>"充值","description"=>"充值{$integral}积分，可用积分到账{$keyong}","type"=>1))
	    			->add();
	    		if(!$add_record>0)
	    		{
	    			$recharge->rollback();
	    			exit("error");
	    		}
    		}

    		if($zhiding!=0)
    		{
    			$add_record = M('integral_record')
	    			->data(array("integral"=>$zhiding,"member_id"=>$id,"source"=>"充值","description"=>"充值{$integral}积分，指定积分到账{$zhiding}","type"=>1))
	    			->add();
	    		if(!$add_record>0)
	    		{
	    			$recharge->rollback();
	    			exit("error");
	    		}
    		}
    		$recharge->commit();
    		exit("ok");
    	}
    }
    public function edit_integral(){
    	$integral_type = $_POST['integral_type'];
    	$integral = $_POST['integral'];
    	$type = $_POST['type'];
    	$member_id = $_POST['member_id'];
    	if($integral_type==null)
    	{
    		exit("integral_type_null");
    	}
    	if($integral==null)
    	{
    		exit("integral_null");
    	}
    	if($type==null)
    	{
    		exit("type_null");
    	}
    	if($member_id==null)
    	{
    		exit("member_id_null");
    	}
    	$member = M();
		$member->startTrans();
		//修改积分
    	if($type=="add")
    	{
    		$edit_integral = M('member')->where("id=$member_id")->setInc($integral_type,$integral);
    		$type = 1;
    	}
    	else
    	{
    		$edit_integral = M('member')->where("id=$member_id")->setDec($integral_type,$integral);
    		$type = 0;
    	}
    	if($edit_integral===false)
    	{
    		$member->rollback();
    		exit("error");
    	}
    	//添加记录
    	$add_record = M('integral_record')->data(array("integral"=>$integral,"member_id"=>$member_id,"source"=>"管理员","description"=>"管理员修改积分","type"=>$type))->add();
    	if(!$add_record>0)
    	{
    		$member->rollback();
    		exit("error");
    	}
    	
    	$member->commit();
		exit("ok");
    }
}