<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>地址管理</title>
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
			.layui-layer-btn a {
				font-size: 14px;
			}

			.layui-layer-btn .layui-layer-btn0 {
				background: #f7911d !important;
				border: 1px solid #f7911d !important;
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

	</head>

	<body>
		<header class="lpk_head clearfix">
			<div class="fl left">
				<a href="/MyCenter.html">
					<font class="glyphicon glyphicon-menu-left"></font>
				</a>
			</div>
			<div class="fl center">
				管理收货地址
			</div>
			<div class="fr right">
				<a href="javascript:;">
					<!--<font class="xg">修改</font>-->
				</a>
			</div>
		</header>
		<div id="wrapper">
			<div id="scroller">
				<section>
				</section>
				<div class="pull-loading">
					上拉加载
				</div>
			</div>
		</div>
		<div class="add_">
			<a href="add_show.html">新增收货地址</a>
		</div>
		<div class="add_bg"></div>
	</body>

	<script type="text/javascript">
		var member_id = "<?php echo ($member_id); ?>";
		$(function() {
			pullOnLoad();
			var lpkData = location.href.split("?")[1];
			var linkid = lpkData.split("=")[1];
			if (linkid == 0) {
				//			默认
				$('#wrapper').on('click', '.lpk_address .del .left', function() {
					var id = $(this).parents('.lpk_address').attr('id');
					$.ajax({
						type: 'post',
						url: 'app.php/Address/SetDefault',
						dataType: 'json',
						data: {
							id: id,
							member_id: member_id
						},
						success: function(data) {
							if (data.code == "200") {
								layer.msg("设置成功", {
									time: 2000
								}, function() {
									window.location.href = 'Address.html';
								})
							} else if (data.code == "404") {
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
					$(this).children('span').addClass('active').parents('.lpk_address').siblings().find('.lpkmr').removeClass(
						'active');
				})
				//			删除
				$('#wrapper').on('click', '.del .re', function() {
					var id = $(this).parents('.lpk_address').attr('id');
					var remove = $(this).parents('.lpk_address');
					layer.confirm('确定要删除吗？', {
						title: false,
						closeBtn: false,
						shade: [0.6],
						btn: ['确定', "取消"],
						success: function(layero, index) {
							$(".layui-layer-btn0").on("click", function() {
								$.ajax({
									type: "post",
									url: "app.php/Address/delete",
									dataType: 'json',
									data: {
										id: id,
										member_id: member_id,
									},
									success: function(data) {
										if (data.code == "200") {
											layer.msg("删除成功", {
												time: 2000
											}, function() {
												window.location.href = 'Address.html';
											})
										} else if (data.code == "404") {
											layer.msg(data.msg, {
												time: 2000
											}, function() {
												window.location.href = "/login.html";
											});
										} else {
											layer.msg(data.msg);
										}
									}
								});

							})
						},
						end: function() {}
					})

				})

				//编辑 
				$('#wrapper').on('click', '.del .bj', function() {
					var id = $(this).parents('.lpk_address').attr('id');
					window.location.href = `add_show.html?id=${id}`;
				})

			} 
			else if (linkid == 1) {
				$('#wrapper').on('click', '.lpk_address', function() {
					var id = $(this).attr('id');
					var name = $(this).find('h4 font').text();
					var phone = $(this).find('h4 span').text();
					var address = $(this).find('p').text();
					window.location.href = encodeURI('SureOrder.html?back=5&id=' + id + '&name=' + name + '&phone=' + phone +
						'&address=' + address);
				})
			}
		})
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
					pullOnLoad();
				}
			},
			onRefresh: function() {
				$('.pull-loading').html("上拉加载");
			}
		});
		//上拉加载函数,ajax
		var num = 0;
		var page = 4; //每次加载4条
		var lpk = 1;

		function pullOnLoad() {
			setTimeout(function() {
				$.ajax({
					url: 'app.php/Address/getData',
					type: "get",
					dataType: 'json',
					data: {
						member_id: member_id,
						CurrentPage: lpk,
						paginalNum: page,
					},
					success: function(data) {
						if (data.code == "200") {
							console.log(data)
							var result = "";
							var dataArr = data.data;
							if (dataArr.length >0) {

								for (var i = num; i < dataArr.length; i++) {
									if (dataArr[i].is_default == 1) {
										result +=
											`
									    <div class="lpk_address" id=${dataArr[i].id}>
											<h4><font>${dataArr[i].name}</font><span class="fr">${dataArr[i].phone}</span></h4>
											<p>${dataArr[i].province}${dataArr[i].city}${dataArr[i].district}${dataArr[i].address}</p>
											<div class="del clearfix">
												<div class="fl left">
													<span class="glyphicon glyphicon-ok-sign active lpkmr"></span>默认地址
												</div>
												<div class="fr right re">
													<span class="glyphicon glyphicon-trash"></span>删除
												</div>
												<div class="fr right bj">
													<span class="glyphicon glyphicon-edit"></span>编辑
												</div>
											</div>
										</div>
									     `
									} else {
										result +=
											`
									    <div class="lpk_address" id=${dataArr[i].id}>
											<h4><font>${dataArr[i].name}</font><span class="fr">${dataArr[i].phone}</span></h4>
											<p>${dataArr[i].province}${dataArr[i].city}${dataArr[i].district}${dataArr[i].address}</p>
											<div class="del clearfix">
												<div class="fl left">
													<span class="glyphicon glyphicon-ok-sign lpkmr"></span>默认地址
												</div>
												<div class="fr right re">
													<span class="glyphicon glyphicon-trash"></span>删除
												</div>
												<div class="fr right bj">
													<span class="glyphicon glyphicon-edit"></span>编辑
												</div>
											</div>
										</div>
									     `
									}
								}
								$("#scroller section").append(result);
								lpk++;
								myscroll.refresh();
							} else {
								$(".pull-loading").text("没有了");
							}
						} else if (data.code == "404") {
							layer.msg(data.msg, {
								time: 2000
							}, function() {
								window.location.href = "/login.html";
							});
						} else {
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
	</script>

</html>