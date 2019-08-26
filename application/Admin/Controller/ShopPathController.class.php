<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class ShopPathController extends BaseController {
	public function index(){
		$this->display();
	}
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];

        $count = M("dianpu as a")
            ->field("a.*,b.username")
            ->join("member as b on a.member_id=b.id")
            ->count();
        
        $content = M("dianpu as a")
            ->field("a.*,b.username")
            ->join("member as b on a.member_id=b.id")
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

        // $result = array("total"=>$count,"rows"=>$content,"footer"=>$footer);
        $result = array("total"=>$count,"rows"=>$content);
        $result = json_encode($result);

        exit($result);
	}
    public function info(){
        $id = $_GET['id'];
		if($id==null)
		{
			$this->assign("caozuo",'add');
			$this->display('ShopPath/info');
		}
		else
		{
			$member = M("dianpu")->where("id='{$id}'")->find();
			$this->assign('member',$member);
			$this->assign("id",$id);
			$this->display('ShopPath/info');
		}
        
    }
	public function delete(){
		$id=$_POST['id'];
        if($id!=null)
        {
            $result=M("dianpu")->where("id in ({$id})")->delete();
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
            //开始事务
            $audit_dianpu = M();
            $audit_dianpu->startTrans();
        	if($audit=="1")
        	{
        		$dianpu = M('dianpu')->where("id=$id")->find();
        		if(empty($dianpu))
        		{
                    $audit_dianpu->rollback();
        			exit("dianpu_null");
        		}
                $member_id = $dianpu['member_id'];
                $edit_member = M("member")->where("id=$member_id")->data(array("type"=>"2"))->save();

                if($edit_member===false)
                {
                    $audit_dianpu->rollback();
                    exit("error");
                }
        	}

        	$result=M("dianpu")->where("id=$id")->save(array('status'=>$audit));
        	if(false !== $result || 0 !== $result)
			{
				$audit_dianpu->commit();
				exit("ok");
			}
			else
			{
				$audit_dianpu->rollback();
				exit("error");
			}
        }
        else
        {
        	exit("id_null");
        }
    }
}