<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<title>车乐友后台管理系统</title>
<LINK rel="Bookmark" href="/public/css/favicon.ico" >
<LINK rel="Shortcut Icon" href="/public/css/favicon.ico" />
<link href="/public/static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="/public/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<link href="/public/static/h-ui.admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="/public/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />
<style>
.btn.size-L {
    padding: 8px 140px;
}
.btn-success {
    color: #fff;
    background-color: #348DB7;
    border-color: #348DB7;
}
.btn-success:hover {
    color: #fff;
    background-color: #1F6E93;
    border-color: #1F6E93;
}
.row {
    box-sizing: border-box;
    margin-left: 0;
    margin-right: 0;
}
</style>
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<!--<div class="header" style="height: 132px; background: #426374 url('/public/admin/image/logotop.jpg') no-repeat;">

</div>-->
<div class="header"></div>
<div class="loginWraper">
  <div id="loginform" class="loginBox"  style="padding-top:20px; ">
    <div class="tit">登陆信息网后台管理</div>
    <form class="form form-horizontal" action="/admin.php/Login/check" method="post">
      <div class="row cl">
        <label class="lable" >管理员：<!--<i class="Hui-iconfont">&#xe60d;</i>--></label>
        <div class="formControls col-xs-8">
          <input id="" name="username" type="text" placeholder="帐号" class="input-text size-L" value="<?php echo $user;?>">
          <span class="tips1" style="position: absolute;right: 20px;top: 10px;"></span>
        </div>
      </div>
      <div class="row cl">
        <label class="lable" >密&nbsp;&nbsp;&nbsp;码：<!--<i class="Hui-iconfont">&#xe60e;</i>--></label>
        <div class="formControls col-xs-8">
          <input id="Password1" name="password" type="password" placeholder="密码" class="input-text size-L" value="<?php echo $pass;?>">
        </div>
      </div>
    
    
      <div class="row cl">
        <label class="lable">验证码：</label>
        <div class="formControls col-xs-8">
          <input name="code" class="input-text size-L" type="text" placeholder="验证码" value="" style="width:150px;">
          <img src="/admin.php/Login/verify" onclick='this.src=this.src+"?c="+Math.random()' style="    width: 90px;">
          <span class="tips" style="position: absolute;right: 120px;top: 10px;"></span>
           </div>
      </div>
     
      <div class="row cl" style="margin-top:40px;">
        <div class="formControls col-xs-8 col-xs-offset-3" style="margin-left: 7%;">
        	<input type="hidden" name="do" value="login"/> 
          <input  type="submit" name="dosubmit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;"/>
          <!--<input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">-->
        </div>
      </div>
    </form>
  </div>
</div>
<div class="footer">Copyright 2015-2017 www.tygytc.com All Rights Reserved &nbsp;&nbsp; 技术支持：<a href="http://www.tygytc.com/" target="_blank" style="color:#eee;">太原国远天成网络科技有限公司</a></div>
<script type="text/javascript" src="/Public/js/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/static/h-ui/js/H-ui.js"></script> 
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?080836300300be57b7f34f4b3e97d911";
        var s = document.getElementsByTagName("script")[0]; 
        s.parentNode.insertBefore(hm, s);
    })();
    var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F080836300300be57b7f34f4b3e97d911' type='text/javascript'%3E%3C/script%3E"));
</script>

<script>
    $(function(){
        var flag=false;
        //当元素失去焦点时触发一个blur事件
        $("input[name='username']").blur(function(){
            //text() html() css()
            //获得匹配元素的当前值(相当于value里面的值)
            var val = $(this).val();
            if(val==''){
                $(".tips1").text("不能为空").css("color","red");
                return false;
            }else{
                $(".tips1").text("").css("color","red");
                return true;
            }
		
        });
	
	
    })	


	
	
    })
</script>
<script>

    $(function(){
        var flag=false;
        $("input[name='dosubmit']").click(function(){
            //text() html() css()
            //获得匹配元素的当前值(相当于value里面的值)
		
            var val = $("input[name='code']").val();
	
            if(val==''){
                $(".tips").text("不能为空！").css("color","red");
                return false;
            }else{
                $(".tips").text("");
            }
        });
    })
</script>
</body>
</html>