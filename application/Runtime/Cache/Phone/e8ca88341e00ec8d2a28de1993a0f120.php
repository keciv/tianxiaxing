<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title>购物车</title>
		<link rel="stylesheet" href="/public/phone/css/lpk.css" />
		<link rel="stylesheet" href="/public/phone/lb/css/bootstrap.min.css">
		<link rel="stylesheet" href="/public/phone/css/reset.css">
		<link rel="stylesheet" href="/public/phone/css/other.css">
		<link rel="stylesheet" href="/public/phone/css/public.css" />
		<link rel="stylesheet" href="/public/phone/css/shoppingcart.css" />
		<link rel="stylesheet" href="/public/phone/layer/layui.css">
		<link rel="stylesheet" href="/public/phone/css/style.css">

		<style type="text/css">
			.layui-layer-btn a {
				font-size: 14px;
			}
			
			.layui-layer-btn .layui-layer-btn0 {
				background: #DC0000 !important;
				border: 1px solid #DC0000 !important;
			}
			
			.layui-inline,
			img {
				vertical-align: initial;
			}
			
			.layui-btn,
			.layui-edge,
			.layui-inline,
			img {
				vertical-align: initial;
			}
			
			.product-sett:hover {
				color: white !important;
			}
		</style>
		<script src="/public/phone/js/rem.js"></script>
		<script src="/public/phone/lb/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/js/iscroll.js"></script>
		<script src="/public/phone/layer/layer.js"></script>
	</head>

	<body>
		<header class="lpk_head clearfix tzq_head">
			<div class="fl left">
				<a onclick="javascript:history.back(-1);">
					<!--<font class="glyphicon glyphicon-menu-left"></font>-->
				</a>
			</div>
			<div class="fl center">
				购物车
			</div>
			<div class="fr right">
				<a href="javascript:;">
					<font class="">管理</font>
				</a>
			</div>
			<input type="hidden" id="member_type" name="" value="<?php echo ($member_type); ?>">
		</header>
		<div class="" style="height: 1.307rem; width: 100%;"></div>

		<div class="body">
			<!--product-xz-->
			<input type="hidden" id="member_id" name="" value="<?php echo ($member_id); ?>">
			<div id="wrapper" style="bottom: 100px;">
				<div id="scroller">
					<section class="news-list">

					</section>
					<div class="pull-loading">
						上拉加载
					</div>
				</div>
			</div>

			<div class="product-js">
				<div class="product-al">
					<div class="product-all">
						<em class=""></em>
					</div>
					<div class="all-xz"><span class="product-all-qx">全选</span>
						<div class="all-sl" style="display: none;">(<span class="product-all-sl">0</span>)</div>
					</div>
				</div>
				<a class="product-sett " id="lpkdel">立即付款</a>
				<div class="all-product">
					<span class="all-product-a all-product-a1">¥&thinsp;<span class="all-price">0.00</span></span>
					<span class="all-product-a all-product-a2" id='lpkyc' style="display: none;">移入收藏夹</span>
				</div>
			</div>

		</div>
		<!--购物车空-->
		<div class="kon-cat">
			<div class="catkon">
				<div class="kon-box">
					<div class="kon-hz">
						<img src="/public/phone/img/cart-air.png" />
						<span class="kon-wz">购物车什么都没有</span>
						<a href="index.html" class="kon-lj">去逛逛</a>
					</div>
				</div>
			</div>
		</div>
		<div class="" style="height: 2rem;width: 100%;"></div>
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
	</body>
	<script src="/public/phone/js/shoppingcart.js" type="text/javascript" charset="utf-8"></script>

</html>