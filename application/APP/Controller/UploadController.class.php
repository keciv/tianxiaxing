<?php
namespace APP\Controller;
class UploadController extends BaseController {
	/**
    * @api {GET} Upload/upload  上传图片
    * @apiGroup 上传
    * @apiDescription 上传图片
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

	public function upload(){
        $type = $_POST['type'];
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     204800 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     "public/upload/{$type}/";
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // $upload->saveName = 'msectime';
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            // $this->error($upload->getError());
            $result=array("code"=>"404","msg"=>$upload->getError());
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }else{// 上传成功
            $arr=array(); 
            foreach($info as $file){
                $arr[]=$upload->rootPath.$file['savepath'].$file['savename']; 
            } 
            $result=array("code"=>"200","msg"=>"上传成功","data"=>$arr);
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
    }
}
    
    
    
    
    
    
    
    
    
    
    
    
    
