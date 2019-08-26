<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller{
	function _initialize(){
		if(!isset($_SESSION['admin'])){
		$this->redirect('__APP__/Login/index');
			exit();
		}
	}
}