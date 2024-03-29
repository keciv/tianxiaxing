<?php
namespace APP\Controller;
class MyCenterController extends BaseController {
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $cookie_member = $_COOKIE["member_id"];
        if(empty($cookie_member))
        {
            $result = array("code"=>"404","msg"=>"您尚未登陆或登陆已过期");

            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
    }
	/**
    * @api {GET} MyCenter/getData  个人中心相关数据
    * @apiGroup 个人中心
    * @apiDescription 个人中心相关数据
    * @apiParam {int} member_id 会员标识
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 标识
    * @apiSuccess (成功) {object} data.member 会员信息
    * @apiSuccess (成功) {string} data.member.id 会员标识
    * @apiSuccess (成功) {string} data.member.nickname 会员昵称
    * @apiSuccess (成功) {string} data.member.phone 手机号
    * @apiSuccess (成功) {string} data.member.headportrait 会员头像
    * @apiSuccess (成功) {object} data.order 订单信息
    * @apiSuccess (成功) {string} data.order.daifukuan 待付款
    * @apiSuccess (成功) {string} data.order.daifahuo 待发货
    * @apiSuccess (成功) {string} data.order.daishouhuo 待收货
    * @apiSuccess (成功) {string} data.order.daipingjia 待评价
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": {
    *           "member": {
    				"id": "17",
					"nickname": "浪一下",
					"phone": "13888888888",
					"headportrait": "1.png"
    			},
    *           "order": {
					"daifukuan":"1",
					"daifahuo":"2",
					"daishouhuo":"3",
					"daipingjia":"4"
    			}
    *       }
    *   }
    * @apiError (失败) {int} code 状态吗
    * @apiError (失败) {String} msg 信息
    * @apiErrorExample {json} 失败返回
    *   {
    *       "code": 404
    *       "msg": "获取失败"
    *   }
    */
    public function getData(){
    	$member_id = $_GET['member_id'];
  		$member = M("member")->field("id,nickname,phone,headportrait")->where("id=$member_id")->find();
  		if(empty($member))
  		{
  			$result = array("code"=>"404","msg"=>"会员不存在");
        	exit(json_encode($result,JSON_UNESCAPED_UNICODE));
  		}
    	$headportrait = $member['headportrait'];
        if(stripos($headportrait,"http")===false)
        {
            //$member['headportrait'] = "http://www.tyjpkj.com/".$headportrait;
          	$member['headportrait'] = $headportrait;
        }

        $order_count1 = M('order_form')->where("order_status=0 and member_id=$member_id")->count();
        $order_count2 = M('order_form')->where("order_status=1 and member_id=$member_id")->count();
        $order_count3 = M('order_form')->where("order_status=2 and member_id=$member_id")->count();
        $order_count4 = M('order_form')->where("order_status=3 and member_id=$member_id")->count();
        if(empty($order_count1))
        {
        	$order_count1 = 0;
        }
        if(empty($order_count2))
        {
        	$order_count2 = 0;
        }
        if(empty($order_count3))
        {
        	$order_count3 = 0;
        }
        if(empty($order_count4))
        {
        	$order_count4 = 0;
        }
        $order = array("daifukuan"=>$order_count1,"daifahuo"=>$order_count2,"daishouhuo"=>$order_count3,"daipingjia"=>$order_count4);
        $data = array("member"=>$member,"order"=>$order);
        $result = array("code"=>"200","msg"=>"获取数据成功","data"=>$data);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    public function add_dianpu(){
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $addressInfo = $_POST['addressInfo'];
        $address = $_POST['address'];
        $member_id = $_COOKIE["member_id"];
        if(empty($name)||empty($phone)||empty($addressInfo)||empty($address))
        {
            $result = array("code"=>"500","msg"=>"请填写完整信息");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }

        $add_dianpu = M('dianpu')
            ->data(array(
                "name"=>$name,
                "phone"=>$phone,
                "addressInfo"=>$addressInfo,
                "address"=>$address,
                "member_id"=>$member_id,
                "create_time"=>time()
            ))
            ->add();
        if($add_dianpu>0)
        {
            $result = array("code"=>"200","msg"=>"申请成功");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
        else{
            $result = array("code"=>"500","msg"=>"申请失败，请重新申请");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
    }
    public function Leaderboard(){
        $todaystart = date("Y-m-d 19:00:00",strtotime("-1 day"));
        $todayend = date("Y-m-d 19:00:00",time());
        // print_r($todaystart);
        // print_r($todaystart);
        // print_r($todayend);
        // $order_package = M('order_package')->where("create_time>$todaystart")->count('distinct member_id');
        // $order_package = M('order_package')
        //     ->field("member_id,count(*) as num")
        //     ->where("create_time>$todaystart")
        //     ->group('member_id')
        //     ->order("num desc")
        //     ->select();
        $order_package = M('order_package as a')
            ->field("b.inviter_id as member_id,count(*) as num")
            ->join("member as b on a.member_id=b.id")
            ->where("a.create_time>='$todaystart' and a.create_time<='$todayend' and b.inviter_id<>0 and a.count=1 and a.is_first=1 and a.order_status<>0")
            ->group('a.member_id')
            ->group('b.inviter_id')
            ->order("num desc")
            ->select();

        $total_order = M('order_package as a')
            ->join("member as b on a.member_id=b.id")
            ->where("a.create_time>='$todaystart' and a.create_time<='$todayend' and b.inviter_id<>0 and a.count=1 and a.is_first=1 and a.order_status<>0")
            ->count();

        $rule = M('integral_rule')->order('id desc')->find();
        $ranking_ratio = $rule['ranking_ratio'];
        $ratio = explode(",",$ranking_ratio);
        $total_commission = $rule['bonus'] * $total_order;
        // print_r($total_commission);

        if(!empty($order_package))
        {
            $rank = 1;
            foreach ($order_package as $key => $value) {
                $member = M('member')->field("id,headportrait,nickname")->where("id={$value['member_id']}")->find();

                if($key=="0")
                {
                    $order_package[$key]['commission'] = $total_commission * $ratio[$key];
                    $order_package[$key]['rank'] = "第".$rank."名";
                    $rank++;
                }
                else
                {
                    //推荐人数一样，同一级
                    // print_r($value['num'] - $order_package[$key-1]['num']);
                    if($value['num'] - $order_package[$key-1]['num'] == 0)
                    {
                        $order_package[$key]['commission'] = $total_commission * $ratio[$key-1];
                        $order_package[$key]['rank'] = "第".($rank-1)."名";
                    }
                    // //比上一个人推荐的人数还多。出错啦
                    // else if($value['num'] - $order_package[$key-1]['num'] > 0){
                    //     $result = array("code"=>"500","msg"=>"获取排行榜失败");
                    //     exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                    // }
                    else
                    {
                        $order_package[$key]['commission'] = $total_commission * $ratio[$key];
                        $order_package[$key]['rank'] = "第".$rank."名";
                        $rank++;
                    }
                }

                $order_package[$key]['headportrait'] = $member['headportrait'];
                $order_package[$key]['nickname'] = $member['nickname'];
                
            }
        }
        else
        {
            $order_package = array();
        }
        $data = array(
            "total_commission"=>$total_commission,
            "leaderboard"=>$order_package
        );
        $result = array("code"=>"200","msg"=>"获取排行榜成功","data"=>$data);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
}
