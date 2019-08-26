<?php
namespace APP\Controller;
class ShoppingCartController extends BaseController {
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
    * @api {POST} ShoppingCart/add  购物车添加
    * @apiGroup 购物车
    * @apiDescription 购物车添加
    * @apiParam {int} id 产品标识
    * @apiParam {int} member_id 会员标识
    * @apiParam {int} count 产品数量
    * @apiParam {int} spec 产品规格。格式：{"颜色":"红色","大小":"43"}
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 信息
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "添加成功"
    *   }
    */
    public function add(){
        $member_id = $_POST['member_id'];
        $member = M('member')->where("id=$member_id")->find();
        $product_id = $_POST['id'];
        $count = $_POST['count'];
        if($count==null||$count<1)
        {
            $count = 1;
        }
        
        $spec = $_POST['spec'];
        
        $product = M('product')->where("id=$product_id")->Field('title,picture,original_price,current_price')->find();
        if(!empty($product))
        {
            //根据选择规格获取价格
            $spec_array = json_decode($spec,true);
            $price = getPrice($product_id,$spec_array,$member['type']);
            if($price['status']=="ok")
            {
                $current_price = $price['current_price'];
                $original_price = $price['original_price'];
                $reserve = $price['reserve'];
                
                $time = date("Y-m-d H:i:s");
                $result = M('shopping_cart')
                    ->data(array(
                        'member_id'=>$member_id,
                        'product_id'=>$product_id,
                        'product_name'=>$product['title'],
                        'product_picture'=>$product['picture'],
                        'product_original_price'=>$original_price,
                        'product_current_price'=>$current_price,
                        'count'=>$count,
                        'product_spec'=>$spec
                    ))
                    ->add();
                if($result>0)
                {
                    $result = array("code"=>"200","msg"=>"加入购物车成功");
                }
                else
                {
                    $result = array("code"=>"500","msg"=>"加入购物车失败");
                }
            }
            else
            {
                $result = array("code"=>"500","msg"=>"获取价格失败");
                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
            
        }
        else
        {
            $result = array("code"=>"404","msg"=>"产品不存在");
        }
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    /**
    * @api {POST} ShoppingCart/delete  购物车删除
    * @apiGroup 购物车
    * @apiDescription 购物车删除
    * @apiParam {int} id 地址标识  例1：1。  例2：1,2,3
    * @apiParam {int} member_id 当前会员
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 信息
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "添加成功"
    *   }
    */
    public function delete(){
        $id = $_POST['id'];
        if(!empty($id))
        {
            $member_id = $_POST['member_id'];
            $result = M("shopping_cart")->where("id in ($id) and member_id=$member_id")->delete();
            if ($result>0) {
                $result = array("code"=>"200","msg"=>"删除成功");
            }else {
                $result = array("code"=>"400","msg"=>"删除失败");
            }
        }
        else
        {
            $result = array("code"=>"404","msg"=>"请选择要删除的数据");
        }
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    /**
    * @api {GET} ShoppingCart/getData  获取购物车信息
    * @apiGroup 购物车
    * @apiDescription 获取购物车信息
    * @apiParam {int} member_id 会员标识
    * @apiParam {int} CurrentPage 当前页
    * @apiParam {int} paginalNum 一页显示数量
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 标识
    * @apiSuccess (成功) {string} data.title 产品名称
    * @apiSuccess (成功) {string} data.picture 产品缩略图
    * @apiSuccess (成功) {string} data.count 数量
    * @apiSuccess (成功) {string} data.current_price 现价
    * @apiSuccess (成功) {object} data.spec 规格
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": [{
    *           "id":"15",
                "product_id":"67",
    *           "title":"枣夹核桃",
    *           "picture":"public/upload/Product/c242977fd594041813e25359bdcc5836.jpg",
    *           "count":"5",
    *           "current_price":"250",
    *           "spec":{
                    "颜色":"红色","大小":"43"
                }
    *       }]
    *   }
    * @apiError (失败) {int} code 状态吗
    * @apiError (失败) {String} msg 信息
    * @apiErrorExample {json} 失败返回
    *   {
    *       "code": 400
    *       "msg": "登陆失败"
    *   }
    */
    public function getData(){
        $member_id = $_COOKIE["member_id"];
        $CurrentPage = $_GET['CurrentPage'];
        $paginalNum = $_GET['paginalNum'];
        if($CurrentPage==null||$CurrentPage<=0)
        {
            $CurrentPage = 1;
        }
        if(empty($paginalNum)||$paginalNum<=0)
        {
            $paginalNum = 5;
        }
        $table = "shopping_cart";
        $paginalNum = 8;

        $StripeNumber=M($table)
            ->where("member_id=$member_id")
            ->count();

        $group_store = M('shopping_cart a')
            ->field("b.store_id,c.name store_name","left")
            ->join("product b on b.id=a.product_id","left")
            ->join("store c on c.id=b.store_id","left")
            ->where("a.member_id=$member_id")
            ->group('b.store_id')
            ->order("a.id desc")
            ->limit(($CurrentPage-1)*$paginalNum,$paginalNum)
            ->select();
        if(!empty($group_store))
        {
            foreach ($group_store as $key => $value) {
                $store_id = $value['store_id'];
                $product = M('shopping_cart a')
                    ->field(
                        "a.id,
                        a.product_name title,
                        a.product_picture picture,
                        a.count,
                        a.product_spec spec,
                        a.product_current_price current_price,
                        a.product_id,
                        b.store_id"
                    )
                    ->join("product b on b.id=a.product_id","left")
                    ->where("a.member_id=$member_id and b.store_id=$store_id")
                    ->select();
                $group_store[$key]['rows'] = $product;
            }
        }
        else
        {
            $group_store = array();
        }

        $new_Data = array("count"=>$StripeNumber,"shop"=>$group_store);
        $result = array("code"=>"200","msg"=>"获取数据成功","data"=>$new_Data);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
}