<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>商品详情</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="/public/phone/css/lpk.css" />
		<link rel="stylesheet" href="/public/phone/lb/css/bootstrap.min.css">
		<link rel="stylesheet" href="/public/phone/lb/css/swiper.min.css">
		<link rel="stylesheet" href="/public/phone/css/reset.css">
		<link rel="stylesheet" href="/public/phone/css/public.css">
		<link rel="stylesheet" href="/public/phone/css/other.css">
		<link rel="stylesheet" type="text/css" href="/public/phone/css/newStyle.css" />
		<link rel="stylesheet" href="/public/phone/layer/layui.css">
		<style type="text/css">
			a:hover,
			a:focus {
				color: #fff !important;
			}
			.layui-layer-btn0{
				background: #0ac038 !important;
			}
		</style>
		<script src="/public/phone/js/rem.js"></script>
		
	</head>

	<body style="background: white !important;">
		<header class="lpk_head clearfix">
			<div class="fl left">
				<a onclick="javascript :history.back(-1);">
					<font class="glyphicon glyphicon-menu-left"></font>
				</a>
			</div>
			<div class="fl center">
				商品详情
			</div>
			<div class="fr right">
				<!--< a href="javascript:;"><font class="glyphicon glyphicon-shopping-cart"></font></ a>-->
			</div>
		</header>
		<div class="" style="width: 100%;height: 1.5rem;"></div>
		<div class="pro-banner">
			<div class="swiper-container">
				<div class="swiper-wrapper">

				</div>
				<!-- Add Pagination -->
				<div class="swiper-pagination"></div>
			</div>
		</div>

		<div class="pro-tit">
			<h2></h2>
			<p>¥ <span class="span1"></span>
				<font class="font1">元</font>
				/
				<font class="font3"></font>
				
			</p>
		</div>
		
		<style type="text/css">
			.pro-tit1 p,.pro-tit1 text{
				font-size: 14px !important;
				color: #000;
			}
		</style>
		<div class="pro-tit pro-tit1">
			<p>
				运费 <text class="fr">8元</text>
			</p>
		</div>

		<div class="pro-parameter">
			<input type="hidden" id="store_id" name="store_id">
			<div class="address">
				<span>规格</span>
				<p>请选择尺码/颜色分数</p>
				<font class="glyphicon glyphicon-menu-right"></font>
			</div> <br />
			<div class="parameter">
				<span>参数</span>
				<p>生产日期 品牌 ...</p>
				<font class="glyphicon glyphicon-menu-right"></font>
			</div>
		</div>
		<div class="pro_p">
			<p></p>
		</div>

		<div class="pro-info">

		</div>

		<!--<div class="pro-bot">
			<div class="add-good">加入购物车</div>
			<div class="buy-good buy-good_">立即购买</div>
		</div>-->

		<div class="lpkShopp clearfix">
			<div class="fl left">
				<a href="javascript:;">
					<!-- <span><img src="/public/phone/img/dp.png"/></span> -->
					<!-- <font>店铺</font> -->
				</a>
				<a href="javascript:;" class="scClick">
					<span><img src="/public/phone/img/sc1.png"/></span>
					<font>收藏</font>
				</a>
			</div>
			<div class="fr right">
				<p>
					<a class="go1" data-code="false">加入购物车</a>
					<a class="go2" data-code="false">立即购买</a>
				</p>
			</div>
		</div>

		<div class="" style="height: 1.5rem;"></div>
		<div class="true_tk true_tk_" style="display: none;">
			<div class="_mian shop_info shop_info_ lpkgg">
				<span class="glyphicon glyphicon-remove"></span>
				<div class="clearfix img_">
					<div class="fl left" id="now-img">
						<img src="/public/phone/img/order01.png" />
					</div>
					<div class="fl right">

						<h3>¥ <span id="now-price"></span></h3>
						<h4> 库存<text id="now-num"></text> <font></font></h4>
					</div>
				</div>

				<div class="lpkScrool" style="height: 4.5rem;">

					<div class="specifications1">
						
					</div>
					<div class="goods-num">
						<h5>购买数量</h5>
						<p>
							<font class="glyphicon glyphicon-minus min"></font>
							<span>1</span>
							<font class="glyphicon glyphicon-plus add"></font>
						</p>
					</div>
				</div>
				<div class="item3">
					<a href="javascript:;">确定</a>
				</div>

			</div>
		</div>

		<div class="true_tk true_tk1">
			<div class="_mian shop_info">
				<span class="glyphicon glyphicon-remove lpkh3"></span>
				<h3>基本信息</h3>
				<div class="_ifno">

				</div>
				<div class="item4">
					<a href="">确 定</a>
				</div>

			</div>
		</div>

		<script src="/public/phone/lb/js/jquery.min.js"></script>
		<script src="/public/phone/layer/layer.js"></script>
		<script src="/public/phone/lb/js/bootstrap.min.js"></script>
		<script src="/public/phone/lb/js/swiper-3.4.2.jquery.min.js"></script>
		<script>
			var lpksc=0;
			var member_id = "<?php echo ($member_id); ?>";
			var member_type = "<?php echo ($member_type); ?>";
			var id = "<?php echo ($id); ?>";
			var is_tishi = "<?php echo ($is_tishi); ?>";

			$('.scClick').click(function() {

				var fontText = $('.scClick font').text();
				var idnew = $('.pro-tit h2').attr('id')

				if(fontText == '收藏') {
					
					$.ajax({
						type: "post",
						url: "/app.php/MyCollection/add",
						dataType: "json",
						data: {
							id: idnew,
							member_id: member_id,
						},
						success: function(data) {
							if(data.code == "200") {
								$('.scClick').find('img').attr('src', '/public/phone/img/sc2.png');
								$('.scClick').children('font').removeClass('on').addClass('active');
								$('.scClick font').text('已收藏');
								layer.msg("收藏成功");
							} 
							else if(data.code=="404")
							{
								layer.msg(data.msg,{time:2000},function(){
									window.location.href = "/login.html";
								});
							}
							else {
								layer.msg(data.msg);
							}
						}
					})

				}
				else{
					$.ajax({
						type: "post",
						url: "/app.php/MyCollection/delete",
						dataType: "json",
						data: {
							id: lpksc,
							member_id: member_id,
						},
						success: function(data) {
							if(data.code == "200") {
								$('.scClick').find('img').attr('src', '/public/phone/img/sc1.png');
								$('.scClick').children('font').removeClass('active').addClass('on');
								$('.scClick font').text('收藏');
								layer.msg("取消收藏");
							} 
							else if(data.code=="404")
							{
								layer.msg(data.msg,{time:2000},function(){
									window.location.href = "/login.html";
								});
							}
							else {
								layer.msg(data.msg);
							}
						}
					})
					
				}

			});

			$('.specifications1').on('click', 'span', function() {
				$(this).addClass('active').siblings().removeClass('active');

			})

			$(function() {
				// if(is_tishi=="0")
				// {
				// 	layer.confirm('成为会员更优惠，立即前往', {
				// 	  	title: '成为会员',
				// 	  	btn: ['确定','取消'] //按钮
				// 	}, function(){
				// 		window.location.href="/Package.html";
				// 	}, function(){
				// 	 	layer.closeAll();
					  
				// 	});
				// }

				$.ajax({
					type: 'get',
					url: '/app.php/Product/show',
					dataType: 'json',
					data: {
						id: id
					},
					success: function(data) {
						console.log(data.data)
						$('#store_id').val(data.data.store_id);
						//id
						$('.pro-tit h2').attr('id', data.data.id)
						//轮播图
						var newlbt = '';
						var lbt = data.data.picturemore;
						for(var i = 0; i < lbt.length; i++) {
							newlbt += `
							<div class="swiper-slide">
								<img src="${lbt[i]}" />
							</div>`;
						}
						
						$('.swiper-wrapper').append(newlbt);
						var swiper = new Swiper('.pro-banner .swiper-container', {
							slidesPerView: '1',
							spaceBetween: 10,
							loop: true,
							autoplay: 3000,
							pagination: '.pro-banner .swiper-pagination',
						});
						//	商品名称
						var shopName = data.data.title;
						$('.pro-tit h2').text(shopName);
						//	商品价格
						// var shopPrice = data.data.current_price;
						// $('.pro-tit p .span1').text(shopPrice);
						// //  单位
						// var shopUnit = data.data.unit;
						// $('.pro-tit p .font3').text(shopUnit);
						//						产示图
						var content = data.data.content;
						for(var j = 0; j < content.length; j++) {
							var newContent = `
							<p><img src="${content[j]}" /></p>
							`
							$('.pro-info').append(newContent);
						}

						// 						是否收藏
						var is_collection = data.data.is_collection;
						
						lpksc=is_collection
						
						
						if(is_collection == 0) {
							$(this).find('img').attr('src', '/public/phone/img/sc1.png');
							$(this).children('font').removeClass('active').addClass('on');
							$('.scClick font').text('收藏');
							
						}else{
							
							$('.lpkShopp .left .scClick span img').attr('src', '/public/phone/img/sc2.png');
							$('.scClick font').removeClass('on').addClass('active');
							$('.scClick font').text('已收藏');
						}
						//						参数
						var Attr = JSON.parse(data.data.attr);
						
						for(item in Attr) {
							var lpkHtml = `
								<div class="clearfix">
									<p class="fl left">${item}</p>
									<p class="fl right">${Attr[item]}</p>
								</div>
							`;
							$("._ifno").append(lpkHtml);
						}

						//						描述 
						$('.pro_p p').text(data.data.description);
						//						缩略图
						$('.shop_info .img_ .left img').attr('src', data.data.picture);
						//						价格
						console.log(member_type);
						if(member_type=="0")
						{
							console.log(data.data.youke_price);
							price_type = data.data.youke_price.split("+");
							price_yuan = price_type[0];
							price_jifen = price_type[1];
							$("#now-price").text(price_yuan);
							$("#now-jifen").text(price_jifen);
							$('.pro-tit p .span1').text(price_yuan);
							$('.pro-tit p .span2').text(price_jifen);

							$('.pro-tit p .font3').text(data.data.youke_unit);
						}
						else if(member_type=="1")
						{
							price_type = data.data.huiyuan_price.split("+");
							price_yuan = price_type[0];
							price_jifen = price_type[1];
							$("#now-price").text(price_yuan);
							$("#now-jifen").text(price_jifen);
							$('.pro-tit p .span1').text(price_yuan);
							$('.pro-tit p .span2').text(price_jifen);
							$('.pro-tit p .font3').text(data.data.huiyuan_unit);
						}
						else if(member_type=="2")
						{
							price_type = data.data.dianpu_price.split("+");
							price_yuan = price_type[0];
							price_jifen = price_type[1];
							$("#now-price").text(price_yuan);
							$("#now-jifen").text(price_jifen);
							// $('.pro-tit p .span1').text(price_yuan);
							$('.pro-tit p .span2').text(price_jifen);
							$('.pro-tit p .font3').text(data.data.dianpu_unit);
						}
						
						//						名称
						$('.lpk_head .center').text(data.data.title);
						//                        库存
						$('.shop_info .img_ .right h4 text').text(data.data.reserve);
						//						单位
						$('.shop_info .img_ .right h4 font').text(data.data.unit);
						//						规格

						var spec = data.data.spec;
						var abc = JSON.parse(spec);
						
						var picArr = JSON.parse(data.data.spec_picture);
						console.log(picArr);
						var guigeHtml = '';
						var guigeType = [];
						if(abc[0]) {
							for(item in abc[0]) {
								if(item !== "游客价" && item !== "会员价" && item !== "店铺价" && item !== "库存") {
									var arrItem = {};
									arrItem[item] = [];
									guigeType.push(arrItem);
								}
							}
						}
						console.log(guigeType);
						
						abc.forEach(item => {
							for(inItem in item) {
								guigeType.forEach(arrItem => {
									for(keyItem in arrItem) {
										if(keyItem === inItem) {
											arrItem[keyItem].push(item[keyItem]);
										}
									}
									arrItem[keyItem] = Array.from(new Set(arrItem[keyItem]));
								})
							}
						})
						
						guigeType.forEach(item => {
							var inHtml = '';
							var thisKey;
							for(lpkItem in item) {
								thisKey = lpkItem;
							}
							item[thisKey].forEach(inItem => {
								inHtml += `
									<span>${inItem}</span>
								`;
							})
							guigeHtml += `
								<h5>${thisKey}</h5>
								<div class="specificationsMain">
									${inHtml}
								</div>
							`;
						})
						$(".specifications1").html(guigeHtml);
						$(".specifications1").on("click", "span", function() {
							var onNum = $(".specifications1").find(".active").length;
							var findPic = $(this).text();
							var findPicType = $(this).parents(".specificationsMain").prev().text();
//							picArr.forEach(item => {
//								console.log(item);
//								for(inItem in item) {
//									if(inItem === findPicType) {
//										item[findPicType].forEach(imgItem => {
//											for(imgInItem in imgItem) {
//												if(imgInItem === findPic) {
//													$("#now-img img").attr("src", imgItem[findPic]);
//												}
//											}
//										})
//									}
//								}
//
//							})
							console.log(onNum);
							console.log(guigeType.length);
							if(onNum === guigeType.length) {
								var typeArr = [];
								var myPrice; //现价
								var nowNum; //库存
								for(var i = 0; i < onNum; i++) {
									typeArr.push($(".specifications1").find(".active").eq(i).parents(".specificationsMain").prev().text());
								}
								abc.some(item => {
									var myFlag = typeArr.every((arrItem, i) => {
										thisNum = $(".specifications1").find(".active").eq(i).text();
										console.log(item[arrItem]);
										console.log(thisNum);
										console.log(member_type);
										if(item[arrItem] === thisNum) {
											if(member_type=="0")
											{
												myPrice = item["游客价"];
											}
											else if(member_type=="1")
											{
												myPrice = item["会员价"];
											}
											else if(member_type=="2")
											{
												myPrice = item["店铺价"];
											}
											nowNum = item["库存"];

											return true;
										}
									})
									if(myFlag === true) {
										return true;
									}

								})
								console.log(abc);
								console.log(myPrice);
								price_type = myPrice.split("+");
								price_yuan = price_type[0];
								price_jifen = price_type[1];
								$("#now-price").text(price_yuan);
								$("#now-jifen").text(price_jifen);
								$("#now-num").text(nowNum);

							}
						})
					}
				})

			});

			$('.pro-parameter .address').on('click', function() {
				$('.item3').hide();
				$('html,body').addClass('ovfHiden'); //使网页不可滚动
				$('.true_tk_').slideDown(200);
				$('.lpkShopp').css('z-index', 10);
				$('.lpkShopp a').data("code", true);
			})



			var lpktext = '';
			$('.lpkShopp .go2').click(function() {
				if($(this).data('code') === false) {
					$('.item3').show();
					lpktext = $(this).text();
					$('html,body').addClass('ovfHiden'); //使网页不可滚动
					$('.true_tk_').slideDown(200);
				} 
				else {
					//					立即购买
					var $id = $('.pro-tit h2').attr('id');
					var $count = $('.goods-num p span').text();
					var arr1 = $('.lpkgg .specifications1 h5');
					var arr2 = $('.lpkgg .specifications1 .active');
					var obj = {};

					if(arr1.length != arr2.length) {
						for(var i = arr1.length - 1; i >= 0; i--) {
							if($(arr1).eq(i).next().find('span').is('.active')) {} else {
								var newtext = $(arr1).eq(i).text();
							}
						}
						layer.msg("请选择" + newtext, {
							time: 1000
						})

					} else {
						for(var i = 0; i < arr1.length; i++) {
							var str = arr1.eq(i).text();
							obj[str] = arr2.eq(i).text();
						}
						var store_id = $('#store_id').val();
						var lpkobj = {
							store_id:store_id,
							id: $id,
							count: $count,
							spec: obj
						}
						var newobj = JSON.stringify(lpkobj);
						var product_array = [];
						product_array.push(lpkobj);

						var newobj = JSON.stringify(product_array);
						console.log(newobj);
						window.location.href = encodeURI('SureOrder.html?back=0&obj=' + newobj + '&member_id=' + member_id);

					}

				}

			})

			$('.lpkShopp .go1').click(function() {
				if($(this).data('code') === false) {
					$('.item3').show();
					lpktext = $(this).text();
					$('html,body').addClass('ovfHiden'); //使网页不可滚动
					$('.true_tk_').slideDown(200);
				} 
				else {
					//加入购物车
					var $id = $('.pro-tit h2').attr('id');
					var $text = $('.goods-num p span').text();
					var arr1 = $('.lpkgg .specifications1 h5');
					var arr2 = $('.lpkgg .specifications1 .active');
					var $peice = $('#now-price').text;
					var obj = {};
					if(arr1.length != arr2.length) {
						for(var i = arr1.length - 1; i >= 0; i--) {
							if($(arr1).eq(i).next().find('span').is('.active')) {} else {
								var newtext = $(arr1).eq(i).text();
							}
						}
						layer.msg("请选择" + newtext, {
							time: 1000
						})

					} 
					else {
						for(var i = 0; i < arr1.length; i++) {
							var str = arr1.eq(i).text();
							obj[str] = arr2.eq(i).text();
							//							obj['"' + str + '"'] = arr2.eq(i).text();
						}
						// console.info(obj);
						var newobj = JSON.stringify(obj)
						// console.info(newobj);
						$.ajax({
							type: "post",
							url: "/app.php/ShoppingCart/add",
							dataType: 'json',
							data: {
								member_id: member_id,
								id: $id,
								count: $text,
								spec: newobj,
							},
							success: function(data) {
								console.log(data)
								if(data.code == "200") {
									layer.msg("成功加入购物车");
									$('.lpkShopp a').data("code", false);
									$('.lpkShopp').css('z-index', 0);
									$('html,body').removeClass('ovfHiden'); //使网页恢复可滚
									$('.true_tk_').slideUp(200)
								}
								else if(data.code == "404") {
									layer.msg(data.msg, {
										time: 2000
									}, function() {
										window.location.href = "/login.html";
									})
								} 
								else {
									layer.msg(data, msg);
								}
							}
						});
					}
				}
			})

			$('.lpkgg .item3').on('click', function() {
				console.log(lpktext)
				if(lpktext == '加入购物车') {
					//加入购物车
					var $id = $('.pro-tit h2').attr('id');
					var $text = $('.goods-num p span').text();
					var arr1 = $('.lpkgg .specifications1 h5');
					var arr2 = $('.lpkgg .specifications1 .active');
					var $peice = $('#now-price').text;
					var obj = {};
					if(arr1.length != arr2.length) {
						for(var i = arr1.length - 1; i >= 0; i--) {
							if($(arr1).eq(i).next().find('span').is('.active')) {} else {
								var newtext = $(arr1).eq(i).text();
							}
						}
						layer.msg("请选择" + newtext, {
							time: 1000
						})
					} 
					else {
						for(var i = 0; i < arr1.length; i++) {
							var str = arr1.eq(i).text();
							obj[str] = arr2.eq(i).text();
							//							obj['"' + str + '"'] = arr2.eq(i).text();
						}
						// console.info(obj);
						var newobj = JSON.stringify(obj)
						// console.info(newobj);

						$.ajax({
							type: "post",
							url: "/app.php/ShoppingCart/add",
							dataType: 'json',
							data: {
								member_id: member_id,
								id: $id,
								count: $text,
								spec: newobj,
							},
							success: function(data) {
								console.log(data);
								if(data.code == "200") {
									layer.msg("成功加入购物车");
									$('.lpkShopp a').data("code", false);
									$('.lpkShopp').css('z-index', 0);
									$('html,body').removeClass('ovfHiden'); //使网页恢复可滚
									$('.true_tk_').slideUp(200);
								}
								else if(data.code == "404") {
									layer.msg(data.msg, {
										time: 2000
									}, function() {
										window.location.href = "/login.html";
									})
								} 
								else {
									layer.msg(data, msg);
								}
							}
						});
					}
				} 
				else if(lpktext == '立即购买') {
					var $id = $('.pro-tit h2').attr('id');
					var $count = $('.goods-num p span').text();
					var arr1 = $('.lpkgg .specifications1 h5');
					var arr2 = $('.lpkgg .specifications1 .active');
					var obj = {};
					if(arr1.length != arr2.length) {
						for(var i = arr1.length - 1; i >= 0; i--) {
							if($(arr1).eq(i).next().find('span').is('.active')) {} else {
								var newtext = $(arr1).eq(i).text();
							}
						}
						layer.msg("请选择" + newtext, {
							time: 1000
						})
					} 
					else {
						for(var i = 0; i < arr1.length; i++) {
							var str = arr1.eq(i).text();
							obj[str] = arr2.eq(i).text();
						}
						var store_id = $('#store_id').val();
						var lpkobj = {
							store_id: store_id,
							id: $id,
							count: $count,
							spec: obj
						}
						
						// var newobj = JSON.stringify(lpkobj);
						var newobj = JSON.stringify(lpkobj);
						var product_array = [];
						product_array.push(lpkobj);

						var newobj = JSON.stringify(product_array);
						console.log(newobj);
						window.location.href = encodeURI('SureOrder.html?back=0&obj=' + newobj + '&member_id=' + member_id);
					}
				}
			})
			$('.shop_info > span').click(function() {
				$('.lpkShopp a').data("code", false);
				$('.lpkShopp').css('z-index', 0);
				$('html,body').removeClass('ovfHiden'); //使网页恢复可滚
				$('.true_tk_').slideUp(200)
			})
			$('.true_tk_').click(function() {
				$('.lpkShopp').css('z-index', 0);
				$('.lpkShopp a').data("code", false);
				$('html,body').removeClass('ovfHiden'); //使网页恢复可滚
				$('.true_tk_').slideUp(200);
			})
			$(".shop_info_").click(function(e) {
				e.stopPropagation();
			})

			$(".add").click(function() {
				var t = $(this).parent().find('span');
				t.text(parseInt(t.text()) + 1)
			})
			$(".min").click(function() {
				var t = $(this).parent().find('span');
				t.text(parseInt(t.text()) - 1)
				if(parseInt(t.text()) < 1) {
					t.text(1);
				}
			})
		</script>
		<script type="text/javascript">
			$(".parameter").click(function() {
				$('html,body').addClass('ovfHiden'); //使网页不可滚动
				$('.true_tk1').slideDown(200)
			})
			$(".lpkh3").click(function() {
				$('html,body').removeClass('ovfHiden'); //使网页恢复可滚
				$(".true_tk1").slideUp(200);
			})
		</script>
	</body>

</html>