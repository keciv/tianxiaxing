<?php
namespace Phone\Controller;
class MyCollectionController extends BaseController {
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
    public function getData(){
        if(isset($_COOKIE['memberID']))
        {
            $memberID=$_COOKIE['memberID'];
            $CurrentPage = $_POST['CurrentPage'];
            if($CurrentPage==null || $CurrentPage<=0)
            {
                $CurrentPage = 1;
            }
            $paginalNum = 6;
            
            $collection = M('collection')
                ->Field('collection.id,collection.create_time,collection.product_title,collection.product_picture,product.title,product.picture,product.current_price,product.unit')
                ->join('product on member.id = promotion.member_id')
                ->where("member_id=$memberID")
                ->order('id desc')
                ->limit(($CurrentPage-1)*$paginalNum,$paginalNum)
                ->select();
            $collection = M('collection')
                ->where("member_id=$memberID")
                ->order('id desc')
                ->limit(($CurrentPage-1)*$paginalNum,$paginalNum)
                ->select();
            if($collection!=null)
            {
                foreach ($collection as $key_col => $value_col) {
                    $product_id = $value_col['product_id'];
                    $product = M('product')->where("id=$product_id")->find();
                    if($product!=null)
                    {
                        if($value_col['product_title']==null)
                        {
                            $collection[$key_col]['product_title'] = $product['title'];
                        }
                        if($value_col['product_picture']==null)
                        {
                            $collection[$key_col]['product_picture'] = $product['picture'];
                        }
                        $collection[$key_col]['unit'] = $product['unit'];
                        $collection[$key_col]['status'] = "";
                    }
                    else
                    {
                        $collection[$key_col]['current_price'] = "";
                        $collection[$key_col]['unit'] = "";
                        $collection[$key_col]['status'] = "失效";
                    }
                }
                $result = array("status"=>"ok","rows"=>$collection);
            }
            else
            {
                $result = array("status"=>"null");
            }
            exit(json_encode($result));
        }
        else{
            $result = array("status"=>"login_null");
            exit(json_encode($result));
        }
    }
    public function add(){
        if(isset($_COOKIE['memberID'])){
            $memberID = $_COOKIE['memberID'];
            $id = $_POST['id'];
            $products_id = explode(',',$id);
            $member = M();
            $member->startTrans();
            foreach ($products_id as $key => $product_id)
            {
                $product = M('product')->where("id=$product_id")->find();
                if($product!=null)
                {
                    $result=M("collection")->data(array('product_id'=>$product_id,'member_id'=>$memberID,'product_title'=>$product['title'],'product_picture'=>$product['picture']))->add();
                }
                else
                {
                    $member->rollback();
                    exit("product_null");
                }
            }

            if(!in_array("0",$result))
            {
                $member->commit();
                exit("ok");
            }
            else
            {
                $member->rollback();
                exit("error");
            }
        }
        else
        {
            exit("login_null");
        }
    }
    public function delete(){
        if(isset($_COOKIE['memberID'])){
            $id = $_POST['id'];
            if($id != null)
            {
                // $id = implode(",",$id);
                $result = M("collection")->where("id in ($id)")->delete();
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
        else
        {
            exit("login_null");
        }
    }
}
