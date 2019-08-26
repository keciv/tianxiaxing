<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class TeamController extends BaseController {
    public function index(){
    	if(isset($_SESSION['admin']))
    	{
    		$id = $_GET['id'];
    		if($id!=null)
    		{
	    		$admin=$_SESSION['admin'];
		    	$this->assign("admin",$admin);
		    	$this->assign("id",$id);
		    	$this->display();
    		}
    		else{
    			$this->redirect("index/index");
    		}
    	}
    	else
    	{
    		$this->redirect("Login/index");
    	}
    }
    public function getData(){
        if(isset($_SESSION['admin']))
        {
            $firstID = $_POST['firstID'];
            $id = $_POST['id'];
            if($id==null)
            {
                $id = $firstID;
            }

            $yiji = M("member")->field("id,phone,username,create_time")->where("inviter_id=$id")->order('id desc')->select();
            if($yiji!=null)
            {
                foreach ($yiji as $key => $value) {

                    $children = $this->getAllChildrenID($value['id']);
                    $count = count(explode(",",$children));
                    $yiji[$key]['state'] = "closed";
                    $yiji[$key]['count'] = $count;
                }
            }
            else
            {
                $yiji = array();
            }
            exit(json_encode($yiji));
        }
        else
        {
            $this->redirect("Login/index");
        }
    }
    public function getAllChildrenID($id){
        $childrenID="";
        $member = M("member")->where("inviter_id=$id")->select();
        if($member>0)
        {
            foreach($member as $member){
                //echo $lanmu['id'];
                $childrenID .= "'".$member['id']."'";
                $childrenID .= ",";
                $childrenID .= $this->getAllChildrenID($member['id']);
            }
        }
        return $childrenID;
    }
}