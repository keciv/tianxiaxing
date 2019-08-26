<?php
namespace Phone\Controller;
use Think\Upload;
class WorkController extends BaseController{
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
    public function show(){
        $id = $_GET["id"];
        $work = M('work')->where("id=$id")->find();
        $this->assign("work",$work);
        $this->display();
    }
	
	
	//图片上传
		public function upload(){
		date_default_timezone_set('PRC');
		function extension($n){
			return substr($n, strripos($n, '.')+1);
		}
		function isdate(){
			return md5(date('YmdHis').mt_rand(1000, 9999));
		}
		$name=$_POST['fileID'];
		$files =$_FILES['img'];
		if ($files['type']=="image/gif" ||$files['type']=="image/jpg" ||$files['type']=="image/jpeg" ||$files['type']=="image/png" ||$files['type']=="image/x-png") {
			if($files[error]==0){
				$filename=$files['name'];
				$filepath=$_POST["filePath"];
				$ext=exTension($filename);
				$filename=isdate().'.'.$ext;
				$msg=move_uploaded_file($files['tmp_name'],$filepath.$filename);	
				
				if ($msg>0) {
					$json=array(status=>"ok",filename=>$filepath.$filename);
					exit(json_encode($json));
				}else{
					$json=array(status=>"error");
					exit(json_encode($json));
				}
			}  
		}
		else{
			$json=array(status=>"null");
			exit(json_encode($json));
		}
	}
		
	//视频上传
	 public function viedo()
    {
    	function extension($n){
			return substr($n, strripos($n, '.')+1);
		}
		function isdate(){
			return md5(date('YmdHis').mt_rand(1000, 9999));
		}
           	$name=$_POST['fileID'];
			$files =$_FILES['viedo'];
			if ($files['type']=="video/mp4" ||$files['type']=="video/AVI" ||$files['type']=="video/mp4" ||$files['type']=="video/mov" ||$files['type']=="video/rm") {
			if($files[error]==0){
				$filename=$files['name'];
				$filepath=$_POST["filePath"];
				$ext=exTension($filename);
				$filename=isdate().'.'.$ext;
				$msg=move_uploaded_file($files['tmp_name'],$filepath.$filename);	
				if ($msg>0) {
					$json=array(status=>"ok",filename=>$filepath.$filename);
					exit(json_encode($json));
				}else{
					$json=array(status=>"error");
					exit(json_encode($json));
				}
			}  
		}
		else{
			$json=array(status=>"null");
			exit(json_encode($json));
		}
	}
        
    //获取前端数据
        public function insert(){
			if(IS_POST){
				$data = I();
				try{
					$db = M('work')->data(['member_id'=>$_COOKIE["member_id"],'picture'=>$data['img'],'video'=>$data['viedo'],'create_time'=>time()])->add();
				}catch(\Exception $e){
					echo('数据操作错误');
					die();	
				}
				if($db){
						$json=array(status=>"ok",msg=>555);
						exit(json_encode($json));
					}else{
						$json=array(status=>"error");
					exit(json_encode($json));
					}
			}
        }
    	
		
		
		
}