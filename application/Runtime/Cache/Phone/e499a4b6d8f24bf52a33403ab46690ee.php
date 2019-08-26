<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>提现</title>
		<link rel="stylesheet" type="text/css" href="/public/phone/css1/public.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/layer/mobile/need/layer.css" />
		<link rel="stylesheet" type="text/css" href="/public/phone/css1/more.css" />
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
				提现
			</div>
			<div class="right">
			</div>
		</header>
		<div class="indexHeadBg"></div>

		<section class="logInForm">
			<form>
				 <!--<div class="lpk_m_item">
					<p class="ye">可提现金额 : <span>￥<font><?php echo ($member["commission"]); ?></font>元</span></p>
					<p class="ye">提现额度 : <span>￥<font><?php echo ($member["withdrawal_limit"]); ?></font>元</span></p>
				</div> -->
				<div class="item">
					<p class="L">持卡人：</p>
					<p class="R"><input type="text" name="card_owner" id="card_owner" value="" placeholder="请输入持卡人姓名"></p>
				</div>
				<div class="item">
					<p class="L">银行：</p>
					<p class="R"><input type="text" name="open_bank" id="open_bank" value="" placeholder="请输入手机号"></p>
				</div>
				<div class="item">
					<p class="L">银行卡：</p>
					<p class="R"><input type="text" name="bank_card" id="bank_card" value="" placeholder="请输入银行卡卡号"></p>
				</div>
				<div class="item">
					<p class="L">金额：</p>
					<p class="R"><input type="text" name="money_sum" id="money_sum" value="" placeholder="请输入提现金额"></p>
				</div>
				
				 <div class="item">
					<p class="L">手机号：</p>
					<p class="R"><input type="text" name="phone" id="phone" value="" placeholder="请输入手机号"></p>
				</div>
				

				<!--<div class="item item5">
					<p class="L">验证码：</p>
					<p class="R"><input type="" name="" id="" value=""></p>
					<p class="posi">
						<input type="button" class="obtain generate_code" value=" 获取验证码" onclick="settime(this);">  
					</p>
				</div> -->

				<div class="itembtn">
					<a href="javascript:;" id="tixian">
						确认提现
					</a>
				</div>

			</form>
		</section>
	</body>
	<script type="text/javascript">
		var countdown = 60;
		function settime(val) {
			if(countdown == 0) {
				val.removeAttribute("disabled");
				val.value = "获取验证码";
				countdown = 60;
				return false;
			} else {
				val.setAttribute("disabled", true);
				val.value = "重新发送(" + countdown + ")";
				countdown--;
			}
			setTimeout(function() {
				settime(val);
			}, 1000);
		}
	</script>
	<script type="text/javascript">
		$(function(){
			$('#tixian').click(function(){
				var card_owner = $("#card_owner").val();
				var bank_card = $("#bank_card").val();
				var money_sum = $("#money_sum").val();
				var phone = $("#phone").val();
				var open_bank = $("#open_bank").val();
				if(!/^[\u4e00-\u9fa5]{2,4}$/.test(card_owner)){
					layer.msg('姓名格式有误');
				}else if(!/\d{10,19}/.test(bank_card)){
					layer.msg('银行卡号格式有误');
				}else if(money_sum < 100){
					layer.msg('提现金额大于100');
				}else if(!/^[1][3,4,5,7,8][0-9]{9}$/.test(phone)){
					layer.msg('手机格式有误');
				}else{
					$.ajax({
					type:"post",
					url:"/app.php/MyWithdrawal/add",
					async:true,
					dataType : "json",
					data:{"card_owner":card_owner,"bank_card":bank_card,"money":money_sum,"phone":phone,"open_bank":open_bank},
					success:function(data){
						if(data.code==200){
							layer.msg(data.msg);
							window.location.href="<?php echo U('MyCommission/index');?>"
							
							
						}else{
							layer.msg(data.msg)
						}
					}
				});
				}
				
				
				
				
				
				
				
				
				
//				layer.msg("您的余额不足，请确认");
			})
		})
	</script>
</html>