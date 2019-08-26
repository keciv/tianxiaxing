<?php 
namespace APP\Controller;
class WinxinsqController extends BaseController {
	public function winxinsq(){
		// header('content-type:text/html;charset=utf-8');
		header("Access-Control-Allow-Origin: *");
		$code = $_GET['code'];
		if(empty($code))
		{
			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx04d466c65f8d7434&redirect_uri=http%3a%2f%2fshop.rjsjzx.com%2fapp.php%2fWinxinsq%2fwinxinsq&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
			// file_get_contents($url);
			// echo "<script>window.location.href='".$url."';</script>";
			// header("Location: $url");
			echo "window.location.href='".$url."';";
		}
		else
		{
			// include("config.php");
			$code = $_GET['code'];
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx04d466c65f8d7434&secret=7764208c9d504e0b8755818ccd8bfd6e&code=$code&grant_type=authorization_code";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_URL, $url);
			$get_access_token = curl_exec($ch);

			curl_close($ch);
			$array_token = json_decode($get_access_token,true);
			if(array_key_exists("access_token",$array_token))
			{
			    // https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
			    $access_token = $array_token['access_token'];
			    $openid = $array_token['openid'];
				$cookie_member = $_COOKIE["member_id"];
			    M('member')->where("id=$cookie_member")->setField('openid',$openid);
			    if($openid){
				    echo "<script>window.location.href='http://shop.rjsjzx.com';</script>";
				    exit();
			    }else{
			    	echo "网络错误,稍后再试";
				    exit();
			    }
			    // $this->display("app.php/index.php");
			    // echo $openid;die;
			    // return 1;

			    // $_SESSION['access_token'] = $access_token;
			    // $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
			    // $ch = curl_init();
			    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			    // curl_setopt($ch, CURLOPT_URL, $url);
			    // $get_user_weixin = curl_exec($ch);

			    // curl_close($ch);
			    // $array_user = json_decode($get_user_weixin,true);

			    // if(!array_key_exists("errcode",$array_user))
			    // {
			    //     $nickname = $array_user['nickname'];
			    //     $headimgurl = $array_user['headimgurl'];
			    //     $province = $array_user['province'];
			    //     $unionid = $array_user['unionid'];
			    //     //判断此微信是否注册 唯一标识符openid 
			    //     $openid = $array_user['openid'];
			    //     $sql1 = 'SELECT * FROM sd_user where openid="'.$openid.'" order by uid asc limit 1';
			    //     $querys1 = mysql_query($sql1);
			    //     if($querys1 && mysql_num_rows($querys1) > 0){
			    //         while($info = mysql_fetch_assoc($querys1)){
			    //             // setcookie("uid",$info['uid'],time()+3600*24*7);
			    //             $_SESSION['uid'] = $info['uid'];
			    //             // $access_token = $_SESSION['access_token'];
			    //             // echo "<script>alert(111);</script>";
			    //             // echo "<script>alert($access_token);</script>";
			    //         }
			    //     }else{
			    //         $data['wxname'] = $nickname;
			    //         $data['openid'] = $openid;
			    //         $data['avatar'] = $headimgurl;
			    //         $data['address'] = $province;
			    //         foreach($data as $key =>$value){
			    //             $datakey[] = $key;
			    //             $datavalue[] = $value;
			    //         }
			    //         $datakey1 = implode(',',$datakey);
			    //         $datavalue1 = implode('","',$datavalue);
			    //         $sql2 = "INSERT INTO sd_user ($datakey1) VALUES (\"$datavalue1\")";
			    //         $querys2 = mysql_query($sql2);
			    //         if($querys2){
			    //         	$sql3 = 'SELECT * FROM sd_user order by uid desc limit 1';
			    //     		$querys3 = mysql_query($sql3);
			    //     		if($querys3 && mysql_num_rows($querys3) > 0){
			    //         		while($infos = mysql_fetch_assoc($querys3)){
			    //         			// setcookie('uid',$infos['uid'],time()+3600*24*7);
					  //               $_SESSION['uid'] = $infos['uid'];
					  //               // $uid = $_SESSION['uid'];
					  //               // echo "<script>alert(222);</script>";
					  //               // echo "<script>alert($uid);</script>";
			    //         		}
			    //         	}
			    //         }
			    //     }
			    // }
			    // else
			    // {
			    //     // $this->display("Login/index");
			    //     echo "<script>layer.msg('登陆出错，请重新登陆');</script>";
			    // }
			}
			else
			{
			    // $this->display("Login/index");
			    echo "<script>layer.msg('登陆出错，请重新登陆');</script>";
			}
		}
		// $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxa64961dddeaa815e&redirect_uri=http%3a%2f%2fwww.tyjpkj.com%2fphone_mall.php%2fLogin%2fweixin_callback&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";

		// header("Location: $url");
// redirect($url,true);
	}
}


?>