<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class ShippingController extends BaseController {
    public function index(){
		$this->display();
    }
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $count = M('freight_template')
	        ->Field('product.id as id,product.title,product.mall_recommend,product.company_recommend,product.is_sale,product.sort_id,product_sort.sort_name')
	        ->join('product_sort on product.sort_id=product_sort.id')
	        ->count();
        $content = M('product')
	        ->Field('product.id as id,product.title,product.mall_recommend,product.company_recommend,product.is_sale,product.sort_id,product_sort.sort_name')
	        ->join('product_sort on product.sort_id=product_sort.id')
            ->order('product.sequence_id desc')->limit(($page-1)*$rows,$rows)
            ->select();
		//$content=M("product")->order('sequence_id desc')->limit(($page-1)*$rows,$rows)->select();
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
	
	public function info(){
		$id=$_GET['id'];
		if($id==null)
		{
			$this->assign("caozuo",'add');
		}
		else
		{
			$product = M("product")->where("id='{$id}'")->find();
			$this->assign('product',$product);
			$this->assign("caozuo",'edit');
			$this->assign("id",$id);
		}
		$this->display('MallProduct/ProductInfo');
	}
	public function add(){
		$title=$_POST["title"];
		$description=$_POST["description"];
		$note=$_POST["note"];
		$picture=$_POST["picture"];
		$picturemore=$_POST["picturemore"];
		$content=$_POST["content"];
		$sort_id=$_POST["sort_id"];
		$original_price=$_POST["original_price"];
		$current_price=$_POST["current_price"];
		$reserve=$_POST["reserve"];
		$unit=$_POST["unit"];
		$sample=$_POST["sample"];
		if($title==null)
		{
			exit("title_null");
		}
		if($sort_id==null)
		{
			exit("sort_id_null");
		}
		if($original_price==null)
		{
			exit("original_price_null");
		}
		if($current_price==null)
		{
			exit("current_price_null");
		}
		if($reserve==null)
		{
			exit("reserve_null");
		}
		if($sample=="是")
		{
			$sample = "1";
		}
		else if($sample=="否")
		{
			$sample = "0";
		}
		$picturemore = strip_tags($picturemore, '<img>' );
		$last = M("product")->order('sequence_id desc')->find();
		$result=M("product")
		->data(array('title'=>$title,
			'description'=>$description,
			'note'=>$note,
			'picture'=>$picture,
			'picturemore'=>$picturemore,
			'content'=>$content,
			'sort_id'=>$sort_id,
			'original_price'=>$original_price,
			'current_price'=>$current_price,
			'reserve'=>$reserve,
			'unit'=>$unit,
			'sample'=>$sample,
			'sequence_id'=>$last['sequence_id']+1
		))
		->add();
		if ($result>0){
			exit("ok");
		}else {
			exit("error");
		}
	}
	public function edit(){
		$id=$_POST["id"];
		$title=$_POST["title"];
		$description=$_POST["description"];
		$note=$_POST["note"];
		$picture=$_POST["picture"];
		$picturemore=$_POST["picturemore"];
		$content=$_POST["content"];
		$sort_id=$_POST["sort_id"];
		$original_price=$_POST["original_price"];
		$current_price=$_POST["current_price"];
		$reserve=$_POST["reserve"];
		$unit=$_POST["unit"];
		$sample=$_POST["sample"];
		if($id==null)
		{
			exit("id_null");
		}
		if($title==null)
		{
			exit("title_null");
		}
		if($sort_id==null)
		{
			exit("sort_id_null");
		}
		if($original_price==null)
		{
			exit("original_price_null");
		}
		if($current_price==null)
		{
			exit("current_price_null");
		}
		if($reserve==null)
		{
			exit("reserve_null");
		}
		if($sample=="是")
		{
			$sample = "1";
		}
		else if($sample=="否")
		{
			$sample = "0";
		}
		$picturemore = strip_tags($picturemore, '<img>' );
		$result=M("product")->where("id='{$id}'")
		->save(array('title'=>$title,
			'description'=>$description,
			'note'=>$note,
			'picture'=>$picture,
			'picturemore'=>$picturemore,
			'content'=>$content,
			'sort_id'=>$sort_id,
			'original_price'=>$original_price,
			'current_price'=>$current_price,
			'reserve'=>$reserve,
			'unit'=>$unit,
			'sample'=>$sample
		));
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
            $result=M("product")->where("id in ({$id})")->delete();
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
	public function Attributes_info(){
		$id=$_GET['id'];
		$Attributes=$_GET['Attributes'];
        if($id!=null&&$Attributes!=null)
        {
        	$data=M("product")->where("id={$id}")->find();
        	if($data!=null)
        	{
        		$content=$data[$Attributes];
        		$this->assign('id',$id);
	        	$this->assign('Attributes',$Attributes);
	        	$this->assign('content',$content);
        	}
        	if($Attributes=="characteristic")
        	{
        		$this->CharacteristicInfo($id,$data['sort_id']);
        	}
        	else
        	{
        		$this->display('MallProduct/Attributes');
        	}
        }
	}
	public function save_Attributes(){
		$id=$_POST['id'];
		$Attributes=$_POST['Attributes'];
		$content=$_POST['content'];
        if($id!=null&&$Attributes!=null)
        {
        	$data=M("product")->where("id={$id}")->find();
        	if($data!=null)
        	{
        		$result=M("product")->where("id='{$id}'")->save(array("{$Attributes}"=>$content));
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
	}
	public function CharacteristicInfo($id,$sort_id){
		$characteristic = M("product")->where("id=$id")->getField("characteristic");
		$this->assign('characteristic',$characteristic);
		$this->assign('id',$id);
		$this->assign('sort_id',$sort_id);
		$this->display('MallProduct/Characteristic');
	}
	public function save_Characteristic(){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$value=$_POST['value'];
        if($id!=null)
        {
        	$str="[";
        	for($i=0;$i<count($value);$i++)
        	{
        		$str.="{";
        		for($j=0;$j<count($name);$j++)
        		{

        			$str.="'".$name[$j]."'";
    				$str.=":";
        			$str.="'".$value[$i][$j]."'";
        			$str.=",";
        		}
        		$str= substr($str,0,$str.length-1);
        		$str.="}";
	        	$str.=",";
        	}
        	$str= substr($str,0,$str.length-1);
			$str= str_replace("'","\"",$str);
        	$str.="]";
			
			$result=M("product")->where("id='{$id}'")->save(array("characteristic"=>$str));
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
	public function recommend(){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$value=$_POST['value'];
        if($id!=null)
        {
            $result=M("product")->where("id=$id")->save(array("$name"=>$value));
            if(false !== $result || 0 !== $result){
                exit("ok");
            }
            else {
                exit("error");
            }
        }
        else
        {
            exit("id_null");
        }
	}
	public function sale(){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$value=$_POST['value'];
        if($id!=null)
        {
            $result=M("product")->where("id=$id")->save(array("$name"=>$value));
            if(false !== $result || 0 !== $result){
                exit("ok");
            }
            else {
                exit("error");
            }
        }
        else
        {
            exit("id_null");
        }
	}
}