<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>签到状态</title>
		<link rel="stylesheet" type="text/css" href="/public/phone/css1/public.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/layer/mobile/need/layer.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/css1/style.css" />
		<script src="/public/phone/js/jquery-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/layer/layer.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/js1/rem.js" type="text/javascript" charset="utf-8"></script>
	</head>

	<body>
		<header class="indexHead">
			<div class="left">
				<a onclick="javascript:history.back(-1);">
					<img src="/public/phone/img1/indexgo.png" />
				</a>
			</div>
			<div class="center">
				签到状态
			</div>
			<div class="right">
			</div>
		</header>
		<div class="indexHeadBg"></div>
		<section class="lpkCheck">
			<div class="lpkCheckMain">
				<font>已坚持 </font>
				
				<span><?php echo ($sign_count3); ?></span>
				<span><?php echo ($sign_count2); ?></span>
				<span><?php echo ($sign_count1); ?></span>
				
				<font> 天签到</font>
			<p style="font-size: 2.22rem;"><?php echo ($a); ?></p>
			<p style="font-size: 2.22rem;"><?php echo ($b); ?></p>
			</div>
			<div class="lpkCheckB">
				<h3>上传<span> 工作凭证 </span>可继续签到</h3>
				<h4>连续累计签到可领取满减优惠券</h4>
				<div class="lpkjdt">
					<div class="lpkbg">
						<p data-width='<?php echo ($sign_count); ?>'></p>
						<font class="font1" id="first"><img src="/public/phone/img1/gift.png" /></font>
						<font class="font2" id="second"><img src="/public/phone/img1/gift.png" /></font>
						<font class="font3" id="third"><img src="/public/phone/img1/gift.png" /></font>
						<font class="font4" id="fourth"><img src="/public/phone/img1/gift.png" /></font>
					</div>
					<div class="lpkjdtTop">
						<span class="sapn1 <?php if($first >= 7 ): ?>active<?php endif; ?>" >优惠券</span>
						<span class="sapn2 <?php if($first >= 14 ): ?>active<?php endif; ?>" >优惠券</span>
						<span class="sapn3 <?php if($first >= 21 ): ?>active<?php endif; ?>" >优惠券</span>
						<span class="sapn4 <?php if($first >= 28 ): ?>active<?php endif; ?>" >优惠券</span>
					</div>
					<div class="lpkjdtBtoom">
						<span class="sapn">1天</span>
						<span class="sapn1">7天</span>
						<span class="sapn2">14天</span>
						<span class="sapn3">21天</span>
						<span class="sapn4">28天</span>
					</div>

				</div>
			</div>
		</section>

		<section class="lpklwbg">
			<div class="">
				<img src="/public/phone/img1/lwbg.png" />
				<h3 class="top">已签到<font id="coupon_sign"><?php echo ($sign_count); ?></font>天 </h3>
				<h3 class="top1">获得一张优惠券 </h3>
				<h4 id="coupon">立即领取</h4>
				<div class="posi clearfix">
					<div class="fl left">
						<h3>￥<span id="coupon_price">10</span></h3>
						<h4 id="coupon_where">满133元可用</h4>
					</div>
					<div class="fr right">
						<h3 id="coupon_content">优惠券标题内容优惠券标题内优惠券</h3>
						<p class="t">有效期</p>
						<p id="coupon_time">2019.02.21-2019.03.21</p>

					</div>
				</div>
				<div class="del">
					<img src="/public/phone/img1/del.png" />
				</div>

			</div>
			
		</section>

	</body>
	<script type="text/javascript">

	
			
		
		
		window.onload = function() {
			var width = $('.lpkCheck .lpkCheckB .lpkjdt .lpkbg p').attr('data-width');
			var w = width * (25 / 7);
			if(width >= 28) {
				$('.lpkCheck .lpkCheckB .lpkjdt .lpkbg p').css('width', 100 + '%');
			} else {
				$('.lpkCheck .lpkCheckB .lpkjdt .lpkbg p').css('width', w + '%');
			}
			
			if(w >= 25) {
				$('.lpkCheck .lpkCheckB .lpkjdt .lpkbg  .font1').show();
				$('.lpkCheck .lpkjdtTop .sapn1').text('可领取')
			}
			if(w >= 50) {
				$('.lpkCheck .lpkCheckB .lpkjdt .lpkbg  .font2').show();
				$('.lpkCheck .lpkjdtTop .sapn2').text('可领取')
			}
			if(w >= 75) {
				$('.lpkCheck .lpkCheckB .lpkjdt .lpkbg  .font3').show();
				$('.lpkCheck .lpkjdtTop .sapn3').text('可领取')
			}
			if(w >= 100) {
				$('.lpkCheck .lpkCheckB .lpkjdt .lpkbg  .font4').show();
				$('.lpkCheck .lpkjdtTop .sapn4').text('可领取')
			}
			var num;
			$('.lpkCheck .lpkbg font').on('click', function() {
				num = $('.lpkCheck .lpkbg font').index(this);
				$('.lpklwbg').show();
			})
			$('.lpklwbg > div > h4').on('click', function() {
				layer.msg("领取成功", {
					time: 1000
				}, function() {
					$('.lpkCheck .lpkjdtTop span').eq(num).addClass('active');
					$('.lpkCheck .lpkjdtTop span').text('已领取');
					$('.lpkCheck .lpkjdt .lpkbg font').eq(num).hide();
					$('.lpklwbg').hide();
				})
			})

			$('.lpklwbg > div .del').click(function() {
				$('.lpklwbg').hide();
			})

			//			if(w == 25) {
			//				$('.lpkCheck .lpkjdtTop .sapn1').text('可领取')
			//			} else if(w == 50) {
			//				$('.lpkCheck .lpkjdtTop .sapn2').text('可领取')
			//			} else if(w == 70) {
			//				$('.lpkCheck .lpkjdtTop .sapn3').text('可领取')
			//			} else if(w == 100) {
			//				$('.lpkCheck .lpkjdtTop .sapn4').text('可领取')
			//			}
			//
			//			if(w > 25) {
			//				$('.lpkCheck .lpkjdtTop .sapn1').addClass('active')
			//				$('.lpkCheck .lpkjdtTop .sapn1').text('已领取')
			//			}
			//			if(w > 50) {
			//				$('.lpkCheck .lpkjdtTop .sapn2').addClass('active')
			//				$('.lpkCheck .lpkjdtTop .sapn2').text('已领取')
			//			}
			//			if(w > 75) {
			//				$('.lpkCheck .lpkjdtTop .sapn3').addClass('active')
			//				$('.lpkCheck .lpkjdtTop .sapn3').text('已领取')
			//			}
			//			if(w > 100) {
			//				$('.lpkCheck .lpkjdtTop .sapn4').addClass('active')
			//				$('.lpkCheck .lpkjdtTop .sapn4').text('已领取')
			//			}

		}
//		$('.lpkCheck .lpkbg font').on('click', function() {
//			console.log(555)
//				$.ajax({
//				type:"post",
//				url:"<?php echo U('sign/sign_in');?>",
//				async:true,
//				dataType:"json",
//				data:{data:2},
//				success:function(data){
//					console.log(data);
//				}
//			});
//		})
	
			$("#coupon").click(function(){
				var coupon_price =$("#coupon_price").text();
				var coupon_sign =$("#coupon_sign").text();
				var coupon_where =$("#coupon_where").text();
				var coupon_time = $("#coupon_time").text();
				var coupon_content = $("#coupon_content").text();
				$.ajax({
				type:"post",
				url:'/app.php/Coupon/add',
				async:true,
				dataType:"json",
				data:{"coupon_price":coupon_price,
				      "coupon_where":coupon_where,
					  "coupon_time":coupon_time,
					  "coupon_sign":coupon_sign,
					  "coupon":coupon_content,
				},
				success:function(data){
					console.log(data);
				}
			})
	
		})
//		window.onload = function() {
//			
//		}
			if(<?php echo ($first); ?> >= 7){
				$("#first img").css("display","none");
				$('.span1').html('已领取');
			} 
			if( <?php echo ($first); ?> >= 14){
				$("#second img").css("display","none");
				$('.span2').text('已领取');
			}
			if( <?php echo ($first); ?> >= 21){
				$("#third img").css("display","none");
				$('.span3').text('已领取');
			}
			if(<?php echo ($first); ?> >= 28){
				$("#fourth img").css("display","none");
				$('.span4').text('已领取');
			}
	</script>

</html>