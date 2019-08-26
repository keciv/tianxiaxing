<?php
namespace APP\Controller;
class RegisterController extends BaseController {
    /**
    * @api {POST} Register/register  注册
    * @apiGroup 登陆注册
    * @apiDescription 注册
    * @apiParam {string} phone 手机号
    * @apiParam {string} code 验证码
    * @apiParam {string} password 密码
    * @apiParam {string} passwordRepeat 确认密码
    * @apiParam {string} inviter 邀请人
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx"
    *   }
    */
    public function register(){
        $nickname = $_POST['nickname'];
		$phone = $_POST['phone'];
        $code = $_POST['code'];
        $password = $_POST['password'];
        $passwordRepeat = $_POST['passwordRepeat'];
        $inviter = $_POST['inviter'];
        if($inviter==null||$inviter<0)
        {
            $inviter=0;
        }
        // $s_phone = $_SESSION["phone"];
        // $s_code = $_SESSION["code"];

        // if($s_phone==$phone && $s_code==$code)
        // {
            if($nickname==null || $phone==null || $password==null || $passwordRepeat==null || $code=null)
            {
                $result = array("code"=>"404","msg"=>"请输入完整信息");
                exit(json_encode($result));
            }
            if($password!=$passwordRepeat)
            {
                $result = array("code"=>"404","msg"=>"两次密码输入不一致");
                exit(json_encode($result));
            }
            $inviter_id = 0;
            if($inviter!==0){
                $find = M("member")->where("phone=$inviter")->find();
                if(empty($find)){
                    $result = array("code"=>"404","msg"=>"很抱歉，没有这个推荐人");
                    exit(json_encode($result));
                }
                if($find['grade']=="0")
                {
                    $result = array("code"=>"500","msg"=>"抱歉，该账户还不是正式会员");
                    exit(json_encode($result));
                }
                $inviter_id = $find['id'];
            }
            $isHaveMember=M("member")->where("phone=$phone")->find();
            if($isHaveMember==null)
            {
                //注册
                $register=M("member")->data(array('nickname'=>$nickname,'phone'=>$phone,'password'=>md5($password),"inviter"=>$inviter,"inviter_id"=>$inviter_id))->add();

                if($register>0)
                {
                    $result = array("code"=>"200","msg"=>"注册成功");
                    exit(json_encode($result));
                }
                else
                {
                    $result = array("code"=>"500","msg"=>"注册时出现错误，请重新注册");
                    exit(json_encode($result));
                }
            }
            else
            {
                $result = array("code"=>"500","msg"=>"该手机号已经被注册，请换一个手机号");
                exit(json_encode($result));
            }
        // }
        // else
        // {
        //     $result = array("code"=>"500","msg"=>"验证码错误，请重新输入验证码");
        //     exit(json_encode($result));
        // }
	}
}
