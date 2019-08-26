<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<title>商品分类</title>
		<link rel="stylesheet" href="/public/phone/lb/css/bootstrap.min.css">
		<link rel="stylesheet" href="/public/phone/css/reset.css">
		<link rel="stylesheet" href="/public/phone/css/public.css">
		<link rel="stylesheet" href="/public/phone/css/other.css">
		<link rel="stylesheet" type="text/css" href="/public/phone/css/newStyle.css" />
		<script src="/public/phone/js/rem.js" type="text/javascript" charset="utf-8"></script>
		<style type="text/css">
			[v-cloak] {
				display: none;
			}
		</style>
	</head>

	<body>
		<header class="lpk_head clearfix">
			<div class="fl left">
				<!--<a href="javascript:;"> <font class="glyphicon glyphicon-menu-left"></font> </a>-->
			</div>
			<div class="fl center">
				商品分类
			</div>
			<div class="fr right">
				<!--<a href="javascript:;"><font class="glyphicon glyphicon-shopping-cart"></font></a>-->
			</div>
		</header>
		<div class="" style="width: 100%;height: 1.5rem;"> </div>

		<div class="classification classification clearfix" id="app">
			<aside class="fl">
				<ul>
					<li v-for="(item,index) in tabs" @click="tab(index)" :class="{active_:index == num}"  v-bind:id='item.id' v-cloak>
						<a href="javascript:;">{{item.sort_name}}</a>
					</li>

				</ul>
			</aside>
			<div class="main fr Level">
				<div class="lsjl">
					<div class="container">
						<div class="row lsjl_m">

							<template v-for='(outItem,index) in tabContents'>
								<template v-for="items in outItem">
									<div class="LevelSecond" v-show="index==num" v-cloak>
										{{items.sort_name}} 
									</div>
									<div class="clearfix" v-show="index==num" v-cloak>
										<div class="col-xs-4" v-for='itemCon in items.children' v-cloak>
											<a v-bind:id='itemCon.id'>
												<figure><img v-bind:src="itemCon.picture" /></figure>
												<figcaption>{{itemCon.sort_name}}</figcaption>
											</a>
										</div>
									</div>
								</template>
							</template>

						</div>
					</div>
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
		
		
	</body>

	<script src="/public/phone/js/jquery-3.3.1.min.js"></script>
	<script src="/public/phone/js/vue.min.js"></script>
	<script type="text/javascript">
		
		
	    var  lpkindex = localStorage.getItem("lpkzhi")||0;
		var  topg = localStorage.getItem("topH")||0;
		var vm = new Vue({
			el: '#app',
			data: {
				num: lpkindex,
				tabs: [],
				tabContents: [],
			},
			methods: {
				tab(index) {
					this.num = index;
					if(!this.tabContents[index] && this.tabs[index].flag === true) {
						this.goodsAjax(this.tabs[index].id, index);
					}
					localStorage.setItem("topH", 0);
				},
				goodsAjax(id, index) {
					
					console.log(id,index)
					var that = this;
					this.tabs[index].flag = false;
					$.ajax({
						type: "get",
						url: "/app.php/Product/get_children_sort",
						dataType: 'json',
						data: {
							sort_id: id
						},
						success: function(data) {
							console.log(data)
							Vue.set(that.tabContents, index, data.data);
							
							console.log(topg)
							$('.Level').animate({
									scrollTop: topg
							}, 10);
						}
					});
				}
			}
		});
	</script>
	<script>
		$(function() {
			var height = document.documentElement.clientHeight;
			var h_height = $('.lpk_head').height();
			var f_height = $('.lpk_foot').outerHeight(true);
			//			             document.body.scrollHeight;
			$('.classification').height(height - h_height  - f_height);
			
			$.ajax({
				type: "get",
				url: "/app.php/Product/get_root_sort",
				dataType: "json",
				success: function(data) {
					vm.tabs = data.data;
					vm.tabs.forEach(item => {
						item.flag = true;
					})
					
					$('.classification').on('click', 'aside ul li ', function() {
						var index = $(this).index();
						localStorage.setItem("lpkzhi", index);
					})
					vm.goodsAjax(vm.tabs[lpkindex].id,lpkindex);
					
				}
			});
			
			
		})
		
		$('.Level').on('click','.lsjl_m > div > div a',function(){
			var id=$(this).attr('id');
			var topHeight = $('.Level').scrollTop() 
			localStorage.setItem("topH", topHeight);
			
			console.log(topHeight)
			window.location.href = `ProductShow.html?id=${id}`;
		})
		
			
		
		
	</script>

</html>