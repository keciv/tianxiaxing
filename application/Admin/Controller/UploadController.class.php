<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class UploadController extends BaseController {
	public function upload(){
		date_default_timezone_set('PRC');
		function extension($n){
			return substr($n, strripos($n, '.')+1);
		}
		function isdate(){
			return md5(date('YmdHis').mt_rand(1000, 9999));
		}
		$name=$_POST['fileID'];
		if ($_FILES[$name]['type']=="image/gif" ||$_FILES[$name]['type']=="image/jpg" ||$_FILES[$name]['type']=="image/jpeg" ||$_FILES[$name]['type']=="image/png" ||$_FILES[$name]['type']=="image/x-png") {
			if($_FILES[$name]['size']<512000)
			{
				if($_FILES[$name]["error"]==0){
					$filename=$_FILES[$name]["name"];
					$filepath=$_POST["filePath"];
					$ext=exTension($filename);
					$filename=isdate().'.'.$ext;
					$msg=move_uploaded_file($_FILES[$name]['tmp_name'],$filepath.$filename);
					if ($msg>0) {
						$json=array("status"=>"ok","filename"=>$filepath.$filename);
						exit(json_encode($json));
					}else{
						$json=array("status"=>"error");
						exit(json_encode($json));
					}
				}  
			}
			else
			{
				$json=array("status"=>"size");
				exit(json_encode($json));
			}
		}
		else{
			$json=array("status"=>"null");
				exit(json_encode($json));
		}
	}
	public function uploadFile(){
		date_default_timezone_set('PRC');
		function extension($n){
			return substr($n, strripos($n, '.')+1);
		}
		function isdate(){
			return md5(date('YmdHis').mt_rand(1000, 9999));
		}
		$name=$_POST['fileID'];
		if($_FILES[$name]["error"]==0){
			$filename=$_FILES[$name]["name"];
			$filepath=$_POST["filePath"];
			$ext=exTension($filename);
			$filename=isdate().'.'.$ext;
			$msg=move_uploaded_file($_FILES[$name]['tmp_name'],$filepath.$filename);
			if ($msg>0) {
				$json=array("status"=>"ok","filename"=>$filepath.$filename);
				exit(json_encode($json));
			}else{
				$json=array("status"=>"error");
				exit(json_encode($json));
			}
		}  
	}
	public function ckeditor_upload(){

		$riqi = date("Ymd");
        $path = "public/ckeditor/upload/".$riqi;
        if (!file_exists($path)){
            mkdir($path); 
        }

	    $cb = $_GET['CKEditorFuncNum']; //获得ck的回调id  

	    $filename=date("Ymd H:i:s",time()).rand(1000,9999);

		$upload = new \Think\Upload();// 实例化上传类    
		$upload->maxSize   =     3145728 ;// 设置附件上传大小    
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
		$upload->savePath  =      ''; // 设置附件上传目录    // 上传文件  
		$upload->rootPath =   "/public/ckeditor/upload/";
		$upload->subName = $riqi;
		$info   =   $upload->upload();    
		if(!$info) {// 上传错误提示错误信息         
			echo "<font color=\"red\"size=\"2\">*文件格式不正确（必须为.jpg/.gif/.bmp/.png文件）</font>";  
			//echo "<script>window.parent.CKEDITOR.tools.callFunction($cb, '', '$error');</script>"
		}
		else{// 上传成功 
			echo "<script>window.parent.CKEDITOR.tools.callFunction($cb, '$path', '');</script>"; //
		}

    }

}
    
    
    
    
    
    
    
    
    
    
    
    
    
