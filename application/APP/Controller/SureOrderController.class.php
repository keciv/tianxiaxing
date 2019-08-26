<?php
namespace APP\Controller;
class SureOrderController extends BaseController{
    public function index(){
        if(isset($_COOKIE['memberID'])){
            $memberID = $_COOKIE['memberID'];
            $member = M('member')->where("id=$memberID")->find();
            if($member==null)
            {
                $this->redirect("Login/index");
            }
            $order_product = $_POST['order_product'];
            // print_r($order_product);
            $this->assign("order_product",$order_product);
            $order_products = json_decode($order_product,ture);
            $total = 0;
            // print_r(count($order_products));
            foreach ($order_products as $key => $value) {
                // print_r($key);
                $product_id = $value['id'];
                $product_spec = $value['spec'];
                $count = $value['count'];
                // print_r($product_id);
                // print_r("____");
                // print_r($product_spec);
                // print_r("____");
                // print_r($count);
                $product = M('product')->where("id=$product_id")->find();

                $price = getPrice($product_id,$product_spec,$member['type']);
                // print_r($price);
                if($price['status']=="ok")
                {
                    $current_price = $price['current_price'];
                    $original_price = $price['original_price'];
                    $reserve = $price['reserve'];
                }
                else
                {
                    print_r("获取价格错误");
                }

                $subtotal = $price['current_price'] * $count;
                $total += $subtotal;

                $order_products[$key]['title'] = $product['title'];
                $order_products[$key]['picture'] = $product['picture'];
                $order_products[$key]['reserve'] = $product['reserve'];
                $order_products[$key]['current_price'] = $current_price;
                $order_products[$key]['original_price'] = $original_price;
                $order_products[$key]['subtotal'] = $subtotal;
                $order_products[$key]['spec'] = json_decode($product_spec,true);
            }

            $sure_order = array("product"=>$order_products,"total"=>$total);
            // print_r($sure_order);
            $this->assign("sure_order",$sure_order);
            //默认地址
            $DefaultAddress = M("shopping_address")->where("is_default=1 and memberID=$memberID")->find();
            $this->assign("DefaultAddress",$DefaultAddress);
            $address = M('shopping_address')->where("memberID=$memberID")->order("is_default desc")->select();
            $this->assign("address",$address);
            $this->assign("title","确认订单");
            $this->display();
        }
        else
        {
            $this->redirect("Login/index");
        }
    }
    /**
    * @api {POST} SureOrder/getData  确认订单
    * @apiGroup 确认订单
    * @apiDescription 地址列表
    * @apiParam {int} member_id 会员标识
    * @apiParam {int} CurrentPage 当前页
    * @apiParam {int} paginalNum 一页显示数量
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 地址标识
    * @apiSuccess (成功) {string} data.name 收件人
    * @apiSuccess (成功) {string} data.phone 联系电话
    * @apiSuccess (成功) {string} data.province 省
    * @apiSuccess (成功) {string} data.city 市
    * @apiSuccess (成功) {string} data.district 区
    * @apiSuccess (成功) {string} data.address 详细地址
    * @apiSuccess (成功) {string} data.is_default 是否默认地址。0(否)/1(是)
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": [{
    *           "id":"15",
    *           "name":"嫦娥",
    *           "phone":"13888888888",
    *           "province":"银河系",
    *           "city":"太阳系",
    *           "district":"月球",
    *           "address":"广寒宫",
    *           "is_default":"1"
    *       }]
    *   }
    */
    public function getData(){
        $member_id = $_POST['member_id'];
        $member = M('member')->where("id=$member_id")->find();
        if(empty($member))
        {
            $result = array("code"=>"500","msg"=>"会员不存在");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
        $order_product = $_POST['order_product'];
        $order_products = json_decode($order_product,ture);
        $total = 0;
        if(json_last_error()==JSON_ERROR_UTF8)
        {
            foreach ($order_products as $key => $value) {
                $product_id = $value['id'];
                $product_spec = $value['spec'];
                $count = $value['count'];
                $product = M('product')->where("id=$product_id")->find();

                $price = getPrice($product_id,$product_spec);
                // print_r($price);
                if($price['status']=="ok")
                {
                    $current_price = $price['current_price'];
                    $original_price = $price['original_price'];
                    $reserve = $price['reserve'];
                }
                else
                {
                    $result = array("code"=>"500","msg"=>"获取价格失败");
                    exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                }

                $subtotal = $price['current_price'] * $count;
                $total += $subtotal;

                $order_products[$key]['title'] = $product['title'];
                $order_products[$key]['picture'] = $product['picture'];
                $order_products[$key]['reserve'] = $product['reserve'];
                $order_products[$key]['current_price'] = $current_price;
                $order_products[$key]['original_price'] = $original_price;
                $order_products[$key]['subtotal'] = $subtotal;
                $order_products[$key]['spec'] = json_decode($product_spec,true);
            }
        }
        else
        {
            $order_products = array();
        }

        //默认地址
        $DefaultAddress = M("shopping_address")->where("is_default=1 and member_id=$member_id")->find();
        $sure_order = array("total"=>$total,"address"=>$DefaultAddress,"product"=>$order_products);

        $result = array("code"=>"500","msg"=>"获取价格失败","data"=>$sure_order);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
}