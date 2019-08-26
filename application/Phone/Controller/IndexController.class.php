<?php
namespace Phone\Controller;
class IndexController extends BaseController{
    public function index(){
        $member_id = $_COOKIE['member_id'];
        if(empty($member_id)){
            $member_id = 0;
            $member_type = 0;
        }
        else
        {
            $member = M('member')->where("id=$member_id")->find();
            $member_type = $member['type'];
            cookie('member_id',$member["id"],3600*24*7);
        }
        $this->assign("member_id",$member_id);
        $this->assign("member_type",$member_type);
        $this->display();
    }
}