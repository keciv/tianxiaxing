<?php
namespace Phone\Controller;
class ProductController extends BaseController {
    public function index(){

        $id = $_GET['sort_id'];
        $this->assign("id",$id);
        $member_id = $_COOKIE['member_id'];
        if(empty($member_id)){
            $member_id = 0;
            $member_type = 0;
        }
        else
        {
            $member = M('member')->where("id=$member_id")->find();
            $member_type = $member['type'];
        }
        $this->assign("member_id",$member_id);
        $this->assign("member_type",$member_type);
        
        $this->display();
    }
    
    public function getData(){
        $sort_id = $_POST['sort_id'];
        $CurrentPage = $_POST['CurrentPage'];
        $search = check_input($_POST['search']);
        $order = check_input($_POST['order']);
        $where = " and is_sale=1";
        $paginalNum = 6;
        if($sort_id==null)
        {
            $sort_id = "0";
        }
        $children_sort_id = getAllChildrenID($sort_id,"product_sort");
        $children_sort_id = "'".$sort_id."',".$children_sort_id;
        $children_sort_id = substr($children_sort_id,0,mb_strlen($children_sort_id)-1);
        
        if($CurrentPage==null||$CurrentPage<=0)
        {
            $CurrentPage = 1;
        }
        if($order==null)
        {
            $order = "sequence_id desc";
        }
        if($search!="")
        {
            $where .= " and title like '%{$search}%'";
        }
        $where .= " and sort_id in ($children_sort_id)";
        if(strpos($where,'and') !== false)
        {
            $where = substr($where,4);
        }
        // print_r($where);
        $data = M('product')
            ->Field('id,title,picture,original_price,current_price')
            ->where($where)
            ->order($order)
            ->limit(($CurrentPage-1)*$paginalNum,$paginalNum)
            ->select();
        if($data!=null)
        {
            $result = array("status"=>"ok","rows"=>$data);
        }
        else
        {
            $result = array("status"=>"null");
        }
        exit(json_encode($result));
    }
    public function sort()
    {
        $sort_id = $_GET['id'];
        $this->assign("sort_id",$sort_id);
        $one_sort = M("product_sort")->field("id,parent_id,sort_name")->where("is_sale=1 and parent_id=0")->order("sequence_id asc")->select();
        $sort_array = array();
        if($one_sort!=null)
        {
            $one_array = array();
            foreach($one_sort as $one_sort)
            {
                $one_id = $one_sort["id"];
                $two_sort_id = getChildrenID($one_id,"product_sort");
                $two_sort = M("product_sort")->field("id,parent_id,sort_name")->where("is_sale=1 and id in ($two_sort_id)")->order("sequence_id desc")->select();
                $two_array = array();
                if($two_sort!=null)
                {
                    $three_array = array();
                    foreach($two_sort as $two_sort)
                    {
                        $two_id = $two_sort["id"];
                        $three_sort_id = getChildrenID($two_id,"product_sort");
                        $three_sort = M("product_sort")->field("id,parent_id,sort_name,picture")->where("is_sale=1 and id in ($three_sort_id)")->order("sequence_id desc")->select();
                        array_push($three_array,$three_sort); 
                        $array2 = array("two_sort"=>$two_sort, "three_sort"=>$three_sort);
                        array_push($two_array,$array2); 
                        //print_r($array2);
                    }
                    //print_r($two_array);
                }
                $array1 = array("one_sort"=>$one_sort, "two_sort"=>$two_array);
                array_push($one_array,$array1); 
            }
            // print_r($one_array);
            $this->assign("ProductSort",$one_array);
        }
        $this->display();
    }
    public function get_children_sort()
    {
        $sort_id = $_GET['id'];
        $two_sort_id = getChildrenID($sort_id,"product_sort");
        if($two_sort_id==null)
        {
            $two_sort_id = $sort_id;
        }
        $two_sort = M("product_sort")->field("id,parent_id,sort_name")->where("is_sale=1 and id in ($two_sort_id)")->order("sequence_id desc")->select();
        $two_array = array();
        if($two_sort!=null)
        {
            $three_array = array();
            foreach($two_sort as $two_key => $two_value)
            {
                $two_id = $two_value["id"];
                $three_sort_id = getChildrenID($two_id,"product_sort");
                if($three_sort_id==null)
                {
                    $three_sort_id = $two_id;
                }
                $three_sort = M("product_sort")->field("id,parent_id,sort_name,picture")->where("is_sale=1 and id in ($three_sort_id)")->order("sequence_id desc")->select();
                if($three_sort==null)
                {
                    $three_sort = array();
                }
                $two_sort[$two_key]["children"] = $three_sort;
            }
        }
        else
        {
            $two_sort = array();
        }
        $data = $two_sort;
        $result = array("status"=>"ok","msg"=>"请求成功","data"=>$data);
        $json_result = json_encode($result,JSON_UNESCAPED_UNICODE);
        $json_result = str_replace("null","",$json_result);
        exit($json_result);
    }
    public function get_root_sort(){
        $sort = M("product_sort")->field("id,parent_id,sort_name")->where("is_sale=1 and parent_id=0")->order("sequence_id asc")->select();
        if($sort==null)
        {
            $sort = array();
        }
        $result = array("status"=>"ok","msg"=>"请求成功","data"=>$sort);
        $json_result = json_encode($result,JSON_UNESCAPED_UNICODE);
        $json_result = str_replace("null","",$json_result);
        exit($json_result);
    }
    public function recommend_sort(){
        $advertisement = M('advertisement')
            ->where("location=4")
            ->order("sequence_id desc")
            ->limit(7)
            ->select();
        $one_sort = M("product_sort")
            ->field("id,parent_id,sort_name")
            ->where("is_sale=1 and parent_id=0")
            ->order("sequence_id asc")
            ->limit(7)
            ->select();
        $sort_array = array();
        if($one_sort!=null)
        {
            foreach($one_sort as $one_key => $one_value)
            {
                $one_id = $one_value["id"];
                $two_sort_id = getChildrenID($one_id,"product_sort");
                $two_sort = M("product_sort")->field("id,parent_id,sort_name,picture")->where("is_sale=1 and id in ($two_sort_id)")->order("sequence_id desc")->select();
                $one_sort[$one_key]['children'] = $two_sort;
                $one_sort[$one_key]['advertisement'] = $advertisement[$one_key];
            }
            $this->assign("sort",$one_sort);
        }

        //banner图
        $banner = M('mall_banner')->order("sequence_id desc")->select();
        $this->assign("banner",$banner);

        $this->display();
    }
    public function show()
    {
        $member_id = $_COOKIE['member_id'];
        if(empty($member_id)){
            $member_id = 0;
            $member_type = 0;
        }
        else
        {
            $member = M('member')->where("id=$member_id")->find();
            $member_type = $member['type'];
            if($member_type=="0")
            {
                $this->assign("is_tishi",$member["is_tishi"]);
                if($member['is_tishi']=="0")
                {
                    $edit_member = M('member')->where("id=$member_id")->data(array("is_tishi"=>1))->save();
                }
            }
            else
            {
                $this->assign("is_tishi",1);
            }
        }
        $this->assign("member_id",$member_id);
        $this->assign("member_type",$member_type);
        $id = $_GET['id'];
        $this->assign("id",$id);
        $this->display();
    }
    public function getPrice(){
        $product_id = $_POST['id'];
        $spec = $_POST['spec'];
        $click_spec = $_POST['click_spec'];
        $product = M("product")->where("id=$product_id")->find();
        if($product!=null)
        {
            $status = "false";
            //价格
            $IsTrue = "false";
            //数据库产品属性字符串
            $spec_json = $product['spec'];
            $spec_array = json_decode($spec_json,true);
            $spec_key_user = array_keys($spec);  //用户选择的规格的键
            $spec_key_xitong = array_keys($spec_array[0]);  //用户选择的规格的键
            $spec_key_xitong = array_slice($spec_key_xitong,0,count($spec_key_xitong)-3);
            if(count($spec_key_user)==count($spec_key_xitong))
            {
                foreach ($spec_array as $key => $value) {
                    $array_IsTrue=array();
                    for($i=0; $i<count($spec_key_xitong); $i++)
                    {
                        $spec_key = $spec_key_xitong[$i];
                        if($value[$spec_key] == $spec[$spec_key])
                        {
                            array_push($array_IsTrue, "true");
                        }
                        else
                        {
                            array_push($array_IsTrue, "false");
                            continue;
                        }
                    }
                    
                    foreach ($array_IsTrue as $IsTrue_value) {
                        if($IsTrue_value=="true")
                        {
                            $IsTrue = "true";
                        }
                        else
                        {
                            $IsTrue = "false";
                            break;
                        }
                    }
                    if($IsTrue=="true")
                    {
                        $original_price = $value['原价'];
                        $current_price = $value['现价'];
                        $reserve = $value['库存'];
                        $status = "ok";
                        break;
                    }
                }
            }
            //图片
            // $spec_pic_json = $product['spec_picture'];
            // $spec_pic_array = json_decode($spec_pic_json,true);

            // $result = array("status"=>"ok","original_price"=>$original_price,"current_price"=>$current_price,"Picture"=>$Picture,"reserve"=>$reserve);
            // exit(json_encode($result));
            
            $result = array("status"=>$status,"original_price"=>$original_price,"current_price"=>$current_price,"reserve"=>$reserve,"picture"=>$spec_picture);
            exit(json_encode($result));
        }
    }
}