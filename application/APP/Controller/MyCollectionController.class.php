<?php
namespace APP\Controller;
class MyCollectionController extends BaseController {
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
    * @api {GET} MyCollection/getData  获取我的收藏数据
    * @apiGroup 我的收藏
    * @apiDescription 获取我的收藏数据
    * @apiParam {int} CurrentPage 当前页
    * @apiParam {int} paginalNum 一页显示数量
    * @apiParam {int} member_id 会员标识
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 标识
    * @apiSuccess (成功) {string} data.product_title 产品标题
    * @apiSuccess (成功) {string} data.product_picture 产品缩略图
    * @apiSuccess (成功) {string} data.current_price 现价
    * @apiSuccess (成功) {string} data.unit 单位
    * @apiSuccess (成功) {string} data.status 状态 0(失效)/1(有效)
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": [{
    *           "id":"15",
    *           "product_title":"乌苏砖",
    *           "product_picture":"1.png",
    *           "price":"250",
    *           "unit":"块",
    *           "status":"1"
    *       }]
    *   }
    */
    public function getData(){
        $member_id = $_COOKIE["member_id"];
        $CurrentPage = $_GET['CurrentPage'];
        $paginalNum = $_GET['paginalNum'];
        if($CurrentPage==null || $CurrentPage<=0)
        {
            $CurrentPage = 1;
        }
        if($paginalNum==null || $paginalNum<=0)
        {
            $paginalNum = 6;
        }
        
        $collection = M('collection')
            ->field("id,product_title,product_picture")
            ->where("member_id=$member_id")
            ->order('id desc')
            ->limit(($CurrentPage-1)*$paginalNum,$paginalNum)
            ->select();
        if(!empty($collection))
        {
            foreach ($collection as $key_col => $value_col) {
                $product_id = $value_col['product_id'];
                $product = M('product')->where("id=$product_id")->find();
                if(empty($product))
                {
                    if($value_col['product_title']==null)
                    {
                        $collection[$key_col]['product_title'] = $product['title'];
                    }
                    if($value_col['product_picture']==null)
                    {
                        $collection[$key_col]['product_picture'] = $product['picture'];
                    }
                    $collection[$key_col]['current_price'] = $product['current_price'];
                    $collection[$key_col]['unit'] = $product['unit'];
                    $collection[$key_col]['status'] = "1";
                }
                else
                {
                    $collection[$key_col]['current_price'] = "";
                    $collection[$key_col]['unit'] = "";
                    $collection[$key_col]['status'] = "0";
                }
            }
        }
        else
        {
            $collection = array();
        }
        $result = array("code"=>"200","msg"=>"获取数据成功","data"=>$collection);

        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    /**
    * @api {POST} MyCollection/add  加入收藏
    * @apiGroup 我的收藏
    * @apiDescription 加入收藏
    * @apiParam {int} id 产品标识。 例1：1。  例2：1,2,3
    * @apiParam {int} member_id 会员标识
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx"
    *   }
    */
    public function add(){
        $member_id = $_COOKIE["member_id"];
        $id = $_POST['id'];
        $products_id = explode(',',$id);
        $array = [];
        $member = M();
        $member->startTrans();
        foreach ($products_id as $key => $product_id)
        {
        	$is_collection = M("collection")->where("product_id=product_id and member_id=$member_id")->find();
        	if(empty($is_collection))
        	{
        		$product = M('product')->where("id=$product_id")->find();
        		if($product!=null)
	            {
	            	
	                $result = M("collection")->data(array('product_id'=>$product_id,'member_id'=>$member_id,'product_title'=>$product['title'],'product_picture'=>$product['picture']))->add();
					array_push($array,$result);
	            }
	            else
	            {
	                $member->rollback();
	                $result = array("code"=>"500","msg"=>"产品不存在");
	                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
	            }
        	}
        	else{
        		array_push($array,$is_collection['id']);
        	}
        }

        $member->commit();
        $result = array("code"=>"200","msg"=>"收藏成功","data"=>$array);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    /**
    * @api {POST} MyCollection/delete  移除收藏
    * @apiGroup 我的收藏
    * @apiDescription 移除收藏
    * @apiParam {int} id 地址标识。例1：1。  例2：1,2,3
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
        $member_id = $_POST['member_id'];
        $id = $_POST['id'];
        if(!empty($id))
        {
            $result = M("collection")->where("id in ($id)")->delete();
            if ($result>0) 
            {
                $result = array("code"=>"200","msg"=>"移除收藏成功");
            }
            else 
            {
                $result = array("code"=>"500","msg"=>"移除收藏失败");
            }
        }
        else
        {
            $result = array("code"=>"404","msg"=>"请选择要移除的收藏");
        }

        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
}
