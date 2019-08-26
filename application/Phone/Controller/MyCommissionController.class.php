<?php
namespace Phone\Controller;
class MyCommissionController extends BaseController{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $cookie_member = $_COOKIE["member_id"];
        if(empty($cookie_member))
        {
            $this->redirect('Login/index','页面跳转中...');
        }
        else
        {
            $this->assign("member_id",$cookie_member);
        }
    }
    public function index(){
    	//佣金
    	 $member_id = $_COOKIE["member_id"];
        $member = M('member')->where("id=$member_id")->find();
        $this->assign("member",$member);
        $this->display();
    }
    public function getData(){
        if(isset($_COOKIE['memberID'])){
            $memberID = $_COOKIE['memberID'];
            $CurrentPage = $_POST['CurrentPage'];
            $time = $_POST['time'];
            $type = $_POST['type'];
            $where = "member_id=$memberID";
            $paginalNum = 10;
            if($CurrentPage==null||$CurrentPage<=0)
            {
                $CurrentPage = 1;
            }
            if($time!=null)
            {
                $where.=" and time like '%{$time}%'";
            }
            if($type!=null)
            {
                $where.=" and type=$type";
            }

            $new = M('commission_record')
                ->where($where)
                ->order('id desc')
                ->limit(($CurrentPage-1)*$paginalNum,$paginalNum)
                ->select();
            foreach ($new as $key => $value_new) {
                $new[$key]['title'] = msubstr($value_new['title'],0,15,'utf-8');
                if($value_new['type']==0)
                {
                    $new[$key]['type'] = "-";
                }
                else
                {
                    $new[$key]['type'] = "+";
                }
                if($value_new['description']==null)
                {
                    $new[$key]['description'] = "暂无记录";
                }
            }
            //print_r($new);
            if($new!=null)
            {
                $result = array("status"=>"ok","rows"=>$new);
            }
            else
            {
                $result = array("status"=>"null");
            }
        }
        else
        {
            $result = array("status"=>"login_null");
        }
        exit(json_encode($result));
    }
}