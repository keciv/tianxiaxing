<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class ModuleController extends BaseController {
	public function index(){
		$this->display();
	}
	public function getData(){
		$module=M("module")->order('id asc')->select();
		if($module!=null)
		{
			$moduleArray=array();
			foreach ($module as $every_module) {
				$array = array("id"=>$every_module['id'],"text"=>$every_module['title']);
				array_push($moduleArray, $array);
			}
			exit(json_encode($moduleArray));
		}
	}
	public function add(){
		$title=$_POST["title"];
		$MallBannerSort=$_POST["MallBannerSort"];
		$specify_url=$_POST["specify_url"];
		$picture=$_POST["picture"];
		$time=date('Y-m-d');
		if($picture==null)
		{
			exit("picture_null");
		}
		$last = M("mall_banner")->order('sequence_id desc')->find();
		$result=M("mall_banner")->data(array('title'=>$title,'belong_mall'=>$MallBannerSort,'time'=>$time,'picture'=>$picture,'specify_url'=>$specify_url,'sequence_id'=>$last['sequence_id']+1))
	->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function info(){
        $id=$_GET['id'];
		if($id==null)
		{
			$this->assign("caozuo",'add');
			$this->display('MallBanner/BannerInfo');
		}
		else
		{
			$banner = M("mall_banner")->where("id='{$id}'")->find();
			$this->assign('banner',$banner);
			$this->assign("caozuo",'edit');
			$this->assign("id",$id);
			$this->display('MallBanner/BannerInfo');
		}
        
    }
	public function edit(){
		$id=$_POST["id"];
		$title=$_POST["title"];
		$MallBannerSort=$_POST["MallBannerSort"];
		$specify_url=$_POST["specify_url"];
		$picture=$_POST["picture"];
		$time=date('Y-m-d');
		if($id==null)
		{
			exit("id_null");
		}
		if($picture==null)
		{
			exit("picture_null");
		}
		$result=M("mall_banner")->where("id='{$id}'")->save(array('title'=>$title,'belong_mall'=>$MallBannerSort,'time'=>$time,'picture'=>$picture,'specify_url'=>$specify_url));
		if(false !== $result || 0 !== $result)
		{
			exit("ok");
		}
		else
		{
			exit("error");
		}
    }
	public function delete(){
		$id=$_POST['id'];
        if($id!=null)
        {
            $result=M("mall_banner")->where("id in ({$id})")->delete();
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