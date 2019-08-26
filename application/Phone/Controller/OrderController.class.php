<?php
namespace Phone\Controller;
class OrderController extends BaseController {
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $cookie_member = $_COOKIE["member_id"];
        if(empty($cookie_member))
        {
            $this->redirect('Login/index','页面跳转中...');
        }
        else
        {
            $this->assign("member_id",$cookie_member);
        }
    }
    public function index(){
        $this->display();
    }
    public function info(){
        $order_id = $_GET['order_id'];
        $store_id = $_GET['store_id'];
        $product_id = $_GET['product_id'];
        $order = M('order_form')
            ->where("id=$order_id")
            ->find();
        $this->assign("order",$order);
        $order_store = M("order_store")
            ->where("order_id=$order_id and store_id=$store_id")
            ->find();
        if($order_store['integral']>0)
        {
            $order_store['payment_price'] = $order_store['payment_price']."+".$order_store['integral'];
        }
        // print_r($order_store);
        $this->assign("order_store",$order_store);
        $order_product = M("order_product")
            ->where("order_store={$order_store['id']}")
            ->select();
        // print_r($order_product);
        $this->assign("order_product",$order_product);
        $this->display();
    }
}