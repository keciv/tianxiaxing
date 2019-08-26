<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class RecordController extends BaseController {
	public function index(){
		$this->display();
	}
	public function integral(){
		$this->display();
	}
	public function commission(){
		$this->display();
	}
    public function withdrawal(){
        $this->display();
    }
	public function get_integral(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];

        $count = M("integral_record as a")
        	->field("a.integral,a.create_time,a.source,a.description,a.type,b.nickname,b.phone")
			->join("member as b on a.member_id = b.id")
			->where($where)
			->count();

		$content = M("integral_record as a")
			->field("a.integral,a.create_time,a.source,a.description,a.type,b.nickname,b.phone")
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
		exit(json_encode($result));
	}
	public function get_commission(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];

        $count = M("commission_record as a")
        	->field("a.commission,a.create_time,a.source,a.description,a.type,b.nickname,b.phone")
			->join("member as b on a.member_id = b.id")
			->where($where)
			->count();

		$content = M("commission_record as a")
			->field("a.commission,a.create_time,a.source,a.description,a.type,b.nickname,b.phone")
			->join("member as b on a.member_id = b.id")
			->where($where)
			->order('a.id desc')
			->limit(($page-1)*$rows,$rows)
			->select();
        if($content==null)
        {
            $content = array();
        }
        else
        {
            foreach ($content as $key => $value) {
                $content[$key]['create_time'] = date("Y-m-d H:i:s", $value['create_time']);
            }
        }

		$result = array("total"=>$count,"rows"=>$content);
		exit(json_encode($result));
	}
	public function get_withdrawal(){
        $page = $_POST['page'];
        $rows = $_POST['rows'];

        $name = $_POST['parameterType'];
        $value = $_POST['parameter'];
        if($name!=null&&$value!=null)
        {
            $where = "$name='$value'";
        }

        $count = M("withdrawal_record as a")
            ->join("member as b on a.member_id = b.id")
            ->where($where)
            ->count();
        // print_r($count);
        $content = M("withdrawal_record as a")
            ->field("a.id,a.money,a.fee,a.money-a.fee as shiji,a.create_time,a.end_time,a.status,b.alipay,b.open_bank,b.bank_card,b.card_owner,b.nickname,b.phone")
            ->join("member as b on a.member_id = b.id")
            ->where($where)
            ->order('a.id desc')
            ->limit(($page-1)*$rows,$rows)
            ->select();
        // print_r($content);
        if($content==null)
        {
            $content = array();
        }
        // else
        // {
        //     foreach ($content as $key => $value) {
        //         if($value['mode']=="支付宝")
        //         {
        //             $content[$key]['open_bank'] = "";
        //             $content[$key]['bank_card'] = "";
        //             $content[$key]['card_owner'] = "";
        //         }
        //         elseif($value['mode']=="银行卡")
        //         {
        //             $content[$key]['alipay'] = "";
        //         }
        //         // $content[$key]['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        //     }
        // }

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
            $time = date('Y-m-d H:i:s', time()); 

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
	public function del_integral(){
		$id=$_POST['id'];
        if($id!=null)
        {
            $result=M("integral_record")->where("id in ({$id})")->delete();
            if ($result>0) {
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
    public function del_commission(){
		$id=$_POST['id'];
        if($id!=null)
        {
            $result=M("commission_record")->where("id in ({$id})")->delete();
            if ($result>0) {
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
    public function del_withdrawal(){
        $id=$_POST['id'];
        if($id!=null)
        {
            $result=M("withdrawal_record")->where("id in ({$id})")->delete();
            if ($result>0) {
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