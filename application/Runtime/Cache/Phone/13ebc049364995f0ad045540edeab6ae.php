<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
        <title>佣金</title>
        <link rel="stylesheet" type="text/css" href="/public/phone/css1/public.css" />
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
                佣金
            </div>
            <div class="right">
            </div>
        </header>
        <div class="indexHeadBg"></div>
        <section class="lpkCommission">
            <div class="left">
                <p>佣金 <span><?php echo ($member["commission"]); ?></span> 元</p>
            </div>
            <div class="right">
                <a href="/MyWithdrawal.html">申请提现</a>
            </div>
        </section>

        <section class="lpkRecord">
            <ul>
                <li class="active" data-lpk='false'><span >收益记录</span></li>
                <li data-lpk='true'><span >提现记录</span></li>
            </ul>
        </section>
        
        <div id="wrapper" style="display: block;top: 21rem;" class="lpkwrapper" data-flag="true">
            <div id="scroller">
                <section class="lpkTransaction">

                </section>
                <div class="lpk">
                    上拉加载
                </div>
            </div>
        </div>
        <div id="wrapper1" class="lpkwrapper" style="top: 21rem;" data-flag="true">
            <div id="scroller1">
                <section class="lpkTransaction">

                </section>
                <div class="lpk1">
                    上拉加载
                </div>
            </div>
        </div>
        

    </body>
    
    <script type="text/javascript">
        $(function() {
            pullOnLoad();
            $('.lpkRecord ul li').click(function() {
                $(this).addClass('active').siblings().removeClass('active');
                var index = $('.lpkRecord ul li').index(this);
                $('.lpkwrapper').eq(index).show().siblings('.lpkwrapper').hide();
                var status = $(this).attr('data-lpk');
                if(status == 'false') {
                    $(this).attr('data-lpk','status');
                }else if(status == 'true'){
                    pullOnLoad1();
                    $(this).attr('data-lpk','status');
                }
            })
        })
        var myscroll = new iScroll("wrapper", {
            onScrollMove: function() {
                if(this.y < this.maxScrollY) {
                    $(".lpk").html("释放加载");
                    $(".lpk").addClass("loading");
                } else {
                    $(".lpk").html("上拉加载");
                    $(".lpk").removeClass("loading");
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
        var num = 3;
        var page = 1;

        function pullOnLoad() {
            if($('#wrapper').data('flag') === false) {
                return
            }
            $('#wrapper').data('flag', false)
            setTimeout(function() {
                $.ajax({
                    url: '/app.php/MyCommission/getData',
                    type: "get",
                    dataType: 'json',
                    data: {
                        CurrentPage: page,
                        paginalNum: num,
                    },
                    success: function(data) {
                        if(data.code !== 200) {
                            console.log(data)
                            var dataArr = data.data.rows;
                            var result = "";
                            if(dataArr.length > 0) {
                                for(var i = 0; i < dataArr.length; i++) {
                                	//console.log(data)
                            		var row = data.data.rows[i];
                                    result += `
                                     <div class="item">
                                        <p class="img"><img src="/public/phone/img1/head.png"/></p>
                                        <p class="text">
                                            <span class="h3">${row.source}</span>
                                            <span class="h4">${row.create_time}</span>
                                        </p>
                                        <p class="money">${row.type}${row.commission}</p>
                                    </div>
                                     `
                                }
                               $("#scroller section").append(result);
                                page++;
                                myscroll.refresh();
                            } else {
                                $(".lpk").text("没有了");
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

        var Record = new iScroll("wrapper1", {
            onScrollMove: function() {
                if(this.y < this.maxScrollY) {
                    $(".lpk1").html("释放加载");
                    $(".lpk1").addClass("loading");
                } else {
                    $(".lpk1").html("上拉加载");
                    $(".lpk1").removeClass("loading");
                }
            },
            onScrollEnd: function() {
                if($(".lpk1").hasClass('loading')) {
                    $(".lpk1").html("加载中...");
                    pullOnLoad1();
                }
            },
            onRefresh: function() {
                $('.lpk1').html("上拉加载");
            }
        });
        var num1 = 3;
        var page1 = 1;

        function pullOnLoad1() {
            if($('#wrapper1').data('flag') === false) {
                return
            }
            $('#wrapper1').data('flag', false)
            setTimeout(function() {
                $.ajax({
                    url: '/app.php/MyWithdrawal/getData',
                    type: "get",
                    dataType: 'json',
                    data: {
                        CurrentPage: page1,
                        paginalNum: num1,
                    },
                    success: function(data) {
                        if(data.code !== 200) {
                            console.log(data)
                            var dataArr = data.data;
                            var result = "";
                            if(dataArr.length > 0) {
                                for(var i = 0; i < dataArr.length; i++) {
                                	var row = data.data[i];
                                    result += `
                                       <div class="item">
                                        <p class="img"><img src="/public/phone/img1/head.png"/></p>
                                        <p class="text">
                                            <span class="h3">${row.card_owner}</span>
                                            <span class="h4">${row.create_time}</span>
                                        </p>
                                        <p class="money">-${row.money}</p>
                                    </div>
                                     `
                                }
                                 $("#scroller1 section").append(result);
                                page1++;
                                Record.refresh();
                            } else {
                                $(".lpk1").text("没有了");
                            }
                        } else {
                            layer.msg(data.msg)
                        }
                        $('#wrapper1').data('flag', true)
                    },
                    error: function() {
                        console.log("出错了");
                    }
                });
                Record.refresh();
            }, 1000);
        }
    </script>

</html>