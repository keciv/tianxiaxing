<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>分享二维码</title>
		<link rel="stylesheet" type="text/css" href="/public/phone/lb/css/bootstrap.css" />
		<link rel="stylesheet" href="/public/phone/layer/layui.css">
		<link rel="stylesheet" type="text/css" href="/public/phone/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/css/public.css" />
		<script src="/public/phone/js/rem.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body style="background: #f9f9f9;">
		<header class="lpk_head clearfix">
			<div class="fl left">
				<a href="/MyCenter.html">
					<font class="glyphicon glyphicon-menu-left"></font>
				</a>
			</div>
			<div class="fl center">
				分享二维码
			</div>
			<div class="fr right">
				<a href="javascript:;">
				</a>
			</div>
		</header>
		
		<!--<div class="share-bg">
			<img src="img/share-bot-bg.png" />
		</div>-->
		
		<div class="lpkEwm">
			<div class="headT clearfix">
				<p class="fl"><img src="" class="headportrait"/></p>
				                                                           <!--male  男       female   女 -->
				<span class="fl nickname"></span>
				 <!--<font class="glyphicon glyphicon-user female"></font>-->
			</div>
			<p><img src="" class="qrcode"/></p>
			<h4>保存二维码分享给朋友</h4>
		</div>
		<script src="/public/phone/js/jquery-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/lb/js/bootstrap.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/layer/layer.js"></script>
		<script type="text/javascript">
			$(function(){
				var member_id = "<?php echo ($member_id); ?>";
				$.ajax({
					type:"get",
					url:"app.php/MemberInfo/get_qrcode",
					dataType:'json',
					data:{
						member_id:member_id,
					},
					success:function(data){
						console.log(data)
						$('.headportrait').attr('src',data.data.headportrait);
						$('.nickname').text(data.data.nickname);
						$('.qrcode').attr('src',data.data.qrcode);
					}
				});
			})
		</script>
	</body>
</html>