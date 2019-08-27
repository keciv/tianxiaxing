<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>注册</title>
	<link rel="stylesheet" type="text/css" href="/public/phone/css/lpk.css" />
	<link rel="stylesheet" type="text/css" href="/public/phone/lb/css/bootstrap.css" />
	<link rel="stylesheet" href="/public/phone/layer/layui.css">
	<link rel="stylesheet" type="text/css" href="/public/phone/css/reset.css" />
	<script src="/public/phone/js/jquery-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/public/phone/lb/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/public/phone/layer/layer.js"></script>
	<script src="/public/phone/js/rem.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$(function(){
			//判断什么浏览器打开的
		//	var ua = navigator.userAgent.toLowerCase();
		  //  if(ua.match(/MicroMessenger/i)=="micromessenger") {
		        //微信浏览器，提示用其他浏览器打开
		        // alert("微信打开的");
		   //     $(".box").show();
		  //  	$(".modal-backdrop").show();
		  //  } 
		  //  else
		   // {
		    	$('.lpk_mportant').show();
		    	$('.lpk_yy').show();
		   // }
		  
		})
	</script>
	<style>
		.box{width:100%;  position:fixed;top:30px;z-index:1001;display: none}
		.box img{width: 100%;}
		.modal-backdrop{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1000;background-color:#000000;opacity:0.7;filter:alpha(opacity=70); overflow:hidden;display:none;}
	</style>
</head>

<body>
	<div class="zgc">
	   	<div class="box">
	        <img src="/public/phone/img/fenxt.png">
	    </div>
		<div class="modal-backdrop"></div>
	</div>
	<div class="lpk_mportant" style="display: none;">
		<h3>手机注册</h3>
		<form action="" method="">
			<div class="top">
				<input type="tel" name="" id="nickname" value="" placeholder="昵称" />
			</div>
			<div class="top">
				<input type="tel" name="" id="phone" value="" placeholder="手机号码" maxlength="11" />
			</div>

			<div class="top">
				<input type="password" name="" id="password" value="" placeholder="登录密码" />
			</div>
			<div class="top">
				<input type="password" name="" id="passwordRepeat" value="" placeholder="确认密码" />
			</div>
			<div class="top">
				<input type="text" name="" id="inviter" value="<?php echo ($member["phone"]); ?>" placeholder="邀请人" />
			</div>
			<div class="bottom">
				<input type="button" name="zc" id="zc" value="注册" />
			</div>
		</form>
	</div>
	<style type="text/css">
		.lpk_yy{
			position: relative;
		}
		.lpk_yy span{
			position: absolute;
			left: 0.4rem;
			color: #0ac038;
		}
		.layui-layer-btn0{
			border-color: #0ac038 !important;
   			background-color: #0ac038 !important;
		}
		.protocolMain{
			width: 90%;
			margin: auto;
		}
		.protocolMain p{
			font-size: 0.4rem;
			line-height: 0.8rem;
			text-indent: 0.8rem;
		}
	</style>
	<p class="lpk_yy" style="display: none;">已有账号？
		<a href="../Login/index.html">登陆</a>
		
		<span class="" onclick="protocol();">请阅读协议</span>
	</p>
	
	<div class="protocolMain" style="display: none;">
		<p>454600</p>
		<p>454600</p>
		<p>454600</p>
	</div>
	
	
</body>
<script type="text/javascript">
	
	function protocol() {
		layer.open({
			type:1,
			area: ['80%', "60%"],
			title: "协议",
			closeBtn: 1,
			shadeClose: false,
			shade: 0.7,
			scrollbar: false,
			content: $('.protocolMain'),
			end: function() {
	
			}	
		});
	};
	
	
	
	var bt01 = document.getElementById("btn");
	$('.lpk_mportant').on('click', '#btn', function() {
		if($(this).data("flag") === true) {
			let phone = $("#phone").val();
			if(!phone) {
				console.log(0)
			} else {
				$.ajax({
					type: 'get',
					url: '/app.php/MobileCode/send',
					dataType: 'json',
					data: {
						phone: phone
					},
					success: function(data) {
						console.log(data);
						alert(data.data);
						var time = 60;
						var timer = setInterval(function() {
							time--;
							if(time >= 0) {
								$('#btn').data("flag", false)
								$('#btn').val(time + "s后重新发送")
							} else {
								$('#btn').data("flag", true)
								$('#btn').val("重新发送验证码");
								clearTimeout(timer); //清除定时器 
								time = 6; //设置循环重新开始条件 
							}
						}, 1000);
					}
				});

			}
		}

	})

	$('#zc').on('click', function() {
		var nickname = $("#nickname").val();
		var phone = $("#phone").val();
		var code = $("#code").val();
		var password = $("#password").val();
		var passwordRepeat = $("#passwordRepeat").val();
		var inviter = $("#inviter").val();
		if(!$("#nickname").val()) {
			layer.open({
				content: '请输入您的昵称',
				skin: 'msg',
				time: 3000
			});
			return false;
		}
		if(!$("#phone").val()) {
			layer.open({
				content: '请输入您的手机号',
				skin: 'msg',
				time: 3000
			});
			return false;
		}
		if(!$("#password").val()) {
			layer.open({
				content: '请输入您的密码',
				skin: 'msg',
				time: 3000
			});
			return false;
		} 
		if(!$("#passwordRepeat").val()) {
			layer.open({
				content: '请输入确认密码',
				skin: 'msg',
				time: 3000
			});
			return false;
		} 
		if($("#password").val() != $("#passwordRepeat").val()) {
			layer.open({
				content: '两次密码输入不一致',
				skin: 'msg',
				time: 3000
			});
			return false;
		} 
		// if(!$("#inviter").val()) {
		// 	layer.open({
		// 		content: '请输入邀请人',
		// 		skin: 'msg',
		// 		time: 3000
		// 	});
		// 	return false;
		// }

		$.ajax({
			type: "post",
			url: "/app.php/Register/register",
			dataType: 'json',
			data: {
				nickname: nickname,
				phone: phone,
				code: code,
				password: password,
				passwordRepeat: passwordRepeat,
				inviter: inviter,
			},
			success: function(data) {
				console.log(data)
				if(data.code == '200') {
					layer.msg("注册成功", {
						time: 2000
					}, function() {
						window.location.href = "/login.html";
					})
				} else {
					layer.msg(data.msg);
				}
			}

		});

	})
</script>

</html>