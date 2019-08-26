<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallIndexModuleController extends BaseController {
	public function index(){
		$this->display();
	}
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $count = M("mall_index_module")->count();

		$content=M("mall_index_module")->order('sequence_id desc')->limit(($page-1)*$rows,$rows)->select();
		
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
		$module=$_POST["module"];
		$description=$_POST["description"];
		$module_id=$_POST["module_id"];
		$picture=$_POST["picture"];
		if($module==null)
		{
			exit("module_null");
		}
		if($picture==null)
		{
			exit("picture_null");
		}
		$last = M("mall_index_module")->order('sequence_id desc')->find();
		$result=M("mall_index_module")->data(array('module'=>$module,'description'=>$description,'module_id'=>$module_id, 'picture'=>$picture,'sequence_id'=>$last['sequence_id']+1))
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
			$this->display('MallIndexModule/ModuleInfo');
		}
		else
		{
			$module = M("mall_index_module")->where("id=$id")->find();
			$this->assign('module',$module);
			$this->assign("caozuo",'edit');
			$this->assign("id",$id);
			$this->display('MallIndexModule/ModuleInfo');
		}
        
    }
	public function edit(){
		$id=$_POST["id"];
		$module=$_POST["module"];
		$description=$_POST["description"];
		$module_id=$_POST["module_id"];
		$picture=$_POST["picture"];
		if($id==null)
		{
			exit("id_null");
		}
		if($module==null)
		{
			exit("title_null");
		}
		if($picture==null)
		{
			exit("picture_null");
		}
		$result=M("mall_index_module")->where("id=$id")->save(array('module'=>$module,'description'=>$description,'module_id'=>$module_id,'picture'=>$picture));
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
    public function sequence(){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$value=$_POST['value'];
		$table = M("mall_index_module");
        if($id!=null)
        {
        	$now_module = $table->where("id=$id")->find();
        	$now_sequence = $now_module['sequence_id'];
        	$edit_id = "";
        	$edit_sequence = "";
        	if($value=="顶端")
        	{
        		$max_module = $table->order("sequence_id desc")->limit(1)->find();
        		$max_sequence = $max_module['sequence_id'];
        		$edit_id = $max_module['id'];
        		$edit_sequence = $max_sequence + 1;
        		$now_sequence = $max_module['sequence_id'];
        	}
        	else if($value=="上移")
        	{
        		$last_module = $table->where("sequence_id>$now_sequence")->order("sequence_id asc")->limit(1)->find(); 
        		if($last_module!=null)
        		{
        			$last_sequence = $last_module['sequence_id'];
	        		$edit_id = $last_module['id'];
	        		$edit_sequence = $last_sequence;
        		}
        		else
        		{
        			exit("dingduan");
        		}
        	}
        	else if($value=="下移")
        	{
        		$next_module = $table->where("sequence_id<$now_sequence")->order("sequence_id desc")->limit(1)->select(); 
        		if($next_module!=null)
        		{
        			$next_sequence = $next_module['sequence_id'];
	        		$edit_id = $next_module['id'];
	        		$edit_sequence = $next_sequence;
        		}
        		else
        		{
        			exit("dibu");
        		}
        	}
        	else if($value=="底部")
        	{
        		$min_module = $table->order("sequence_id asc")->limit(1)->find();
        		$min_sequence = $min_module['sequence_id'];
        		$edit_id = $min_module['id'];
        		$edit_sequence = $min_sequence - 1;
        		$now_sequence = $min_module['sequence_id'];
        	}
        	$module = M();
            $module->startTrans();
            $now_module_edit = $table
        		->where("id=$id")
        		->data(array("sequence_id"=>$edit_sequence))
                ->save();
            $last_module_edit = $table
        		->where("id=".$edit_id)
        		->data(array("sequence_id"=>$now_sequence))
                ->save();
            if (false !== $now_module_edit && false !== $last_module_edit ) {
                $module->commit();
                exit("ok");
            }
            else {
                $module->rollback();
                exit("error");
            }
        }
        else
        {
            exit("id_null");
        }
	}
}