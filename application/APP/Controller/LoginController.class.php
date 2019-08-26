<?php
namespace APP\Controller;
class LoginController extends BaseController{
    /**
    * @api {POST} Login/login  登陆
    * @apiGroup 登陆注册
    * @apiDescription 登陆
    * @apiParam {string} username 用户名
    * @apiParam {string} password 密码
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {string} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 会员标识
    * @apiSuccess (成功) {string} data.password 会员密码
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": {
    *           "id":"15",
    *           "password":"123456"
    *       }
    *   }
    * @apiError (失败) {int} code 状态吗
    * @apiError (失败) {string} msg 信息
    * @apiErrorExample {json} 失败返回
    *   {
    *       "code": 400
    *       "msg": "登陆失败"
    *   }
    */
	public function login(){
		$username = $_POST['username'];
		$password = $_POST['password'];
        // $password = md5($password);
        if($username==null)
        {
            $result = array("code"=>"404","msg"=>"请输入用户名");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
        if($password==null)
        {
            $result = array("code"=>"404","msg"=>"请输入密码");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
		//用户是否存在
        $member = M('member')->where("username='$username' or phone='$username'")->find();
        //存在
        if($member!=null)
        {
            //判断密码是否一致
            if($password==$member["password"]||md5($password)==$member["password"])
            {
                cookie('member_id',$member["id"],3600*24*7);
                $result = array("code"=>"200","msg"=>"登陆成功");
                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
            else
            {
                $result = array("code"=>"500","msg"=>"登陆失败");
                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
        }
        else
        {
            $result = array("code"=>"404","msg"=>"用户不存在");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
	}
    public function drop_out(){
        cookie("member_id", NULL);
        $result = array("code"=>"200","msg"=>"退出成功");
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    /**
    * @api {POST} Login/qq_login  QQ登陆
    * @apiGroup 登陆注册
    * @apiDescription QQ登陆
    * @apiParam {string} openid 唯一标识
    * @apiParam {string} nickname 昵称
    * @apiParam {string} headportrait 头像
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {string} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 会员标识
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": {
    *           "id":"15"
    *       }
    *   }
    * @apiError (失败) {int} code 状态吗
    * @apiError (失败) {string} msg 信息
    * @apiErrorExample {json} 失败返回
    *   {
    *       "code": 400
    *       "msg": "登陆失败"
    *   }
    */
	public function qq_login(){
        $openid = $_POST["openid"];  //（用户唯一标识）
        $nickname = $_POST["nickname"];  //昵称
        $headportrait = $_POST["headportrait"]; //头像
        $member=M('member')->where("oauth='qq' and openid='$openid'")->find();
        if(empty($member))
        {
            $register=M("member")
                ->data(array(
                    'oauth'=>"qq",
                    'openid'=>$openid,
                    'nickname'=>$nickname,
                    'headportrait'=>$headportrait))
                ->add();
            $data = array("id"=>$register);
            if($register>0)
            {
                $result = array("code"=>"200","msg"=>"登陆成功","data"=>$data);
                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
            else
            {
                $result = array("code"=>"500","msg"=>"登陆失败");
                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
        }
        else
        {
            $data = array("id"=>$member['id']);
            $result = array("code"=>"200","msg"=>"登陆成功","data"=>$data);
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
	}
    /**
    * @api {POST} Login/weixin_login  微信登陆
    * @apiGroup 登陆注册
    * @apiDescription 微信登陆
    * @apiParam {string} openid 唯一标识
    * @apiParam {string} nickname 昵称
    * @apiParam {string} headportrait 头像
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {string} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 会员标识
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": {
    *           "id":"15"
    *       }
    *   }
    * @apiError (失败) {int} code 状态吗
    * @apiError (失败) {string} msg 信息
    * @apiErrorExample {json} 失败返回
    *   {
    *       "code": 400
    *       "msg": "登陆失败"
    *   }
    */
	public function weixin_login(){
        $openid = $_POST["openid"];  //（用户唯一标识）
        $nickname = $_POST["nickname"];  //昵称
        $headportrait = $_POST["headportrait"]; //头像
        $member=M('member')->where("oauth='weixin' and openid='$openid'")->find();
        if(empty($member))
        {
            $register=M("member")
                ->data(array(
                    'oauth'=>"weixin",
                    'openid'=>$openid,
                    'nickname'=>$nickname,
                    'headportrait'=>$headportrait))
                ->add();
            $data = array("id"=>$register);
            if($register>0)
            {
                $result = array("code"=>"200","msg"=>"登陆成功","data"=>$data);
                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
            else
            {
                $result = array("code"=>"500","msg"=>"登陆失败");
                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
        }
        else
        {
            $data = array("id"=>$member['id']);
            $result = array("code"=>"200","msg"=>"登陆成功","data"=>$data);
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
    }
}