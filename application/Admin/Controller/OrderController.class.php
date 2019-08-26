<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class OrderController extends BaseController {
    public function index(){
    	$this->display();
    }
    public function getData(){
    	$page = $_POST['page'];
        $rows = $_POST['rows'];
        $search = $_POST['search'];
        $value = $_POST['value'];

        if(isset($search)&&isset($value))
        {
            $where[$search] = $value;
        }
        else
        {
            $where = "";
        }

        $table = "order_form";
        $where['is_recycle'] = 0;
        $order = "id desc";
        $data = array();
        $order_form = M($table)
            ->field("id,ordernum,order_status,create_time")
            ->where($where)
            ->order($order)
            ->limit(($CurrentPage-1)*$paginalNum,$paginalNum)
            ->select();

        if(!empty($order_form))
        {
            $store = array();
            foreach ($order_form as $key => $order_every) {
                $count = 0;
                $order_id = $order_every['id'];
                $order_store = M('order_store')
                    ->field("id,store_id,order_id,store_name,order_status,payment_price,integral,ship_time")
                    ->where("order_id=$order_id and is_recycle=0")
                    ->select();
                if(!empty($order_store))
                {
                    foreach ($order_store as $store_key => $store_value) {
                        $store_value['ordernum'] = $order_every['ordernum'];
                        $store_value['create_time'] = $order_every['create_time'];
                        array_push($store, $store_value);
                    }
                }
            }
        }
        else
        {
            $store = array();
        }
        // $result = array("code"=>"200","msg"=>"获取订单成功","data"=>$order_store);
        exit(json_encode($store,JSON_UNESCAPED_UNICODE));
    }

    public function delete(){
        $id=$_POST['id'];
        if($id!=null)
        {
            $order_product = M("order_product")->where("order_id in ({$id})")->delete();
            $result = M("order_form")->where("id in ({$id})")->delete();
            if ($result>0 && $order_product>0) {
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
    public function logistics(){
        $order_id = $_POST['order_id'];
        $logistics = $_POST['logistics'];
        $express = $_POST['express'];
        $time = date('Y-m-d H:i');
        if($order_id==null)
        {
            exit("null_order_id");
        }
        if($logistics==null)
        {
            exit("null_logistics");
        }
        if($express==null)
        {
            exit("null_express");
        }
        $isHaveOrder = M('order_store')->where("id=$order_id")->find();
        if($isHaveOrder==null)
        {
            exit("no_order");
        }
        $result = M('order_store')->where("id=$order_id")->data(array("logistics_name"=>$logistics,"express"=>$express,"ship_time"=>$time,"order_status"=>2))->save();
        if($result>0)
        {
            exit("ok");
        }
        else
        {
            exit("error");
        }
    }
    
    public function show(){
        $id = $_GET['id'];
        $order_from = M("order_store")->where("id=$id")->find();
        $order_store = M("order_store a")
            ->field("a.*,b.ordernum,b.create_time")
            ->join("order_form b on a.order_id=b.id")
            ->where("a.id=$id")
            ->find();
  
        $order_product = M("order_product")->where("order_store=$id")->select();
        foreach ($order_product as $key => $value) {

            $price_type = explode("+",$value['product_current_price']);

            $price_yuan = $price_type[0];
            $price_jifen = $price_type[1];
            $xiaoji_yuan = $price_yuan * $value['product_num'];
            $xiaoji_jifen = $price_jifen * $value['product_num'];

            $order_product[$key]['xiaoji'] = $xiaoji_yuan ."+".$xiaoji_jifen;
        }
        
        $this->assign("order_store",$order_store);
        $this->assign("order_product",$order_product);
        $this->display();
    }

    public function package(){
        $this->display();
    }

    public function get_package(){
        $page = $_POST['page'];
        $rows = $_POST['rows'];
        $search = $_POST['search'];
        $value = $_POST['value'];

        if($search!=null&&$value!=null)
        {
            if($value=="全部"){
                $where = $search."<>''";
            }
            else{
                $where = $search."='".$value."'";
            }
        }
        else
        {
            $where = "";
        } 

        $count = M('order_package')
            ->Field('order_package.id as id')
            ->join('member on order_package.member_id=member.id')
            ->join('package on order_package.package_id=package.id')
            ->where($where)
            ->count();
        $content = M('order_package')
            ->Field('order_package.id as id,order_package.ordernum,order_package.product_price,order_package.create_time,order_package.ship_time,order_package.order_status,member.nickname,package.name as package')
            ->join('member on order_package.member_id=member.id')
            ->join('package on order_package.package_id=package.id')
            ->where($where)
            ->order('order_package.id desc')
            ->limit(($page-1)*$rows,$rows)
            ->select();
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

    public function package_show(){
        $id = $_GET['id'];
        $order = M("order_package")->where("id=$id")->find();
        $package = M("package")->where("id={$order['package_id']}")->find();
        
        $this->assign("order",$order);
        $this->assign("package",$package);
        $this->display();
    }

    public function package_logistics(){
        $order_id = $_POST['order_id'];
        $logistics = $_POST['logistics'];
        $express = $_POST['express'];
        $time = date('Y-m-d H:i');
        if($order_id==null)
        {
            exit("null_order_id");
        }
        // if($logistics==null)
        // {
        //     exit("null_logistics");
        // }
        // if($express==null)
        // {
        //     exit("null_express");
        // }
        $isHaveOrder = M('order_package')->where("id=$order_id")->find();
        if($isHaveOrder==null)
        {
            exit("no_order");
        }
        $result = M('order_package')->where("id=$order_id")->data(array("logistics_name"=>$logistics,"express"=>$express,"ship_time"=>$time,"order_status"=>2))->save();
        if($result>0)
        {
            exit("ok");
        }
        else
        {
            exit("error");
        }
    }

    public function package_delete(){
        $id=$_POST['id'];
        if($id!=null)
        {
            $result = M("order_package")->where("id in ({$id})")->delete();
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