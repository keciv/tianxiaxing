<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */
vendor('QQ.Recorder');
vendor('QQ.URL');
vendor('QQ.ErrorCase');

// require_once("./Recorder.class.php");
// require_once("./URL.class.php");
// require_once("./ErrorCase.class.php");

class Oauth{

    const VERSION = "2.0";
    const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";
    const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
    const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";

    protected $recorder;
    public $urlUtils;
    protected $error;
    

    function __construct(){
        $this->recorder = new Recorder();
        $this->urlUtils = new URL();
        $this->error = new ErrorCase();
    }

    public function qq_login(){
        $appid = $this->recorder->readInc("appid");
        $callback = $this->recorder->readInc("callback");
        $scope = $this->recorder->readInc("scope");

        //-------生成唯一随机串防CSRF攻击
        $state = md5(uniqid(rand(), TRUE));
        $this->recorder->write('state',$state);

        // print_r($state);
        // $state = $this->recorder->read("state");
        // print_r("__");
        // print_r($state);
        // exit();
        //-------构造请求参数列表
        $keysArr = array(
            "response_type" => "code",
            "client_id" => $appid,
            "redirect_uri" => $callback,
            "state" => $state,
            "scope" => $scope
        );
        $login_url =  $this->urlUtils->combineURL(self::GET_AUTH_CODE_URL, $keysArr);

        header("Location:$login_url");
    }

    public function qq_callback(){
        $state = $this->recorder->read("state");
        //--------验证state防止CSRF攻击
        if($_GET['state'] != $state){
            $this->error->showError("30001");
        }
        // print_r("state相等");
        // print_r("___");
        //-------请求参数列表
        $keysArr = array(
            "grant_type" => "authorization_code",
            "client_id" => $this->recorder->readInc("appid"),
            "redirect_uri" => urlencode($this->recorder->readInc("callback")),
            "client_secret" => $this->recorder->readInc("appkey"),
            "code" => $_GET['code']
        );
        // print_r("keysArr：".$keysArr);
        // print_r("___");
        //------构造请求access_token的url
        $token_url = $this->urlUtils->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);
        // print_r("token_url：".$token_url);
        // print_r("___");
        $response = $this->urlUtils->get_contents($token_url);
        // print_r("response：".$response);
        // print_r("___");
        
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);

            if(isset($msg->error)){
                $this->error->showError($msg->error, $msg->error_description);
            }
        }

        $params = array();
        parse_str($response, $params);
        //print_r($params["access_token"]);
        $this->recorder->write("access_token", $params["access_token"]);
        return $params["access_token"];

    }

    public function get_openid(){

        //-------请求参数列表
        $keysArr = array(
            "access_token" => $this->recorder->read("access_token")
        );

        $graph_url = $this->urlUtils->combineURL(self::GET_OPENID_URL, $keysArr);
        $response = $this->urlUtils->get_contents($graph_url);

        //--------检测错误是否发生
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
        }

        $user = json_decode($response);
        if(isset($user->error)){
            $this->error->showError($user->error, $user->error_description);
        }

        //------记录openid
        $this->recorder->write("openid", $user->openid);
        return $user->openid;

    }
}
