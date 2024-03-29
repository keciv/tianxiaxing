<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>个人中心</title>
		<link rel="stylesheet" type="text/css" href="/public/phone/css/lpk.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/lb/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/css/public.css" />
		<link rel="stylesheet" href="/public/phone/layer/layui.css">
		<script src="/public/phone/js/rem.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/js/jquery-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/lb/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/layer/layer.js"></script>

		<script type="text/javascript">
			$(function() {
				var member_id = "<?php echo ($member["id"]); ?>";
				$.ajax({
					type: 'get',
					url: '/app.php/MyCenter/getData',
					dataType: 'json',
					data: {
						member_id: member_id
					},
					success: function(data) {
						console.log(data.data)
						if(data.code == "200") {
							var img = data.data.member.headportrait;
							$('.HeadPortrait figure img').attr('src', img);
							// $('.HeadPortrait .figcaption').text(data.data.member.nickname);
							$('.daifukuan').text(data.data.order.daifukuan)
							$('.daifahuo').text(data.data.order.daifahuo)
							$('.daishouhuo').text(data.data.order.daishouhuo)
							$('.daipingjia').text(data.data.order.daipingjia)
						} else if(data.code == "404") {
							layer.msg(data.msg, {
								time: 2000
							}, function() {
								window.location.href = "/login.html";
							});
						} else {
							layer.msg(data.msg);
						}
					}
				})
			})
		</script>

		<style type="text/css">
			.figcaption1 {
				margin-top: 8px;
			}
			
			.figcaption1 a {
				display: inline-block;
				font-size: 0.4rem;
				color: #0ac038;
				background: #fff;
				padding: 2px 5px;
				border-radius: 5px;
			}
			
			.figcaption1 a:hover {
				color: #0ac038 !important;
			}
		</style>

	</head>

	<body>
		<header class="lpk_head clearfix">
			<div class="fl left">
			</div>
			<div class="fl center">
				个人中心
			</div>
			<div class="fr right">
			</div>
		</header>
		<div class="" style="width: 100%;height: 1.5rem;">

		</div>
		<div class="HeadPortrait">
			<figure><img src="" /><input id="" type="file" style="display: none;"></figure>
			<figcaption class="figcaption"><?php echo ($member["phone"]); ?></figcaption>

		</div>
		
		<div class="lpk_info2">
			<div class="top clearfix">
				<a href="Order.html?id=0">
					<p class="fl left">我的订单</p>
					<p class="fr right">
						<font class="glyphicon glyphicon-menu-right"></font>
					</p>
				</a>
			</div>
			<div class="bot">
				<ul class="clearfix">
					<li>
						<a href="Order.html?id=0">
							<figure><img src="/public/phone/img/dan1.png" />
								<span class="daifukuan"></span>
							</figure>
							<figcaption>待付款</figcaption>
						</a>
					</li>
					<li>
						<a href="Order.html?id=1">
							<figure><img src="/public/phone/img/dan2.png" />
								<span class="daifahuo"></span>
							</figure>
							<figcaption>待备货</figcaption>
						</a>
					</li>
					<li>
						<a href="Order.html?id=2">
							<figure><img src="/public/phone/img/dan3.png" />
								<span class="daishouhuo"></span>
							</figure>
							<figcaption>待收货</figcaption>
						</a>
					</li>
					<li>
						<a href="Order.html?id=3">
							<figure><img src="/public/phone/img/dan4.png" />
								<span class="daipingjia"></span>
							</figure>
							<figcaption>已完成</figcaption>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="lpk_info3">
			<ul>
				<li>
					<a href="/MemberInfo.html" class="clearfix"><span class="fl">个人资料</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>
				<li>
					<a href="/Address.html?id=0" class="clearfix"><span class="fl">地址管理</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>
				<li>
					<a href="/Work/index.html" class="clearfix"><span class="fl">工作</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>
				<li>
					<a href="/MyCommission.html" class="clearfix"><span class="fl">佣金</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>
				<li>
					<a href="/Sign.html" class="clearfix"><span class="fl">签到状态</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>
				<li>
					<a href="/Coupon.html" class="clearfix"><span class="fl">优惠券</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>
				<li>
					<a href="/MyQrCode.html" class="clearfix"><span class="fl">邀请好友</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>
				
				<!--<li>
					<a href="/VideoList_3.html" class="clearfix"><span class="fl">名师讲堂</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>-->

				<!--<li>-->
					<!-- /MyRecommend.html -->
					<!--<a onclick="input_password(1)" class="clearfix"><span class="fl">我的团队</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>-->
				<!--<li>
					<a href="/MyCommission.html"  class="clearfix"><span class="fl">我的收益</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>-->
				<!--<li>
					<a href="/MyIntegral.html" class="clearfix"><span class="fl">我的积分</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>-->
				<!--<li>
					<a href="/Leaderboard.html" class="clearfix"><span class="fl">排行榜</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>-->

				<!--<li>
					<a href="/MyCollection.html" class="clearfix"><span class="fl">我的收藏</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>-->
				<!--<li>
					<a href="/PwdEditPay.html" class="clearfix"><span class="fl">二级密码</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>
				<li>
					<a href="/VideoList_1.html" class="clearfix"><span class="fl">产品示范</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>
				<li>
					<a href="/PictureList_2.html" class="clearfix"><span class="fl">市场精英</span><span class="fr glyphicon glyphicon-menu-right"></span></a>
				</li>-->
				
			</ul>
		</div>

		<footer class="lpk_foot">
	<ul class="clearfix">
		<li>
			<a href="/index.html"><img src="/public/phone/img/foot11.png" /></a>
		</li>
		<!--<li>
			<a href="/ProductSort.html"><img src="/public/phone/img/foot4.png" /></a>
		</li>-->
		<!--<li>
			<a href="/Package.html"><img src="/public/phone/img/foot5.png" /></a>
		</li>-->
		<li>
			<a href="/ShoppingCart.html"><img src="/public/phone/img/foot2.png" /></a>
		</li>
		
		
		<!--<li>
			<a href="/MyCenter.html"><img src="/public/phone/img/foot3.png" /></a>
		</li>-->
		
		<li>
			<a href="/Order.html"><img src="/public/phone/img/foot2.png" /></a>
		</li>
	</ul>
</footer>
<script src="/public/phone/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$('.lpk_foot ul li').eq(1).click(function() {
		localStorage.clear();
	})
</script>

		<div class="lpk_foot_bg"></div>
		<style type="text/css">
			.myteam {
				width: 90%;
				margin: auto;
				;
				display: none;
			}
			
			.myteam div {
				display: flex;
				justify-content: flex-start;
				margin-top: 0.5rem;
			}
			
			.myteam div p {
				font-size: 0.4rem;
			}
			
			.myteam div .t {
				width: 30%;
				line-height: 1rem;
			}
			
			.myteam div p input {
				display: block;
				width: 5rem;
				height: 1rem;
				font-size: 0.4rem;
				padding-left: 0.2rem;
			}
			
			.layui-layer-btn0 {
				background: #0ac038 !important;
				border: #0ac038 !important;
			}
		</style>

		<!-- 团队 -->
		<div class="myteam layer1">
			<div class="">
				<p class="t">二级密码</p>
				<p><input type="password" id="password" placeholder="输入密码" /></p>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		function input_password(type) {
			layer.open({
				type: 1,
				area: ['300px', '150px'],
				title: '输入密码',
				btn: ['确认', '取消'],
				closeBtn: 1,
				shadeClose: true,
				shade: 0.6,
				content: $('.layer1'),
				scrollbar: false,
				btn1: function() {
					yanzheng(type);
					layer.closeAll();
				}
			});
		}

		function yanzheng(type) {
			var password = $('#password').val();
			$.ajax({
				url: '/app.php/Password/yanzheng',
				data: {
					password: password
				},
				type: 'post',
				dataType: 'json',
				success: function(data) {
					if(data.code == "200") {
						if(type == "1") {
							window.location.href = "/MyRecommend.html";
						} else if(type == "2") {
							window.location.href = "/MyCommission.html";
						}
					} else if(data.code == "404") {
						layer.msg("您尚未设置二级密码，请前往设置", {
							time: 2000
						}, function() {
							window.location.href = "/PwdEditPay.html";
						})
					} else {
						layer.msg(data.msg);
					}
				}
			})
		}
	</script>

</html>