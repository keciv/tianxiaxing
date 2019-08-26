<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>优惠券</title>
		<link rel="stylesheet" type="text/css" href="/public/phone/css1/public.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/layer/mobile/need/layer.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/css1/more.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/css1/style.css" />
		<script src="/public/phone/js/jquery-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/layer/layer.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/js1/iscroll.js" type="text/javascript" charset="utf-8"></script>
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
				优惠券
			</div>
			<div class="right">
			</div>
		</header>
		<div class="indexHeadBg"></div>
		<div class="lpkCoupon">
			<p class="active" data-lpk='lpk'>未使用</p>
			<p data-lpk='lpk1'>已使用</p>
			<p data-lpk='lpk2'>已过期</p>
		</div>

		<div id="wrapper" style="display: block;top: 9.2rem;" class="lpkwrapper" data-flag="true">
			<div id="scroller">
				<section class="lpkCouponMain">

				</section>
				<div class="lpk">
					上拉加载
				</div>
			</div>
		</div>
		<div id="wrapper1" class="lpkwrapper" style="top: 9.2rem" data-flag="true">
			<div id="scroller1">
				<section class="lpkCouponMain">

				</section>
				<div class="lpk1">
					上拉加载
				</div>
			</div>
		</div>
		<div id="wrapper2" class="lpkwrapper" style="top: 9.2rem" data-flag="true">
			<div id="scroller2">
				<section class="lpkCouponMain">

				</section>
				<div class="lpk2">
					上拉加载
				</div>
			</div>
		</div>

	</body>
	<script type="text/javascript">
		$(function() {
			pullOnLoad();
			$('.lpkCoupon p').click(function() {
				$(this).addClass('active').siblings().removeClass();
				var index = $('.lpkCoupon p').index(this);
				$('.lpkwrapper').eq(index).show().siblings('.lpkwrapper').hide();
				var status = $(this).attr('data-lpk');
				if(status == 'lpk') {
					$(this).attr('data-lpk', 'status');
				} else if(status == 'lpk1') {
					pullOnLoad1();
					$(this).attr('data-lpk', 'status');
				} else if(status == 'lpk2') {
					pullOnLoad2();
					$(this).attr('data-lpk', 'status');
				}
			})

		})

		//		未使用
		var myscroll = new iScroll("wrapper", {
			onScrollMove: function() {
				if(this.y < 0) {
					$(".lpk").addClass("loading");
				}
			},
			onScrollEnd: function() {
				if($(".lpk").hasClass('loading')) {
					$(".lpk").html("加载中...");
					pullOnLoad();
				}
			},
			onRefresh: function() {
				$('.lpk').html("上拉加载");
			}
		});
		var num = 3;
		var page = 1;

		function pullOnLoad() {
			if($('#wrapper').data('flag') === false) {
				return
			}
			$('#wrapper').data('flag', false)
			setTimeout(function() {
				$.ajax({
					url: '/app.php/Coupon/get_data',
					type: "get",
					dataType: 'json',
					data: {
						CurrentPage: page,
						paginalNum: num,
						is_use:0
					},
					success: function(data) {
						if(data.code !== 200) {
							console.log(data)
							var dataArr = data.data;
							var result = "";
							if(dataArr.length > 0) {
								for(var i = 0; i < dataArr.length; i++) {
									var row = data.data[i];
									result += `
										<div class="item">
											<div class="left">
												<h3>￥<span>${row.coupon_price}</span></h3>
												<h4>${row.coupon_where}</h4>
											</div>
											<div class="right">
												<h3>${row.coupon}优惠券</h3>
											   <div class="">
											   	  <p class="L">
											   	  	<span>有效期</span>
											   	  	<span>${row.coupon_time}</span>
											   	  </p>
											   	  <p class="R">
											   	  	<a>立即使用</a>
											   	  </p>
											   </div>
											</div>
										</div>
											    `
								}
								 $("#scroller section").append(result);
								page++;
								myscroll.refresh();
							} else {
								$(".lpk").text("没有了");
							}
						} else {
							layer.msg(data.msg)
						}
						$('#wrapper').data('flag', true)
					},
					error: function() {
						console.log("出错了");
					}
				});
				myscroll.refresh();
			}, 1000);
		}

		//		已使用

		var Transaction1 = new iScroll("wrapper1", {
			onScrollMove: function() {
				if(this.y < 0) {
					$(".lpk1").addClass("loading");
				}
			},
			onScrollEnd: function() {
				if($(".lpk1").hasClass('loading')) {
					$(".lpk1").html("加载中...");
					pullOnLoad1();
				}
			},
			onRefresh: function() {
				$('.lpk1').html("上拉加载");
			}
		});
		var num1 = 3;
		var page1 = 1;

		function pullOnLoad1() {
			if($('#wrapper1').data('flag') === false) {
				return
			}
			$('#wrapper1').data('flag', false)
			setTimeout(function() {
				$.ajax({
					url: '/app.php/Coupon/get_data',
					type: "get",
					dataType: 'json',
					data: {
						CurrentPage: page1,
						paginalNum: num1,
						is_use:1
					},
					success: function(data) {
						if(data.code !== 200) {
							console.log(data)
							var dataArr = data.data;
							var result = "";
							if(dataArr.length > 0) {
								for(var i = 0; i < dataArr.length; i++) {
									var row = data.data[i];
									result += `
								      <div class="item">
											<div class="left">
												<h3>￥<span>${row.coupon_price}</span></h3>
												<h4>${row.coupon_where}</h4>
											</div>
											<div class="right">
												<h3>${row.coupon}</h3>
											   <div class="">
											   	  <p class="L">
											   	  	<span>有效期</span>
											   	  	<span>${row.coupon_time}</span>
											   	  </p>
											   	  <p class="R">
											   	  	<a>已使用</a>
											   	  </p>
											   </div>
											</div>
										</div>
								     `
								}
								$("#scroller1 section").append(result);
								page1++;
								Transaction1.refresh();
							} else {
								$(".lpk1").text("没有了");
							}
						} else {
							layer.msg(data.msg)
						}
						$('#wrapper1').data('flag', true)
					},
					error: function() {
						console.log("出错了");
					}
				});
				Transaction1.refresh();
			}, 1000);
		}
		//		已过期
		var Transaction2 = new iScroll("wrapper2", {
			onScrollMove: function() {
				if(this.y < 0) {
					$(".lpk2").addClass("loading");
				}
			},
			onScrollEnd: function() {
				if($(".lpk2").hasClass('loading')) {
					$(".lpk2").html("加载中...");
					pullOnLoad2();
				}
			},
			onRefresh: function() {
				$('.lpk2').html("上拉加载");
			}
		});
		var num2 = 3;
		var page2 = 1;

		function pullOnLoad2() {
			if($('#wrapper2').data('flag') === false) {
				return
			}
			$('#wrapper2').data('flag', false)
			setTimeout(function() {
				$.ajax({
					url: '/app.php/Coupon/get_data',
					type: "get",
					dataType: 'json',
					data: {
						CurrentPage: page2,
						paginalNum: num2,
						is_use:3,
					},
					success: function(data) {
						if(data.code !== 200) {
							console.log(data)
							var dataArr = data.data;
							var result = "";
							if(dataArr.length > 0) {
								for(var i = 0; i < dataArr.length; i++) {
									var row = data.data[i];
									result += `
								     <div class="item">
											<div class="left">
												<h3>￥<span>${row.coupon_price}</span></h3>
												<h4>${row.coupon_where}</h4>
											</div>
											<div class="right">
												<h3>${row.coupon}</h3>
											   <div class="">
											   	  <p class="L">
											   	  	<span>有效期</span>
											   	  	<span>${row.coupon_time}</span>
											   	  </p>
											   	  <p class="R">
											   	  	<a>已过期</a>
											   	  </p>
											   </div>
											</div>
										</div>
										  `
								}
								$("#scroller2 section").append(result);
								page2++;
								Transaction2.refresh();
							} else {
								$(".lpk2").text("没有了");
							}
						} else {
							layer.msg(data.msg)
						}
						$('#wrapper2').data('flag', true)
					},
					error: function() {
						console.log("出错了");
					}
				});
				Transaction2.refresh();
			}, 1000);
		}
	</script>

</html>