<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class IndexController extends BaseController {
    public function index(){
    	$admin=$_SESSION['admin'];
    	$this->assign("admin",$admin);
    	$this->display();
    }
}