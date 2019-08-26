<?php
namespace Phone\Controller;
class RegisterController extends BaseController {
    public function index(){
        $inviter = $_GET['inviter'];
        $member = M('member')->where("id=$inviter")->find();
        $this->assign("member",$member);
        $this->display();
    }
    public function download(){
        $inviter = $_GET['inviter'];
        $member = M('member')->where("id=$inviter")->find();
        $this->assign("member",$member);
        $this->display();
    }
}
