<?php
namespace Phone\Controller;
class UploadController extends BaseController {
	/**
    * @api {GET} Upload/upload  上传图片
    * @apiGroup 上传
    * @apiDescription 上传图片
    * @apiParam {object} file 图片
    * @apiParam {string} type 图片类型。Product(产品)/Headportrait(头像)/WorkCircle(工友圈)
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccess (成功) {array} data 上传成功后的图片路径
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": [
    			1.png,2.png,3.png
    		]
    *   }
    * @apiError (失败) {int} code 状态吗
    * @apiError (失败) {String} msg 信息
    * @apiErrorExample {json} 失败返回
    *   {
    *       "code": 400,
    *       "msg": "XXx"
    *   }
    */
	public function upload1(){
        date_default_timezone_set('PRC');
        function extension($n){
            return substr($n, strripos($n, '.')+1);
        }
        function isdate(){
            return md5(date('YmdHis').mt_rand(1000, 9999));
        }
        $name = "file";
        $file = $_FILES[$name];
		
        $type = $_POST['type'];
        $array_file = array();
        if(!empty($file))
        {
        	for ($i=0; $i < count($file["name"]); $i++) { 
	            if($file["error"][$i]==0){
	                $filename = $file["name"][$i];
	                $filepath = "public/upload/{$type}/";
	                $ext = exTension($filename);
	                $filename = isdate().'.'.$ext;
	                $msg = move_uploaded_file($file['tmp_name'][$i],$filepath.$filename);
	                if($msg>0)
	                {
	                    array_push($array_file, $filepath.$filename);
	                }
	                else
	                {
	                    $result=array("code"=>"500","msg"=>"上传失败");
	                    exit(json_encode($result,JSON_UNESCAPED_UNICODE));
	                }
	            }  
	        }
	        $result=array("code"=>"200","msg"=>"上传成功","data"=>$array_file);
	        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
        else
        {
        	$result=array("code"=>"404","msg"=>"请选择要上传的图片");
	        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
    }
    public function ceshi(){
        $upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     31457280 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     "public/upload/WorkCircle/";
	    $upload->savePath  =     ''; // 设置附件上传（子）目录
	    // 上传文件 
	    $info   =   $upload->upload();
	    if(!$info) {// 上传错误提示错误信息
	        // $this->error($upload->getError());
	        print_r($upload->getError());
	    }else{// 上传成功
    	 	$arr=array(); 
    	 	foreach($info as $file){
    	 		$arr[]=$upload->rootPath.$file['savepath'].$file['savename']; 
    	 	} 
	        print_r($arr);
	    }
    }
    public function upload(){
        $file = $this->request->file('picture');
        print_r(json_encode($file));
        $info = $_FILES;
        print_r(json_encode($info));
        exit();
        foreach ($file as $key =>$val){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728 ;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = 'public/upload/{$type}/'; // 设置附件上传根目录
            $upload->savePath = ''; // 设置附件上传（子）目录
            $upload->saveName = 'msectime';
            // 上传文件
            $info = $upload->uploadOne($val);
            print_r($key);
            $print_r($upload->rootPath. $info['savepath'].$info['savename']);
            print_r("____");
            // $files[] = $upload->rootPath. $info['savepath'].$info['savename'];
        }
    }
}
    
    
    
    
    
    
    
    
    
    
    
    
    
