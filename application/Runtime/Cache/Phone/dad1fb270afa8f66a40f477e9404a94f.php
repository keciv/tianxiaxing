<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="/public/phone/css/lpk.css" />
    <link rel="stylesheet" type="text/css" href="/public/phone/lb/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/public/phone/css/reset.css" />
    <script src="/public/phone/js/jquery-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/public/phone/lb/js/bootstrap.js" type="text/javascript" charset="utf-8"></script>
    <script src="/public/phone/layer/layer.js"></script>
    <script src="/public/phone/js/rem.js" type="text/javascript" charset="utf-8"></script>
   
    <script type="text/javascript">
        $(function(){
            $('#login').click(function(){
                var username = $('#username').val();
                var password = $('#password').val();
                if(!username)
                {
                    layer.msg("请输入用户名");
                    return;
                }
                if(!username)
                {
                    layer.msg("请输入密码");
                    return;
                }
                $.ajax({
                    url:'/app.php/login/login',
                    data:{username:username,password:password},
                    type:'post',
                    dataType:'json',
                    success:function(data){
                        if(data.code=="200")
                        {
                            layer.msg(data.msg,{time:2000},function(){
                                window.location.href = "/index.php";
                            })
                            // $.ajax({
                            //     url:'/app.php/Winxinsq/winxinsq',
                            //     data:{},
                            //     type:'post',
                            //     dataType:'jsonp',
                            //     success:function(data){
                            //         alert(123)
                            //         layer.msg(data.msg,{time:2000},function(){
                            //             window.location.href = "/index.php";
                            //         })
                            //     }
                            // })
                        }
                        else
                        {
                            layer.msg(data.msg);
                        }
                    }
                })
            })
        })
    </script>
</head>

<body>
    <div class="lpk_mportant">
        <h3>用户登录</h3>
        <form action="" method="">
            <div class="top">
                <input type="tel" name="" id="username" value="" placeholder="手机号码" maxlength="11" />
            </div>
            <div class="top">
                <input type="password" name="" id="password" value="" placeholder="登录密码"  />
            </div>
            <div class="bottom">
                <input type="button" name="" id="login" value="登录" />
            </div>
        </form>
        <p class="clearfix lpk_zc">
            <!-- <span class="fl"><a href="javascript:;">忘记密码？</a></span> -->
            <span class="fr"><a href="/Register.html">我要注册</a></span>
        </p>
    </div>
</body>

</html>