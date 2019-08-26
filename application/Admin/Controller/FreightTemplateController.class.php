<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class FreightTemplateController extends BaseController {
    public function index(){
    	$template = M('freight_template')->field('title,transport_method')
            ->order('sequence_id desc')->limit(($page-1)*$rows,$rows)
            ->select();
        if($template!=null)
        {
        	foreach ($template as $template) {
        		$str_template .= $template['title'];
        		$str_template .= ",";
        		$transport = $template['transport_method'];
        		print_r($transport);
        		$array_transport = json_decode($transport,true);
        		print_r($array_transport);
        	}
        }
        $str_template = substr($str_template, 0, mb_strlen($str_template)-1);
        $this->assign("template",$str_template);
        
		$this->display();
    }
	public function getData(){
		$page = $_POST['page'];
        $rows = $_POST['rows'];
        $count = M('freight_template')->count();
        $template = M('freight_template')
            ->order('sequence_id desc')->limit(($page-1)*$rows,$rows)
            ->select();
		$str.="{";
		$str.="'total'";
		$str.=":";
		$str.="'".$count."'";
		$str.=",";
		$str.="'rows'";
		$str.=":";
		if($template==null)
		{
			$content_json="[]";
		}
		else
		{
			$content_json.="[";
			foreach($template as $template)
			{
				$transport_method = $template['transport_method'];
				$array_t_m = json_decode($transport_method,true);
				if($array_t_m!=null)
				{
					foreach ($array_t_m as $array_t_m) {
						$transport = $array_t_m['transport'];
						if($transport!=null)
						{
							foreach ($transport as $transport) {
								$content_json.="{";
								$content_json.="'group'";
								$content_json.=":";
								$content_json.="'".$template['title']."'";
								$content_json.=",";
								$content_json.="'method'";
								$content_json.=":";
								$content_json.="'".$array_t_m['method']."'";
								$content_json.=",";
								$content_json.="'district'";
								$content_json.=":";
								$content_json.="'".$transport['district']."'";
								$content_json.=",";
								$content_json.="'first'";
								$content_json.=":";
								$content_json.="'".$transport['first']."'";
								$content_json.=",";
								$content_json.="'price'";
								$content_json.=":";
								$content_json.="'".$transport['price']."'";
								$content_json.=",";
								$content_json.="'add'";
								$content_json.=":";
								$content_json.="'".$transport['add']."'";
								$content_json.=",";
								$content_json.="'add_price'";
								$content_json.=":";
								$content_json.="'".$transport['add_price']."'";
								$content_json.="}";
								$content_json.=",";
							}
						}
					}
				}
			}
			$content_json = substr($content_json, 0, mb_strlen($content_json)-1);
			$content_json.="]";
		}
		$str.=$content_json;
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
		$this->display('FreightTemplate/info');
	}
	public function add(){
		//模板名称、省、市、区、发货时间、是否包邮、计价方式
		$title = $_POST["title"];
		$province_id = $_POST["province"];
		$city_id = $_POST["city"];
		$district_id = $_POST["district"];
		$picturemore = $_POST["delivery_time"];
		$postage = $_POST["postage"];
		$valuation_method = $_POST["valuation_method"];
		//运输方式、运费设置
		$method = $_POST['method'];
		$method = $_POST['method'];
		$method = $_POST['method'];
		$method = $_POST['method'];

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
            $result=M("freight_template")->where("id=$id")->delete();
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