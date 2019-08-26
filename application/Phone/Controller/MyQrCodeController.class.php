<?php
namespace Phone\Controller;
class MyQrCodeController extends BaseController {
    public function index(){
    	$member_id = $_COOKIE["member_id"];
        if(empty($member_id))
        {
            $this->redirect('Login/index','页面跳转中...');
        }
        else
        {
            $this->assign("member_id",$member_id);
        }
        $this->display();
    }
}
