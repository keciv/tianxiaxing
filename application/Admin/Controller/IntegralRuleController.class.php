<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class IntegralRuleController extends BaseController {
    public function index(){
		$integral_rule=M("integral_rule")->order("id desc")->find();
		$this->assign("integral_rule",$integral_rule);
    	$this->display();
    }
	public function save(){
		$id = $_POST['id'];
		$ranking_ratio = $_POST['ranking_ratio'];
		$bonus = $_POST['bonus'];
		$exchange = $_POST['exchange'];
		
		if($id != null)
		{
			$result=M("integral_rule")
			->where("id=$id")
			->save(array(
				'ranking_ratio'=>$ranking_ratio,
				'bonus'=>$bonus,
				'exchange'=>$exchange
			));	
		}
		else
		{
			$result=M("integral_rule")
			->data(array(
				'ranking_ratio'=>$ranking_ratio,
				'bonus'=>$bonus,
				'exchange'=>$exchange
			))
			->add();
		}
		if(false !== $result || 0 !== $result)
		{
			exit("ok");
		}
		else
		{
			exit("error");
		}
    }
}