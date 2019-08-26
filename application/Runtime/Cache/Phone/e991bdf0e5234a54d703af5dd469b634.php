<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>上传</title>
		<link rel="stylesheet" type="text/css" href="/public/phone/css1/public.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/layer/mobile/need/layer.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/css1/style.css" />
		<script src="/public/phone/js/jquery-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/layer/layer.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/js1/rem.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/upload/jqueryForm.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/upload/jquery-form.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/phone/upload/myJS.js" type="text/javascript" charset="utf-8"></script>
	</head>

	<body>
		<header class="indexHead">
			<div class="left">
				<a onclick="javascript:history.back(-1);">
					<img src="/public/phone/img1/indexgo.png" />
				</a>
			</div>
			<div class="center">
				上传
			</div>
			<div class="right">
			</div>
		</header>
		<div class="indexHeadBg"></div>
		<section class="lpkUpload">
			<form  action="" method="" id="work" enctype="multipart/form-data" class="form form-horizontal">
				<div class="item clearfix">
					<label for="file1">
						<p><img src="/public/phone/img1/Upload1.png" id="img"/></p>
						<p class="B">上传广告图</p>
					</label>
					<label for="file2">
						<img src="/public/phone/img1/Upload2.png"  id="hiddenViedo"/>
						<p id="viedotext"></p>
						<p class="B" id="viedotext1">上传小视频</p>
					</label>
					
					<input type="file" name="img" id="file1"  onchange="chooseImg(this)"/>
					<p style="display: none;" id="dataUrl" data-url="<?php echo U('work/upload');?>"></p>
					<input type="file" name="viedo" id="file2" value="" />
					<p style="display: none;" id="dataUrl2" data-url="<?php echo U('work/viedo');?>"></p>
				</div>
				<div class="lpkimgzs">
					<img src="/public/phone/img1/car.png" id="bigimg"/>
				</div><br /><br />
				<p>注：上传广告图要按要求车辆斜角45度（能看到 </p>
				<p>车牌和广告图），和广告图正面图片。</p>
				<input type="button" name="" id="sure" value="确认" class="lpkBtn" />
			</form>
		</section>
		<script type="text/javascript">
			//work图片
			function chooseImg(file) { 
				//console.log(file)
				var dataUrl = $("#dataUrl").attr("data-url");
				upload(dataUrl,'file1','work','work/pic');	
		
			}
			//work视频
			$("#file2").change(function(file){
				var dataUrl = $("#dataUrl2").attr("data-url");
				uploadViedo(dataUrl,'file2','work','work/mp4');	
			})
			
			//提交
			
			$('#sure').click(function(){
				var video = $("#dataUrl2").text();
				var picture = $("#img").attr("src");
				if(video != "" && picture.length >40){
					$.ajax({
						type:"post",
						url:"/app.php/Work/add",
						async:true,
						dataType : "json",
						data:{video:video,picture:picture},
						success:function(data){
							if(data.code == 200){
								layer.msg("上传成功");
								window.location.href="<?php echo U('work/index');?>"
							}else{
								layer.msg("上传失败");
							}
								
							
						}
					});
				}else{
					layer.msg("请上传图片和视频之后，再进行此操作");
				}
				
			})
			
			
			
		
			
		</script>
	</body>

</html>