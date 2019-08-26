<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallBannerController extends BaseController {
	public function index(){
		$this->display();
	}
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $count = M("mall_banner")->count();

		$content=M("banner")->order('sequence_id desc')->limit(($page-1)*$rows,$rows)->select();
		
		$str.="{";
		$str.="'total'";
		$str.=":";
		$str.="'".$count."'";
		$str.=",";
		$str.="'rows'";
		$str.=":";
		if($content==null)
		{
			$content="[]";
		}
		else
		{
			$content=json_encode($content);
		}
		$str.=$content;
		$str.="}";
		$str= str_replace("'","\"",$str);
		exit($str);
	}
	public function add(){
		$title=$_POST["title"];
		$MallBannerSort=$_POST["MallBannerSort"];
		$specify_url=$_POST["specify_url"];
		$picture=$_POST["picture"];
		if($picture==null)
		{
			exit("picture_null");
		}
		$last = M("banner")->order('sequence_id desc')->find();
		$result=M("banner")->data(array('title'=>$title,'create_time'=>time(),'picture'=>$picture,'specify_url'=>$specify_url,'sequence_id'=>$last['sequence_id']+1))
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
			$banner = M("banner")->where("id='{$id}'")->find();
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
		if($id==null)
		{
			exit("id_null");
		}
		if($picture==null)
		{
			exit("picture_null");
		}
		$result=M("banner")->where("id='{$id}'")->save(array('title'=>$title,'create_time'=>time(),'picture'=>$picture,'specify_url'=>$specify_url));
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
            $result=M("banner")->where("id in ({$id})")->delete();
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