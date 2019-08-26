<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class GonghuoshangController extends BaseController {
	public function index(){
		$this->display();
	}
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];

        $count = M("gonghuoshang")
            ->count();
        
        $content = M("gonghuoshang")
            ->order('id desc')
            ->limit(($page-1)*$rows,$rows)
            ->select();
        if($content==null)
        {
            $content = array();
        }
        else
        {
            foreach ($content as $key => $value) {
                $content[$key]['create_time'] = date("Y-m-d H:i:s", $value['create_time']);
            }
        }

        // $result = array("total"=>$count,"rows"=>$content,"footer"=>$footer);
        $result = array("total"=>$count,"rows"=>$content);
        $result = json_encode($result);

        exit($result);
	}
    public function info(){
        $id = $_GET['id'];
		if($id==null)
		{
			$this->assign("caozuo",'add');
			$this->display('Gonghuoshang/info');
		}
		else
		{
			$gonghuoshang = M("gonghuoshang")->where("id='{$id}'")->find();
			$this->assign('gonghuoshang',$gonghuoshang);
			$this->assign("id",$id);
			$this->display('Gonghuoshang/info');
		}
        
    }
	public function delete(){
		$id=$_POST['id'];
        if($id!=null)
        {
            $result=M("gonghuoshang")->where("id in ({$id})")->delete();
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

    public function audit(){
        $id = $_POST['id'];
        if($id!=null)
        {
            $audit = $_POST['audit'];

            $result=M("gonghuoshang")->where("id=$id")->save(array('status'=>1));
            if(false !== $result || 0 !== $result)
            {
                exit("ok");
            }
            else
            {
                exit("error");
            }
        }
        else
        {
            exit("id_null");
        }
    }
}