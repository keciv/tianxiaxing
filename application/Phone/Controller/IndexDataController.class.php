<?php
namespace Phone\Controller;
class IndexDataController extends BaseController{
    public function index(){

        //首页推荐分类
    	$recommend_sort = M('product_sort')->where("index_recommend=1")->order("sequence_id desc")->limit(4)->select();
        if($recommend_sort==null)
        {
            $recommend_sort = array();
        }
        //最新公告
        $news=M("mall_new")->order("sequence_id desc")->limit(6)->select();
        if($news==null)
        {
            $news = array();
        }

        //banner图
        $banner = M('mall_banner')->order("sequence_id desc")->select();
        if($banner==null)
        {
            $banner = array();
        }
        //推荐的工友圈
        $worker = M('worker_circle')->where("recommend=1")->order("sequence_id desc")->select();
        foreach ($worker as $key => $worker_value) {
            $commentary = M('circle_commentary')
                ->where("circle_id={$worker_value['id']}")
                ->count();
            $worker[$key]["commentary"] = $commentary;
        }
        if($worker==null)
        {
            $worker = array();
        }
        //推荐的产品
        $recommend_product = M('product')->where("mall_recommend=1")->order("sequence_id desc")->limit(6)->select();
        if($recommend_product==null)
        {
            $recommend_product = array();
        }
        //广告
        $advertisement1 = M('advertisement')->where("location=1")->order("sequence_id desc")->limit(3)->select();
        if($advertisement1==null)
        {
            $advertisement1 = array();
        }
        $advertisement2 = M('advertisement')->where("location=2")->order("sequence_id desc")->limit(3)->select();
        if($advertisement2==null)
        {
            $advertisement2 = array();
        }
        $advertisement3 = M('advertisement')->where("location=3")->order("sequence_id desc")->limit(3)->select();
        if($advertisement3==null)
        {
            $advertisement3 = array();
        }
        //实时价格
        $realtime = M('product')->where("is_sale=1 and real_time=1")->order("sequence_id desc")->limit(5)->select();
        if($realtime==null)
        {
            $realtime = array();
        }

        $data = array("recommend_sort"=>$recommend_sort,"news"=>$news,"banner"=>$banner,"worker"=>$worker,"product"=>$recommend_product,"advertisement1"=>$advertisement1,"advertisement2"=>$advertisement2,"advertisement3"=>$advertisement3,"realtime"=>$realtime);
        $result = array("status"=>"ok","msg"=>"请求成功","data"=>$data);
        $json_result = json_encode($result);
        $json_result = str_replace("null","",$json_result);
        print_r($json_result);
    }
}