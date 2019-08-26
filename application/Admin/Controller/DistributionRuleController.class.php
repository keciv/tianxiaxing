<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class DistributionRuleController extends BaseController {
	public function index(){
		$this->display();
	}
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];

        $count = M("distribution_rule")->count();

		$content = M("distribution_rule")->order('id asc')->limit(($page-1)*$rows,$rows)->select();
		if(empty($content))
        {
        	$content = array();
        }
        $result = array("total"=>$count,"rows"=>$content);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
	}
	
	public function info(){
        $id = $_GET['id'];
		if($id==null)
		{
			$this->assign("caozuo",'add');
			$this->display('DistributionRule/info');
		}
		else
		{
			$distribution = M("distribution_rule")->where("id=$id")->find();
			$this->assign('distribution_rule',$distribution);
			$this->assign("caozuo",'edit');
			$this->assign("id",$id);
			$this->display('DistributionRule/info');
		}
        
    }
	public function save(){
		$id=$_POST["id"];
		$name = $_POST["name"];
		$ratio = $_POST["ratio"];
		$direct = $_POST["direct"];
		$indirect = $_POST["indirect"];

		if(empty($name))
		{
			exit("name_null");
		}
		if(empty($ratio))
		{
			exit("ratio_null");
		}
		if(empty($direct))
		{
			exit("direct_null");
		}
		if(empty($indirect))
		{
			exit("indirect_null");
		}

		if(empty($id))
		{
			$result=M("distribution_rule")
				->data(array('name'=>$name,'ratio'=>$ratio,'direct'=>$direct,'indirect'=>$indirect))
				->add();
			if ($result>0){
				exit("ok");
			}else {
				exit("error");
			}
		}
		else
		{
			$result = M("distribution_rule")->where("id=$id")->save(array('name'=>$name,'ratio'=>$ratio,'direct'=>$direct,'indirect'=>$indirect));

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
	public function delete(){
		$id=$_POST['id'];
        if($id!=null)
        {
            $result=M("distribution_rule")->where("id in ({$id})")->delete();
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
}