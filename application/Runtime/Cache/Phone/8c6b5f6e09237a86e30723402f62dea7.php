<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>我的订单</title>
		<link rel="stylesheet" type="text/css" href="/public/phone/css/lpk.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/lb/css/bootstrap.css" />
		<link rel="stylesheet" href="/public/phone/layer/layui.css">
		<link rel="stylesheet" type="text/css" href="/public/phone/css/reset.css" />
		<script src="/public/phone/js/jquery-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/lb/js/bootstrap.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/layer/layer.js"></script>
		<script src="/public/phone/js/rem.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="/public/phone/dist/dropload.css" />
		<script src="/public/phone/dist/dropload.min.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" href="/public/phone/css/style.css">
		<script src="/public/phone/js/iscroll.js"></script>
		<style type="text/css">
			.lpkweapper {
				display: none;
			}
		</style>
	</head>

	<body>
		<header class="lpk_head clearfix">
			<div class="fl left">
				<a href="/MyCenter.html">
					<font class="glyphicon glyphicon-menu-left"></font>
				</a>
			</div>
			<div class="fl center">
				我的订单
			</div>
			<div class="fr right">
				<a href="javascript:;">
					<!--<font class="xg">修改</font>-->
				</a>
			</div>
		</header>
		<div class="my_order">
			<ul class="clearfix">
				<li id="qb" >
					<a class="active">全部</a>
				</li>
				<li id="dfc" data-ajax="true">
					<a class="">待付款</a>
				</li>
				<li id="dfh" data-ajax="true">
					<a class="">待发货</a>
				</li>
				<li id="dsh" data-ajax="true">
					<a class="">待收货</a>
				</li>
			</ul>
		</div>
		<div id="wrapper0" class="lpkweapper" style="top: 2.75rem;bottom: 0; display: block">
			<div id="scroller0">
				<section class="my_order_main section">
				</section>
				<div class="pull-loading pull-loading0">
					上拉加载
				</div>
			</div>
		</div>
		<div id="wrapper1" class="lpkweapper" style="top: 2.7rem;bottom: 0;">
			<div id="scroller1">
				<section class="my_order_main section1">
				</section>
				<div class="pull-loading pull-loading1">
					上拉加载
				</div>
			</div>
		</div>
		<div id="wrapper2" class="lpkweapper" style="top: 2.7rem;bottom: 0;">
			<div id="scroller2">
				<section class="my_order_main section2">
				</section>
				<div class="pull-loading pull-loading2">
					上拉加载
				</div>

			</div>
		</div>
		<div id="wrapper3" class="lpkweapper" style="top: 2.7rem;bottom: 0;">
			<div id="scroller3">
				<section class="my_order_main section3">
				</section>
				<div class="pull-loading pull-loading3">
					上拉加载
				</div>

			</div>
		</div>





		<div class="true_tk" >
			<div class="_mian">
				<h3>确认付款 <span class="glyphicon glyphicon-remove"></span></h3>
				<div class="_money" style="font-size: 16px;">
					<text>￥</text>
					<font id="jq"></font>
					+
					<font id="jf"></font>
					<text>积分</text>
				</div>
				
				 <div class="fkfs">
					<a href="javascript:;">付款方式：</a>
				</div>
				<p class="fk" >
					<input type="radio" name="fk" id="fk1" value="weixin" /><label for="fk1"><img src="/public/phone/img/wx.png"/></label>
				</p> 
				<p class="fk" >
					<input type="radio" name="fk" id="fk2" value="alipay" /><label for="fk2"><img src="/public/phone/img/zfb.png"/></label>
				</p> 
				<!-- <p class="fk" >
					<input type="radio" name="fk" id="fk3" value="commission" /><label for="fk3">可用余额(<span>99.00</span>)</label>
				</p>  -->
				
					
			 <br />
				
				<div class="fkfs">
					<a href="javascript:;">可用积分：<text style='color: #0ac038;font-size: 0.45rem;' id="keyong_integral"></text></a>
				</div>
				
				<div class="true_fkfs">
					<a>确认付款</a>
				</div>
			</div>
			
		</div>
	</body>
	<script>
		var member_id = "<?php echo ($member_id); ?>";
		$('.my_order ul li').on('click', function() {
			var index = $('.my_order ul li').index(this);
			$(this).children('a').addClass('active').parent().siblings().children().removeClass('active');
			$('.lpkweapper').eq(index).show().siblings('.lpkweapper').hide();
		})

		$('.my_order_main').on('click', '.item .item_top', function() {
			var order_id = $(this).attr('order_id');
			var store_id = $(this).attr('store_id');
			window.location.href = `Order/info.html?order_id=${order_id}&store_id=${store_id}`;
		})

		$(function() {
			
			if(location.href.indexOf('?') > 0)
			{
				var lpkData = location.href.split("?")[1];
				var id = lpkData.split("=")[1];
				if(id==0){
					document.getElementById("dfc").click();
				}
				else if(id==1){
					document.getElementById("dfh").click();
				}
				else if(id==2){
					document.getElementById("dsh").click();
				}
			}
			else
			{
				get_all();
			}
			
		});

		$('#qb').on('click', function() {
			if($(this).data("ajax") === true) {
				$(this).data('ajax', false);
				get_all();
			}
			get_all();
		})
		$('#dfc').on('click', function() {
			if($(this).data("ajax") === true) {
				$(this).data('ajax', false);
				get_daifukuan();
			}

		})
		$('#dfh').on('click', function() {
			if($(this).data("ajax") === true) {
				$(this).data('ajax', false);
				get_daifahuo();
			}

		})
		$('#dsh').on('click', function() {
			if($(this).data("ajax") === true) {
				$(this).data('ajax', false);
				get_daishouhuo();
			}
		})
		
		var myscroll = new iScroll("wrapper0", {
			onScrollMove: function() { //拉动时
				//上拉加载
				if(this.y < this.maxScrollY) {
					console.log(this.y ,this.maxScrollY)
					$(".pull-loading0").html("释放加载");
					$(".pull-loading0").addClass("loading");
				} else {
					$(".pull-loading0").html("上拉加载");
					$(".pull-loading0").removeClass("loading");
				}
			},
			onScrollEnd: function() { //拉动结束时
				//上拉加载
				if($(".pull-loading0").hasClass('loading')) {
					$(".pull-loading0").html("加载中...");
					get_all();

				}
			},
			onRefresh: function() {
				$('.pull-loading0').html("上拉加载");
			}
		});
		var myscroll1 = new iScroll("wrapper1", {
			onScrollMove: function() { //拉动时
				//上拉加载
				if(this.y < this.maxScrollY) {
					console.log(this.maxScrollY)
					$(".pull-loading1").html("释放加载");
					$(".pull-loading1").addClass("loading");
				} else {
					$(".pull-loading1").html("上拉加载");
					$(".pull-loading1").removeClass("loading");
				}
			},
			onScrollEnd: function() { //拉动结束时
				//上拉加载
				if($(".pull-loading1").hasClass('loading')) {
					$(".pull-loading1").html("加载中...");
					get_daifukuan();

				}
			},
			onRefresh: function() {
				$('.pull-loading1').html("上拉加载");
			}
		});

		var myscroll2 = new iScroll("wrapper2", {
			onScrollMove: function() { //拉动时
				//上拉加载
				if(this.y < this.maxScrollY) {
					$(".pull-loading2").html("释放加载");
					$(".pull-loading2").addClass("loading");
				} else {
					$(".pull-loading2").html("上拉加载");
					$(".pull-loading2").removeClass("loading");
				}
			},
			onScrollEnd: function() { //拉动结束时
				//上拉加载
				if($(".pull-loading2").hasClass('loading')) {
					$(".pull-loading2").html("加载中...");
					get_daifahuo();

				}
			},
			onRefresh: function() {
				$('.pull-loading2').html("上拉加载");
			}
		});

		var myscroll3 = new iScroll("wrapper3", {
			onScrollMove: function() { //拉动时
				//上拉加载
				if(this.y < this.maxScrollY) {
					$(".pull-loading3").html("释放加载");
					$(".pull-loading3").addClass("loading");
				} else {
					$(".pull-loading3").html("上拉加载");
					$(".pull-loading3").removeClass("loading");
				}
			},
			onScrollEnd: function() { //拉动结束时
				//上拉加载
				if($(".pull-loading3").hasClass('loading')) {
					$(".pull-loading3").html("加载中...");
					get_daishouhuo();

				}
			},
			onRefresh: function() {
				$('.pull-loading3').html("上拉加载");
			}
		});

		//全部
		//上拉加载函数,ajax
		var page = 1; 
		var num = 5;

		function get_all() {
			setTimeout(function() {
				$.ajax({
					url: 'app.php/Order/getData',
					type: "get",
					dataType: 'json',
					data: {
						member_id: member_id,
						CurrentPage: page,
						paginalNum: num
					},
					success: function(data) {
						if(data.code=="200")
						{
							if(data.data.length>0)
							{
								var shops = data.data;
								for(var i = 0; i < shops.length; i++) {
									lpkstr = "";
									result = "";
									var shop = shops[i];
									var products = shops[i].product;
									if(products.length>0)
									{
										for(var j = 0; j < products.length; j++) {
											var product = products[j];
											var jsonObj = product.spec;
											var newStr = '';
											if(jsonObj)
											{
												// console.log(jsonObj);
												let strToObj = JSON.parse(jsonObj);
												for(var prop in strToObj) {
													newStr += strToObj[prop] + '  ';
												}
											}
											
											lpkstr += `
											   	<div class="item_top clearfix" order_store="${shop.id}" store_id="${shop.store_id}">
													<div class="fl left">
														<img src= "${product.picture}">
													</div>
													<div class="fl center">
														<p class='mingC'>${product.title}></p>
													    <p class='guiG'>${newStr}</p>
													</div>
													<div class="fr right">
														<p>¥
															<font>${product.current_price}</font>
														</p>
														<p>x${product.number}</p>
													</div>
												</div>`;
										}
										var xiaoji_price = 0;
										if(Number(shop.integral)>0)
										{
											xiaoji_price = shop.payment_price + "+" + shop.integral;
										}
										else
										{
											xiaoji_price = shop.payment_price;
										}	
										//待付款
										if(shop.order_status=="0")
										{
											result += `
												<div class="item" order_store="${shop.id}" store_id="${shop.store_id}">
													<h3>${shop.store_name}  <span>待付款</span></h3>
													 
													 ${lpkstr}
													 
													<div class="item_price">
														<p>共${shop.xiaoji_num}件商品总价 
															<span>￥${xiaoji_price}</span>
														</p>
													</div>
													<div class="item_bottom">
														<p>
															<a class="item1 cancel">取消订单</a>
															<a class="item2 lpkfukuan">去付款</a>
														</p>
													</div>
												</div>`;
										}
										//待发货
										if(shop.order_status=="1")
										{
											result += `
												<div class="item" order_store="${shop.id}" store_id="${shop.store_id}">
													<h3>${shop.store_name} <span>待发货</span></h3>
													${lpkstr}
													<div class="item_price">
														<p>共${shop.xiaoji_num}件商品总价 
															<span>￥${xiaoji_price}</span>
														</p>
													</div>
													<div class="item_bottom">
														<p>
															<a class="item2 fahuo">提醒发货</a>
														</p>
													</div>
												</div>`;
										}
										//待收货
										if(shop.order_status=="2")
										{
											result += `
												<div class="item" order_store="${shop.id}" store_id="${shop.store_id}">
													<h3>${shop.store_name} <span>已下单</span></h3>
													${lpkstr}
													<div class="item_price">
														<p>共${shop.xiaoji_num}件商品总价 <span>￥${xiaoji_price}</span></p>
													</div>
													<div class="item_bottom">
														<p>
															<a class="item2 itemtrue">确认收货</a>
														</p>
													</div>
												</div>`;
										}
									}
								}
								$("#scroller0 .section").append(result);
								page++;
								myscroll.refresh();
							}
							else
							{
								$(".pull-loading").text("无数据");
							}
						}
						else
						{
							layer.msg(layer.msg);
						}
					},
					error: function() {
						console.log("出错了");
					}
				});
				myscroll.refresh();
			}, 1000);
		};

		//待付款
		//上拉加载函数,ajax
		var page0 = 1; 
		var num0 = 5;

		function get_daifukuan() {

			setTimeout(function() {
				$.ajax({
					url: '/app.php/Order/getData',
					type: "get",
					dataType: 'json',
					data: {
						member_id: member_id,
						CurrentPage: page0,
						paginalNum: num0,
						status:0
					},
					success: function(data) {
						console.log(data)
						if(data.code=="200")
						{
							if(data.data.length>0)
							{
								var shops = data.data;
								result = "";
								for(var i = 0; i < shops.length; i++) {
									lpkstr = "";
									var shop = shops[i];
									var products = shop.product;
									if(products.length>0)
									{
										for(var j = 0; j < products.length; j++) {
											var product = products[j];
											var jsonObj = product.spec;
											var newStr = '';
											if(jsonObj)
											{
												console.log(jsonObj);
												let strToObj = JSON.parse(jsonObj);
												for(var prop in strToObj) {
													newStr += strToObj[prop] + '  ';
												}
											}
											lpkstr += `
											   	<div class="item_top clearfix" order_id="${shop.order_id}" store_id="${shop.store_id}">
													<div class="fl left">
														<img src= ${product.picture}>
													</div>
													<div class="fl center">
														<p class='mingC'>${product.title}></p>
													    <p class='guiG'>${newStr}</p>
													</div>
													<div class="fr right">
														<p>¥
															<font>${product.current_price}</font>
														</p>
														<p>x${product.number}</p>
													</div>
												</div>`;
										}
										var xiaoji_price = 0;
										if(Number(shop.integral)>0)
										{
											xiaoji_price = shop.payment_price + "+" + shop.integral;
										}
										else
										{
											xiaoji_price = shop.payment_price;
										}	
										//待付款
										result += `
											<div class="item" order_store="${shop.id}" store_id="${shop.store_id}">
												<h3>${shop.store_name}  <span>待付款</span></h3>
												 
												 ${lpkstr}
												 
												<div class="item_price">
													<p>共${shop.xiaoji_num}件商品总价 
														<span>￥${xiaoji_price}</span>
													</p>
												</div>
												<div class="item_bottom">
													<p>
														<a class="item1 cancel">取消订单</a>
														<a class="item2 lpkfukuan">去付款</a>
													</p>
												</div>
											</div>`;
									}
								}
								$("#scroller1 .section1").append(result);
								page0++;
								myscroll1.refresh();
							}
							else
							{
								$(".pull-loading1").text("无数据");
							}
						}
						else
						{
							layer.msg(layer.msg);
						}
					},
					error: function() {
						console.log("出错了");
					}
				});
				myscroll1.refresh();
			}, 1000);
		};
		
		//待发货
		//上拉加载函数,ajax
		var page1 = 1; 
		var num1 = 5;

		function get_daifahuo() {
			setTimeout(function() {
				$.ajax({
					url: '/app.php/Order/getData',
					type: "get",
					dataType: 'json',
					data: {
						member_id: member_id,
						CurrentPage: page1,
						paginalNum: num1,
						status:1
					},
					success: function(data) {
						if(data.code=="200")
						{
							if(data.data.length>0)
							{
								var shops = data.data;
								result = "";
								for(var i = 0; i < shops.length; i++) {
									lpkstr = "";
									var shop = shops[i];
									var products = shop.product;
									if(products.length>0)
									{
										for(var j = 0; j < products.length; j++) {
											var product = products[j];
											var jsonObj = product.spec;
											var newStr = '';
											if(jsonObj)
											{
												console.log(jsonObj);
												let strToObj = JSON.parse(jsonObj);
												for(var prop in strToObj) {
													newStr += strToObj[prop] + '  ';
												}
											}
											lpkstr += `
											   	<div class="item_top clearfix" order_store="${shop.id}" store_id="${shop.store_id}">
													<div class="fl left">
														<img src= ${product.picture}>
													</div>
													<div class="fl center">
														<p class='mingC'>${product.title}></p>
													    <p class='guiG'>${newStr}</p>
													</div>
													<div class="fr right">
														<p>¥
															<font>${product.current_price}</font>
														</p>
														<p>x${product.number}</p>
													</div>
												</div>`;
										}
										var xiaoji_price = 0;
										if(Number(shop.integral)>0)
										{
											xiaoji_price = shop.payment_price + "+" + shop.integral;
										}
										else
										{
											xiaoji_price = shop.payment_price;
										}	
										//待发货
										result += `
											<div class="item" order_store="${shop.id}" store_id="${shop.store_id}">
												<h3>${shop.store_name} <span>待发货</span></h3>
												${lpkstr}
												<div class="item_price">
													<p>共${shop.xiaoji_num}件商品总价 
														<span>￥${xiaoji_price}</span>
													</p>
												</div>
												<div class="item_bottom">
													<p>
														<a class="item2 fahuo">提醒发货</a>
													</p>
												</div>
											</div>`;
									}
								}
								$("#scroller2 .section2").append(result);
								page1++;
								myscroll2.refresh();
							}
							else
							{
								$(".pull-loading2").text("无数据");
							}
						}
						else
						{
							layer.msg(layer.msg);
						}
					},
					error: function() {
						console.log("出错了");
					}
				});
				myscroll2.refresh();
			}, 1000);
		};

		//待收货
		//上拉加载函数,ajax
		var page2 = 1; 
		var num2 = 5;

		function get_daishouhuo() {
			setTimeout(function() {
				$.ajax({
					url: '/app.php/Order/getData',
					type: "get",
					dataType: 'json',
					data: {
						member_id: member_id,
						CurrentPage: page2,
						paginalNum: num2,
						status:2
					},
					success: function(data) {
						if(data.code=="200")
						{
							if(data.data.length>0)
							{
								var shops = data.data;
								result = "";
								for(var i = 0; i < shops.length; i++) {
									lpkstr = "";
									var shop = shops[i];
									var products = shop.product;
									if(products.length>0)
									{
										for(var j = 0; j < products.length; j++) {
											var product = products[j];
											var jsonObj = product.spec;
											var newStr = '';
											if(jsonObj)
											{
												console.log(jsonObj);
												let strToObj = JSON.parse(jsonObj);
												for(var prop in strToObj) {
													newStr += strToObj[prop] + '  ';
												}
											}
											lpkstr += `
											   	<div class="item_top clearfix" order_id="${shop.order_id}" store_id="${shop.store_id}">
													<div class="fl left">
														<img src= ${product.picture}>
													</div>
													<div class="fl center">
														<p class='mingC'>${product.title}></p>
													    <p class='guiG'>${newStr}</p>
													</div>
													<div class="fr right">
														<p>¥
															<font>${product.current_price}</font>
														</p>
														<p>x${product.number}</p>
													</div>
												</div>`;
										}
										var xiaoji_price = 0;
										if(Number(shop.integral)>0)
										{
											xiaoji_price = shop.payment_price + "+" + shop.integral;
										}
										else
										{
											xiaoji_price = shop.payment_price;
										}	
										//待发货
										result += `
											<div class="item" order_store="${shop.id}" store_id="${shop.store_id}">
												<h3>${shop.store_name} <span>已下单</span></h3>
												${lpkstr}
												<div class="item_price">
													<p>共${shop.xiaoji_num}件商品总价 <span>￥${xiaoji_price}</span></p>
												</div>
												<div class="item_bottom">
													<p>
														<a class="item2 itemtrue">确认收货</a>
													</p>
												</div>
											</div>`;
									}
								}
								$("#scroller3 .section3").append(result);
								page2++;
								myscroll3.refresh();
							}
							else
							{
								$(".pull-loading3").text("无数据");
							}
						}
						else
						{
							layer.msg(layer.msg);
						}
					},
					error: function() {
						console.log("出错了");
					}
				});
				myscroll3.refresh();
			}, 1000);
		};
		
		
		$('.my_order_main ').on('click','.lpkfukuan',function(){

			$('.true_tk').toggle();
		})
		$('.true_tk ._mian>h3>span').click(function(){

			$('.true_tk').toggle();
		})
		$('.my_order_main ').on('click','.cancel',function(){
			var store_id = $(this).parents('.item').attr('order_store');
			cancel_order(store_id);
		})
		$('.my_order_main ').on('click','.fahuo',function(){
			var store_id = $(this).parents('.item').attr('order_store');
			tixing_fahuo(store_id);
		})
		function cancel_order(store_id){
			$.ajax({
				url:'/app.php/Order/delete',
				data:{store_id:store_id},
				type:'post',
				dataType:'json',
				success:function(data){
					if(data.code=="200")
					{
						layer.msg(data.msg,{time:2000},function(){
							window.location.reload();
						});
					}
					else
					{
						layer.msg(data.msg);
					}
				}
			})
		}
		function tixing_fahuo(store_id){
			layer.msg("已提醒上架，请耐心等待");
		}
	</script>
	

</html>