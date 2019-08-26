<?php
namespace APP\Controller;
class IndexController extends BaseController{
    public function get_banner(){
        $banner = M('banner')->order("sequence_id desc")->limit("5")->select();
        if(empty($banner))
        {
            $banner = array();
        }
        $result = array("code"=>"200","msg"=>"获取Banner图成功","data"=>$banner);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    public function get_sort(){
        $sort = M('product_sort')->field("id,sort_name,picture")->where("is_sale=1 and index_recommend=1")->order("sequence_id desc")->limit("8")->select();
        if(empty($sort))
        {
            $sort = array();
        }
        $result = array("code"=>"200","msg"=>"获取产品分类成功","data"=>$sort);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    public function get_product(){
        $CurrentPage = $_GET['CurrentPage'];
        $paginalNum = $_GET['paginalNum'];
        $where = " and is_sale=1 and recommend=1";
        
        if($paginalNum==null||$paginalNum<=0)
        {
            $paginalNum = 8;
        }
        if($CurrentPage==null||$CurrentPage<=0)
        {
            $CurrentPage = 1;
        }
        if($order==null)
        {
            $order = "sequence_id desc";
        }
        
        if(strpos($where,'and') !== false)
        {
            $where = substr($where,4);
        }
        // print_r($where);
        // $content = M('product')
        //     ->Field('product.id as id,product.title,product.recommend,product.is_sale,product.sort_id,product_sort.sort_name')
        //     ->join('product_sort on product.sort_id=product_sort.id')
        //     ->where($where)
        //     ->order($order)
        //     ->limit(($CurrentPage-1)*$paginalNum,$paginalNum)
        //     ->select();
        $product = M('product')
            ->Field('id,title,picture,youke_price,huiyuan_price,dianpu_price,youke_unit,huiyuan_unit,dianpu_unit')
            ->where($where)
            ->order($order)
            ->limit(($CurrentPage-1)*$paginalNum,$paginalNum)
            ->select();
        if(empty($product))
        {
            $product = array();
        }
        $result = array("code"=>"200","msg"=>"获取产品成功","data"=>$product);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }

    public function get_new(){
        $news = M('mall_new')->field("id,title,picture")->where("navigation_id=4")->order("sequence_id desc")->limit("3")->select();
        if(empty($news))
        {
            $news = array();
        }
        $result = array("code"=>"200","msg"=>"获取公告成功","data"=>$news);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
}