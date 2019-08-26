<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>工作</title>
		<link rel="stylesheet" type="text/css" href="/public/phone/css/public.css" />
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
				工作
			</div>
			<div class="right">
				<a href="/Work/show.html" style="color: #FF2727;">上传</a>
			</div>
		</header>
		<div class="indexHeadBg"></div>
		<div id="wrapper" style="display: block" class="lpkwrapper" data-flag="true">
			<div id="scroller">
				<section class="lpkJobs">

				</section>
				<div class="lpk">
					上拉加载
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(function() {
			pullOnLoad();
		})
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
		var num = 5;
		var page = 1;
		function pullOnLoad() {
			if($('#wrapper').data('flag') === false) {
				return
			}
			$('#wrapper').data('flag', false)
			setTimeout(function() {
				$.ajax({
					url: '/app.php/Work/get_data',
					type: "get",
					dataType: 'json',
					data: {
						CurrentPage: page,
						paginalNum: num,
					},
					success: function(data) {
						if(data.code !== 200) {
							var dataArr = data.data;
							console.log(data);
							var result = "";
							if(dataArr.length > 0) {
								for(var i = 0; i < dataArr.length; i++) {
									var row = data.data[i];
									//console.log(row);
									result += `
										<div class="item">
											<div class="top">
												<p class="left"><img src="/${row.headportrait}" /></p>
												<p class="right">
													<span class="h3">${row.nickname}</span>
													<span class="h4">${row.create1_time}</span>
												</p>
											</div>
											<div class="text">
												上传了工作记录
											</div>
											<div class="img">
												<p><img src="${row.picture}"/></p>
												<p><img src="${row.picture}"/></p>
												<p><img src="${row.picture}"/></p>
											</div>
										</div>
								     `
								}
								 $("#scroller section").append(result);
								page++;
								myscroll.refresh();
							} else {
								$(".lpk").text("您还没有上传任何工作");
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


	</script>

</html>