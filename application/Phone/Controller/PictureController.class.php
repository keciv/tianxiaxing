<?php
namespace Phone\Controller;
class PictureController extends BaseController{
    public function index(){
        $id = $_GET['navigation_id'];
        $navigation = M('mall_navigation')
                ->where("id=$id")
                ->find();
        $this->assign("navigation",$navigation);
        $this->assign("id",$id);
    	$this->display();
    }
    
    public function show(){
        $id = $_GET['contentid'];
        $picture = M('mall_new')
            ->where("id=$id")
            ->find();
        if(!empty($new))
        {
            $navigation = M('mall_navigation')
                ->where("id={$new['navigation_id']}")
                ->find();
        }
        
        $this->assign("navigation",$navigation);
        $this->assign("picture",$picture);
        $this->assign("id",$id);
    	$this->display();
    }
}