<?php
namespace Phone\Controller;
use Think\Controller;
class BaseController extends Controller{
	function _initialize(){
		$webInfo = webInfo();
		$this->assign("mall_webInfo",$webInfo);
	}
}