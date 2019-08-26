<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>天下行</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link rel="stylesheet" href="/public/phone/lb/css/bootstrap.min.css">
		<link rel="stylesheet" href="/public/phone/lb/css/swiper.min.css">
		<link rel="stylesheet" href="/public/phone/css/reset.css">
		<link rel="stylesheet" href="/public/phone/css/public.css">
		<link rel="stylesheet" href="/public/phone/css/index.css">
		<script src="/public/phone/lb/js/jquery.min.js"></script>
		<!--<link rel="stylesheet" type="text/css" href="http://at.alicdn.com/t/font_1228517_0resig0n8v7r.css"/>
		<link rel="stylesheet" type="text/css" href="http://at.alicdn.com/t/font_1279253_rhdr20j2z9.css"/>-->
		<script src="/public/phone/lb/js/bootstrap.min.js"></script>
		
		<script src="/public/phone/js/rem.js"></script>
		<link rel="stylesheet" href="/public/phone/css/style.css">
		<script src="/public/phone/js/iscroll.js"></script>
		<style type="text/css">
			.lpkSelectNav{
				width: 94%;
				margin: auto;
				padding: 0.5rem 0 0.2rem;
				display: flex;
				flex-wrap: wrap;
				justify-content: flex-start;
			}
			
			.lpkSelectNav .item{
				flex: 0 0 25%;
				margin-bottom: 0.3rem;
			}
			
			.lpkSelectNav .item a{
				display: block;
			}
			.lpkSelectNav .item a p{
				font-size: 0.4rem;
				text-align: center;
				color: #0ac038;
			}
			.lpkSelectNav .item a .top{
              background: #0ac038;
			  border-radius: 50%;
			  width: 1.2rem;
			  height: 1.2rem;
			  margin:0 auto 0.2rem;
			}
			.lpkSelectNav .item a p span{
				font-size: 0.5rem;
				color: #fff;
				display: inline-block;
				margin-top: 0.35rem;
			}
			.lpkCall{
				position: fixed;
				bottom: 3rem;
				background: rgba(0,0,0,0.7);
				color: white;
				font-size: 0.4rem;
				width: 1.5rem;
				z-index: 50;
				left: -1.5rem;
				transition: all 0.5s;
			}
			.lpkCallon{
				left: 0rem;
			}
			.lpkCall a{
				display: block;
				text-align: center;
				padding: 0.15rem 0;
			}
			.lpkCall a:hover{
				color: white;
			}
			
			.lpkCall p{
				position: absolute;
				top: 0;
				right: -0.5rem;
				width: 0.5rem;
				height: 100%;
				background: rgba(0,0,0,0.7);
				border-radius: 0 8px 8px 0;
				line-height: 1.6rem;
			}
		</style>
	</head>

	<body class="pd1307 body-bj">
		
		<header class="lpk_head clearfix">
			<div class="fl left">
			</div>
			<div class="fl center">
				商城
			</div>
			<div class="fr right">
			</div>
		</header>
		
		
		<style type="text/css">
			.lpkBox{
				width: 100%;
				min-height: 1rem;
				background: white;
				position: relative;
			}
			.lpkBox ul{
				width: 72%;
				overflow: hidden;
				 height: 1rem;
				 margin: auto;
			}
			.lpkBox ul li{
				width: 100%;
			}
			.lpkBox ul li a{
				 display: -webkit-box;
				 -webkit-box-orient: vertical;
			     -webkit-line-clamp: 1;
			     overflow: hidden;
			     font-size: 0.38rem;
			     color: #000;
			     line-height: 1rem;
			}
			.lpkBox .left{
				position: absolute;
				top: 0.08rem;
				left: 0.3rem;
			}
			.lpkBox .left span{
				color: #0ac038;
			}
			
			.lpkBox .right{
				position: absolute;
				top: 0.24rem;
				right: 0.3rem;
			}
			.lpkBox .right a{
				color: #333;
				display: block;
				border: 0.5px solid #0ac038;
				font-size: 0.3rem;
				border-radius: 0.3rem;
				padding: 0.02rem 0.2rem;
			}
			.baioti{
				width: 90%;
				margin: auto;
				font-size: 0.4rem;
				font-weight: bold;
				line-height: 1rem;
			}
			.baioti a{
				font-size: 0.35rem;
				border: 1px solid #0ac038;
				padding: 0rem 0.2rem;
				height: 0.8rem;
				line-height: 0.8rem;
			    font-weight: 400;
			    border-radius: 10px;
			}
		</style>

		<div id="wrapper" style="top: 44px;" data-flag='true'>
			<div id="scroller" class="index-prolist">
				<div class="index-banner">
					<div class="swiper-container">
						<div class="swiper-wrapper swiper-wrapper1">

						</div>
						<!-- Add Pagination -->
						<div class="swiper-pagination"></div>
					</div>
				</div>
				
				<section class="clearfix">
					
				</section>
				<div class="pull-loading">
					上拉加载
				</div>
			</div>
		</div>

		<footer class="lpk_foot">
	<ul class="clearfix">
		<li>
			<a href="/index.php"><img src="/public/phone/img/foot11.png" /></a>
		</li>
		<li>
			<a href="/ProductSort.html"><img src="/public/phone/img/foot4.png" /></a>
		</li>
		<!--<li>
			<a href="/Package.html"><img src="/public/phone/img/foot5.png" /></a>
		</li>-->
		<li>
			<a href="/ShoppingCart.html"><img src="/public/phone/img/foot2.png" /></a>
		</li>
		<li>
			<a href="/MyCenter.html"><img src="/public/phone/img/foot3.png" /></a>
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
		<script src="/public/phone/lb/js/swiper-3.4.2.jquery.min.js"></script>
		<script>
			
			$('.lpkCall p').click(function(){
				$('.lpkCall').toggleClass('lpkCallon');
			})
			$(function() {
				get_product();
				get_banner();
				get_new();
			})
			var member_type = "<?php echo ($member_type); ?>";
			var myscroll = new iScroll("wrapper", {
				onScrollMove: function() { //拉动时
					//上拉加载
					if (this.y < this.maxScrollY) {
						$(".pull-loading").html("释放加载");
						$(".pull-loading").addClass("loading");
					} else {
						$(".pull-loading").html("上拉加载");
						$(".pull-loading").removeClass("loading");
					}
				},
				onScrollEnd: function() { //拉动结束时
					//上拉加载
					if ($(".pull-loading").hasClass('loading')) {
						$(".pull-loading").html("加载中...");
						get_product();
					}
				},
				onRefresh: function() {
					$('.pull-loading').html("上拉加载");
				}
			});
			//上拉加载函数,ajax
			var num = 4;
			var page = 1; //每次加载4条
			function get_product() {
				var stu=$('#wrapper').attr('data-flag');
				if(stu==false){
					return;
				}
				$('#wrapper').attr('data-flag','false')
				setTimeout(function() {
					$.ajax({
						url: '/app.php/Index/get_product',
						type: "get",
						dataType: 'json',
						data: {
							CurrentPage: page,
							paginalNum: num,
						},
						success: function(data) {
							console.log(data)
							if (data.code == "200") {
								if (data.data.length > 0) {
									var result = "";
									for (var i = 0; i < data.data.length; i++) {
										var row = data.data[i];
										var price = "";
										if(member_type=="0")
										{
											price_type = row.youke_price.split("+");
											price_yuan = price_type[0];
											price_jifen = price_type[1];
											price = `¥${price_yuan}`;
										}
										else if(member_type=="1")
										{
											price_type = row.huiyuan_price.split("+");
											price_yuan = price_type[0];
											price_jifen = price_type[1];
											price = `¥${price_yuan}+${price_jifen}积分`;
										}
										else if(member_type=="2")
										{
											price_type = row.dianpu_price.split("+");
											price_yuan = price_type[0];
											price_jifen = price_type[1];
											price = `¥${price_yuan}+${price_jifen}积分`;
										}
										result +=
											`
											<div class="box">
												<a href="/ProductShow.html?id=${row.id}">
													<div class="img-box">
														<img class="itemImg" src="/${row.picture}" />
													</div>
													<div class="tit">
														<h3>${row.title}</h3>
														<!-- <p style='font-size:12px;font-weight:400'>原价：88 </p> -->
														<p>${price} </p>
													</div>
												</a>
											</div>`;
									}
									$("#scroller section").append(result);
									page++;
									myscroll.refresh();
								} 
								else {
									$(".pull-loading").text("没有了");
								}
								
								$('#wrapper').attr('data-flag','true')
								
							}
							else if(data.code == "400") {
								layer.msg(data.msg, {
									time: 2000
								}, function() {
									window.location.href = "/login.html";
								})
						    }
						    else {
								layer.msg(data.msg);
							}
						},
						error: function() {
							console.log("出错了");
						}
					});
					myscroll.refresh();
				}, 1000);
			}

			function get_banner() {
				$.ajax({
					url: '/app.php/Index/get_banner',
					type: "get",
					dataType: 'json',
					data: {
						"name": "banner"
					},
					success: function(data) {
						if (data.code == "200") {
							if (data.data.length > 0) {
								var result = "";
								for (var i = 0; i < data.data.length; i++) {
									var row = data.data[i];
									result += `
										<div class="swiper-slide">
											<img src="/${row.picture}" />
										</div>`;
								}
								
								$(".swiper-wrapper1").append(result);
								
								
								
								var swiper = new Swiper('.index-banner .swiper-container', {
									spaceBetween: 0,
									loop: true,
									autoplay: 5000,
									autoplayDisableOnInteraction: false,
									paginationType: 'bullets',
									pagination: '.index-banner .swiper-pagination',
				
								});
								
								
							} else {
								console.log("没有了");
							}
						} else {
							layer.msg(data.msg);
						}
					},
					error: function() {
						console.log("出错了");
					}
				});
			}


			function get_new() {
				$.ajax({
					url: '/app.php/Index/get_new',
					type: "get",
					dataType: 'json',
					data: {
						"name": "sort"
					},
					success: function(data) {
						if (data.code == "200") {
							if (data.data.length > 0) {
								var result = "";
								for (var i = 0; i < data.data.length; i++) {
									var row = data.data[i];
									result += 	`
									  <div class="swiper-slide">
									  		 <a href="/NewShow_${row.id}.html">
												<img src="${row.picture}" />
											</a>
									  </div>`;
												
												
												
								}
								
								$(".swiper-wrapper2").prepend(result);
								// $('.lpkSelectNav .item').eq(0).find('span').attr('class','iconfont icon-fangzhifuzhuang')
								// $('.lpkSelectNav .item').eq(1).find('span').attr('class','iconfont icon-yingyouer')
								// $('.lpkSelectNav .item').eq(2).find('span').attr('class','iconfont icon-jiaju')
								
							} else {
								console.log("没有了");
							}
						} else {
							layer.msg(data.msg);
						}
					},
					error: function() {
						console.log("出错了");
					}
				});
			}
		</script>

	</body>

</html>