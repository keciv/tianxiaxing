<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MallProductSpecController extends BaseController {
    public function index(){
		$this->display();
    }
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $count = M('product_spec')->count();
        $attr = M("product_spec")
        	->Field('product_spec.id,product_spec.spec,product_spec.values,product_model.model')
        	->join('product_model on product_model.id=product_spec.model_id')
        	->order('product_spec.sequence desc')
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
		$id=$_POST["id"];
		if($id==null)
		{
			exit(json_encode(array("status"=>"id_null")));
		}
		$spec = M("product_spec")->where("id='{$id}'")->find();
		if ($spec>0){
			exit(json_encode($spec));
		}else {
			exit(json_encode(array("status"=>"data_null")));
		}
	}
	public function add(){
		$spec = $_POST["spec"];
		$model = $_POST["model"];
		$values = $_POST["values"];
		if($spec==null)
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
		$last = M("product_spec")->order('sequence desc')->find();
		$result = M("product_spec")
			->data(array('spec'=>$spec,'model_id'=>$model,'values'=>$values,'sequence'=>$last['sequence']+1))
			->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function edit(){
		$id=$_POST["id"];
		$spec = $_POST["spec"];
		$model = $_POST["model"];
		$values = $_POST["values"];
		if($id==null)
		{
			exit("id_null");
		}
		if($spec==null)
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
		$result=M("product_spec")->where("id='{$id}'")->save(array('spec'=>$spec,'model_id'=>$model,'values'=>$values));
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
            $result=M("product_spec")->where("id in ({$id})")->delete();
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