<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallProductAttrController extends BaseController {
    public function index(){
		$this->display();
    }
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $count = M('product_attr')->count();
        $attr = M("product_attr")
        	->Field('product_attr.id,product_attr.attr,product_attr.entry_mode as mode,product_attr.values,product_model.model')
        	->join('product_model on product_model.id=product_attr.model_id')
        	->order('product_attr.sequence desc')
        	->select();
        
        $str.="{";
		$str.="'total'";
		$str.=":";
		$str.="'".$count."'";
		$str.=",";
		$str.="'rows'";
		$str.=":";
		if($attr==null)
		{
			$content="[]";
		}
		else
		{
			$content=json_encode($attr);
		}
		$str.=$content;
		$str.="}";
		$str= str_replace("'","\"",$str);
		exit($str);
	}

	public function info(){
		$id = $_POST["id"];
		if($id==null)
		{
			exit(json_encode(array("status"=>"id_null")));
		}
		$attr = M("product_attr")->where("id='{$id}'")->find();
		if ($attr>0){
			exit(json_encode($attr));
		}else {
			exit(json_encode(array("status"=>"data_null")));
		}
	}
	public function add(){
		$attr = $_POST["attr"];
		$model = $_POST["model"];
		$mode = $_POST["mode"];
		$values = $_POST["values"];
		if($attr==null)
		{
			exit("name_null");
		}
		if($model==null)
		{
			exit("model_null");
		}
		$replace_old = array("\r\n","\n","\r");
		$replace_new = ',';
		$values = str_replace($replace_old,$replace_new,$values); 
		$last = M("product_attr")->order('sequence desc')->find();
		$result=M("product_attr")
			->data(array('attr'=>$attr,'model_id'=>$model,'entry_mode'=>$mode,'values'=>$values,'sequence'=>$last['sequence']+1))
			->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function edit(){
		$id=$_POST["id"];
		$attr = $_POST["attr"];
		$model = $_POST["model"];
		$mode = $_POST["mode"];
		$values = $_POST["values"];
		if($id==null)
		{
			exit("id_null");
		}
		if($attr==null)
		{
			exit("name_null");
		}
		if($model==null)
		{
			exit("model_null");
		}
		$replace_old = array("\r\n","\n","\r");
		$replace_new = ',';
		$values = str_replace($replace_old,$replace_new,$values); 
		$result=M("product_attr")->where("id='{$id}'")->save(array('attr'=>$attr,'model_id'=>$model,'entry_mode'=>$mode,'values'=>$values));
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
            $result=M("product_attr")->where("id in ({$id})")->delete();
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
        if($id!=null)
        {
        	//查找当前属性
        	$attr =  M("product_attr")->where("id=$id")->find();
        	if($attr!==null)
        	{
        		//当前序号
        		$sequence = $attr['sequence'];
        		//置顶
        		if($value==0)
        		{
        			//目标
        			$target = M("product_attr")->order("sequence desc")->find();
        		}
        		//上移
        		else if($value==1)
        		{
        			//目标
        			$target = M("product_attr")->where("sequence>{$sequence}")->order("sequence asc")->find();
        		}
        		//下移
        		else if($value==2)
        		{
        			//目标
        			$target = M("product_attr")->where("sequence>{$sequence}")->order("sequence desc")->find();
        		}
        		//底部
        		else if($value==3)
        		{
        			//目标
        			$target = M("product_attr")->order("sequence asc")->find();
        		}
        	}
        	$target_id = $target['id'];
        	$sequence_target = $target['sequence'];
        	$transaction = M();
            $transaction->startTrans();
        	$edit_attr = M('product_attr')->where("id=$id")->setField("sequence",$sequence_target);

            $edit_target = M('product_attr')->where("id=$target")->setField("sequence",$sequence);

            if($edit_attr!==false && $edit_target!==false){
            	$transaction->commit();
                exit("ok");
            }
            else {
            	$transaction->rollback();
                exit("error");
            }
        }
        else
        {
            exit("id_null");
        }
	}
}