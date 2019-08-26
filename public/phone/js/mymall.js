var login = {
    last_url: "",
    submit_url: "",
    username: {},
    password: {},
    login : function(){
        // console.log("登陆进行时");
        var username = login.username.val();
        var password = login.password.val();
        if (username.length <= 0) {
            layer.msg("请输入账号");
            return;
        }
        if (password.length <= 0) {
            layer.msg("请输入密码");
            return;
        }
        $.ajax({
            url: login.submit_url,
            data: { username: username, password: password },
            type: 'post',
            success: function (msg) {
                if (msg == "ok") {
                    window.location.href = login.last_url;
                    return;
                }
                if (msg == "error") {
                    layer.msg("用户名或密码错误");
                    return;
                }
                if (msg == "member_null") {
                    layer.msg("该用户不存在，请注册后再登陆");
                    return;
                }
                if (msg == "username_null") {
                    layer.msg("请输入账号",{time:2000},function(){
                        login.username.val("").focus();
                    });
                    return;
                }
                if (msg == "password_null") {
                    layer.msg("请输入密码",{time:2000},function(){
                        login.password.val("").focus();
                    });
                    return;
                }
                if (msg == "no_audit") {
                    layer.msg("您的账号尚未审核通过，请耐心等待或联系客服");
                    return;
                }
            }
        })
    } 
}
var register = {
    parameter:{},
    submit_url: "",
    register:function(){
        var parameter = {};
        for(var i=0;i<register.parameter.length;i++)
        {
            var obj = register.parameter[i];
            if(register.verify(obj))
            {
                var key = obj.attr('id');
                parameter[key] = obj.val();
            }
            else
            {
                return false;
            }
        }
        var url = register.submit_url;
        
        register.submit(url, parameter);
    },
    verify:function(obj){
        if(!obj.val())
        {
            var caveat = obj.attr('placeholder');
            if(caveat.length>0)
            {
                layer.msg(caveat);
                return false;
            }
            return true;
        }
        return true;
    },
    submit:function(url, parameter){
        $.ajax({
            url: url,
            data: parameter,
            type:'post',
            success: function (msg) {
                $('#img_code').click();
                if (msg == "ok"){
                    layer.msg("恭喜，注册成功",{icon:1},function(){
                        window.location.href = "go_pay.html";
                    });
                }
                if (msg == "error") {
                    layer.msg("注册时出错，请重新注册");
                    return;
                }
                if (msg == "phone_code") {
                    layer.msg("手机号验证码错误");
                    return;
                }
                if (msg == "img_code") {
                    layer.msg("验证码错误，请重新输入");
                    return;
                }
                if (msg == "inviter_error") {
                    layer.msg("邀请码错误或不存在，请确认");
                    return;
                }
                if (msg == "inviter_null") {
                    layer.msg("邀请人不存在，请确认");
                    return;
                }
                if (msg == "overstep") {
                    layer.msg("该推荐人直推人数已满，请换一个推荐人");
                    return;
                }
                if (msg == "buwanzheng") {
                    layer.msg("请输入完整信息后再注册");
                    return;
                }
                if(msg=="have")
                {
                    layer.msg("该手机号已经注册，请登陆",{time:2000},function(){
                        window.location.href = "/Login.html";
                    });
                }
            }
        })
    }
}
var MobileCode = {
    reg : /^1[3|4|5|7|8]\d{9}$/,
    countdown : 60,
    phone_obj : {},
    code_obj : {},
    Timing_obj : {},
    verify_url : "",
    settime : function(){
        if (MobileCode.countdown == 0) {
            MobileCode.Timing_obj.removeAttr("disabled");
            MobileCode.Timing_obj.val("获取验证码");
            MobileCode.countdown = 60;
            return;
        } 
        else{
            MobileCode.Timing_obj.val("重新发送(" + MobileCode.countdown + ")");
            MobileCode.countdown--;
        }
        setTimeout(function () {
            MobileCode.settime();
        }, 1000);
    },
    send : function(){
        //console.log("ok");
        //console.log(MobileCode.Timing_obj);
        MobileCode.Timing_obj.attr("disabled", true);
        var phone = MobileCode.phone_obj.val();
        if (phone.length <= 0 || !MobileCode.reg.test(phone)) {
            layer.msg("请输入正确的手机号");
            MobileCode.Timing_obj.removeAttr("disabled");
            return;
        }
        $.ajax({
            url: 'MobileCode/send',
            data: { phone: phone },
            type: 'post',
            success: function (msg) {
                //MobileCode.settime();
                if (msg == "ok") {
                    layer.msg("验证码已发送，请查看",{icon:1},function(){
                        MobileCode.settime();
                    });
                }
                else if(msg=="phone_error")
                {
                    layer.msg("请输入正确的手机号",{icon:0},function(){
                        MobileCode.Timing_obj.removeAttr("disabled");
                    });
                }
                else if(msg=="error"){
                    layer.msg("发送失败，请重新发送",{icon:0},function(){
                        MobileCode.Timing_obj.removeAttr("disabled");
                    });
                }
            }
        })
    },
    verify : function(){
        var phone = MobileCode.phone_obj.val();
        var code = MobileCode.code_obj.val();
        $.ajax({
            url:'MobileCode/verify',
            data:{phone:phone,code:code},
            type:'post',
            success:function(msg){
                if(msg=="ok")
                {
                    if(MobileCode.verify_url.replace(/(^\s*)|(\s*$)/g, "").length != 0)
                    {
                        window.location.href = MobileCode.verify_url;
                    }
                    else
                    {
                        return true;
                    }
                }
                if(msg=="code_error")
                {
                    layer.msg("验证码错误，请重新输入",{icon:0},function(){
                        MobileCode.phone_obj.val("").focus();
                    });
                    return false;
                }
                if(msg=="phone_null")
                {
                    layer.msg("请输入手机号",{icon:0},function(){
                        MobileCode.phone_obj.val("").focus();
                    });
                    return false;
                }
                if(msg=="code_null")
                {
                    layer.msg("请输入验证码",{icon:0},function(){
                        MobileCode.code_obj.val("").focus();
                    });
                    return false;
                }
            }
        })
    }
}
var load_list = {
    //数据来源
    url: "",
    //参数
    parameter: {},
    //加载字符串
    info_str: "",
    //字符串中的变量
    info_name: {},
    //变量值
    info_value: {},
    //加载内容的父标签
    container: {},
    //需绑定事件的标签
    bind_event:{},
    sover: 0,
    finished: 0,
    load:function(callback){
        var that = this;
        if($(".loadmore").length==0)  
        {  
            var txt='<div class="clearfix"></div><div class="loadmore"><span class="loading"></span>加载中..</div>';  
            $("#info_list").parent('div').append(txt);
        }
        if(load_list.finished == 0 && load_list.sover == 0) {
            var nDivHight = $(window).height(); //可视区域的高度
            var nScrollHight = document.body.scrollHeight;  //滚动内容的高度
            var nScrollTop = $(window).scrollTop();   //滚动条的高度
            
            //滚动条到底部时候触发的条件
            if(nScrollTop + nDivHight >= nScrollHight){
                load_list.finished = 1;
                $.ajax({
                    url:load_list.url,
                    data:load_list.parameter,
                    type:'post',
                    dataType:'json',
                    success:function(data){
                        if(data.status=="ok")
                        {
                            // console.log("成功获取数据");
                            var result="";

                            for(var i = 0;i<data.rows.length;i++)
                            {
                                var row = data.rows[i];
                                var new_value = load_list.info_value;
                                for(var j = 0;j<load_list.info_name.length;j++)
                                {
                                    var name = load_list.info_name[j];
                                    new_value[name] = row[name];
                                }
                                // console.log(new_value);
                                // console.log(load_list.info_str);
                                result+=load_list.info_str.format(new_value);
                            }

                            load_list.container.append(result);

                            load_list.parameter.CurrentPage ++ ;
                            load_list.finished = 0;
                            callback(true);
                            load_list.load(function(){});
                        }
                        else if(data.status=="null")
                        {
                            // callback(false);
                            load_list.loadover();
                        }
                        else if(data.status=="login_null")
                        {
                            window.location.href = "login.html";
                        }
                    }
                })
            }
        }
    },
    loadover:function(){
        load_list.sover = 1;
        $(".loadmore").remove();
        var txt = '<div class="clearfix"></div><div class="loadover "><span>Duang～到底了</span></div>';
        $("#info_list").parent('div').append(txt);  
    },
    scroll:function(callback){
        if(load_list.sover==0)
        {
            load_list.load(function(result){
                callback(result);
            });  
        }
    }
}
String.prototype.format = function() {  
    if(arguments.length == 0)
    {
        return this;
    }
    var param = arguments[0];
    var s = this;
    if(typeof(param) == 'object') {
        for(var key in param)
        s = s.replace(new RegExp("\\{" + key + "\\}", "g"), param[key]);  
        return s;  
    } else {  
        for(var i = 0; i < arguments.length; i++)  
        s = s.replace(new RegExp("\\{" + i + "\\}", "g"), arguments[i]);  
        return s;  
    } 
}
var Password = {
    old_pwd : {},
    new_pwd : {},
    repeat_pwd : {},
    edit: function(){
        var old_password = Password.old_pwd.val();
        var password = Password.new_pwd.val();
        var passwordRepeat = Password.repeat_pwd.val();
        if(Password.verify(old_password,password,passwordRepeat))
        {
            var url = "Password/edit";
            var parameter = {old_password:old_password,password:password,passwordRepeat:passwordRepeat};
            Password.submit(url, parameter);
        }
    },
    reset: function(){
        var password = Password.new_pwd.val();
        var passwordRepeat = Password.repeat_pwd.val();
        if(Password.verify("123456",password,passwordRepeat))
        {
            var url = "Password/reset";
            var parameter = {password:password,passwordRepeat:passwordRepeat};
            Password.submit(url, parameter);
        }
    },
    verify: function(old_password,new_password,passwordRepeat){
        if(old_password.length<=0)
        {
            layer.msg("请输入原密码",{time:1500},function(){
                Password.old_pwd.focus();
            });
            return false;
        }
        if(new_password.length<=0)
        {
            layer.msg("请输入新密码",{time:1500},function(){
                Password.new_pwd.focus();
            });
            return false;
        }
        if(passwordRepeat.length<=0)
        {
            layer.msg("请输入确认密码",{time:1500},function(){
                Password.repeat_pwd.focus();
            });
            return false;
        }
        return true;
    },
    submit:function(url,parameter){
        $.ajax({
            url:url,
            data:parameter,
            type:'post',
            success:function(msg){
                if(msg=="ok")
                {
                    layer.msg("设置成功",{icon:1},function(){
                        window.location.href = "login.html";
                    })
                }
                if(msg=="login_null")
                {
                    layer.msg("您尚未登陆或登陆已过期",function(){
                        window.location.href = "login.html";
                    })
                }
                if(msg=="phone_null")
                {
                    layer.msg("您的手机号验证码不正确，请确认",function(){
                        window.location.href = "login.html";
                    })
                }
                if(msg=="old_pwd_null")
                {
                    layer.msg("请输入原密码",function(){
                        Password.old_pwd.focus();
                    })
                }
                if(msg=="new_pwd_null")
                {
                    layer.msg("请输入新密码",function(){
                        Password.new_pwd.focus();
                    })
                }
                if(msg=="repeat_pwd_null")
                {
                    layer.msg("请输入确认密码",function(){
                        Password.repeat_pwd.focus();
                    })
                }
                if(msg=="no_alike")
                {
                    layer.msg("新密码两次输入不一致，请重新输入",function(){
                        Password.repeat_pwd.val("").focus();
                    })
                }
                if(msg=="member_null")
                {
                    layer.msg("用户不存在，请注册",function(){
                        window.location.href = "Register.html";
                    })
                }
                if(msg=="pwd_error")
                {
                    layer.msg("密码输入错误，请输入正确的密码",function(){
                        Password.old_pwd.val("").focus();
                    })
                }
            }
        })
    }
}
var upload = {
    url: "",
    file: {},
    form: {},
    save_path: "",
    submit: function(callback){
        if(upload.verify(upload.file))
        {
            var fileName = upload.file.split("\\"); //这里要将 \ 转义一下
            fileName = fileName[fileName.length - 1];
            //shangchuan(url, fileID, formID, 'public/upload/'+filePath+"/");
        }
    },
    verify: function(file){

    }
}
var Manage = {
    url: "",
    parameter:{},
    add:function(callback){
        var add_url = Manage.url;
        var parameter = Manage.parameter;
        Manage.submit(add_url,parameter,function(msg){
            callback(msg);
        });
    },
    edit:function(callback){
        var edit_url = Manage.url;
        var parameter = Manage.parameter;
        Manage.submit(edit_url,parameter,function(msg){
            callback(msg);
        });
    },
    delete:function(callback){
        layer.confirm("确认要删除吗，删除后不能恢复", { title: "删除确认" },function(){
            var del_url = Manage.url;
            var parameter = Manage.parameter;
            Manage.submit(del_url,parameter,function(msg){
                callback(msg);
            });
        })
    },
    set_default:function(callback){
        var set_url = Manage.url;
        var parameter = Manage.parameter;
        Manage.submit(set_url,parameter,function(msg){
            callback(msg);
        });
    },
    submit:function(url,parameter,callback){
        $.ajax({
            url: url,
            data: parameter,
            type: 'post',
            success:function(msg){
                if(msg=="ok")
                {
                    layer.msg("操作成功");
                    callback("ok");
                    return;
                }
                if(msg=="error")
                {
                    layer.msg("操作失败，请重新操作");
                    callback("ok");
                    return;
                }
                if(msg=="login_null")
                {
                    layer.msg("您尚未登陆或登陆已过期",{time:2000},function(){
                        window.location.href = "Login.html";
                    });
                    callback("ok");
                    return;
                }
                if(msg=="member_null")
                {
                    layer.msg("用户不存在，请确认",{time:2000},function(){
                        window.location.href = "register.html";
                    });
                    callback("ok");
                    return;
                }
                if(msg=="address_null")
                {
                    layer.msg("该地址不存在，请确认",{time:2000},function(){
                        window.location.href = "address.html";
                    });
                    callback("ok");
                    return;
                }
                if(msg=="data_error")
                {
                    layer.msg("请输入正确的数据");
                    callback("ok");
                    return;
                }
                if(msg=="not_enough")
                {
                    layer.msg("您的金额不足，请确认");
                    callback("ok");
                    return;
                }
                if(msg=="picture_null")
                {
                    layer.msg("请最少上传一张图片");
                    callback("ok");
                    return;
                }
            }
        })
    }
} 
//添加购 物车
function add_cart(id){
    var order_product = get_show_order_product();
    // console.log(order_product);
    $.ajax({
        url:'/phone.php/ShoppingCart/add',
        data:{order_product:order_product},
        type:'post',
        success:function(msg){
            if(msg=="ok")
            {
                layer.msg("恭喜，成功加入购物车");
            }
            if(msg=="error")
            {
                layer.msg("抱歉，加入购物车失败，请重新加入");
            }
            if(msg=="id_null")
            {
                layer.msg("请选择要加入购物车的商品");
            }
            if(msg=="no_login")
            {
                layer.msg("您尚未登陆或登陆已过期，请重新登陆",{time:2000},function(){
                    window.location.href = "/phone.php/Login.html";
                })
            }
        }
    })
}
//购物车 移除
function del_cart(id){
    $.ajax({
        url:'/phone.php/ShoppingCart/delete',
        data:{id:id},
        type:'post',
        success:function(msg){
            if(msg=="ok")
            {
                layer.msg("成功从购物车移除",{icon:1},function(){
                    location.reload();
                });
            }
            if(msg=="error")
            {
                layer.msg("抱歉，请重新移除不要的商品");
            }
            if(msg=="id_null")
            {
                layer.msg("请选择要移除的商品");
            }
        }
    })
}
//购物车 移除所有数据
function del_all_cart(){
    var id = "";
    $('[name="check_cart"]').each(function () {
        if (this.checked) {
            id += $(this).attr('biaoshi');
            id += ",";
            // console.log(id);
        }
    })
    id=id.substr(0, id.length - 1);
    if(id.length<=0)
    {
        layer.msg("请选择要删除的商品");
        return;
    }
    del_cart(id);
}
//购物车 选择复选框
function cart_check_one(){
    //记录清空
    $('#form_productInfo [name="order_product"]').val("");
    //判断哪些商品被选中
    get_select_cart();
}
//购物车 全选
function cart_check_all(obj){
    // console.log("haha");
    if (obj.checked) {
        $(':checkbox').each(function () {
            $(obj).prop("checked",true);
        })
        $('[name="check_cart"]').prop("checked",true);
        $('#isBuy').val("true");
        get_select_cart();
    }
    else {
        $(':checkbox').each(function () {
            $(obj).prop("checked",false);
        })
        $('#total_price').html("0.00");
        $('[name="check_cart"]').prop("checked",false);
        $('#isBuy').val("false");
        $('#form_productInfo [name="order_product"]').val("");
    }
}
//购物车 所有选中的数据
function get_select_cart(){
    var array = new Array();
    var zongjia = 0;
    var product_id = "";
    var num = 0;
    var order_product = new Array();
    $('[name="check_cart"]').each(function (index) {
        if (this.checked) {
            var biaoshi = $(this).attr('biaoshi');
            product_id = $('[name="product_'+biaoshi+'"]').val();
            num = $('[name=num_'+biaoshi+']').val();
            product_spec = $('[name=spec_'+biaoshi+']').html();

            xiaoji = $('[name=xiaoji_' + biaoshi+']').val();
            zongjia = parseFloat(zongjia) + parseFloat(xiaoji);
            // console.log(zongjia);
            var spec_obj = {};
            $(this).parents('.clearfix').find('.sku-line').each(function(index){
                if(index!=0)
                {
                    var str_spec = $(this).text();

                    var array_spec = str_spec.split("：");
                    var spec_name = array_spec[0];
                    var spec_value = array_spec[1];
                    spec_obj[spec_name] = spec_value;
                }
            })
            
            var product_info = {};
            product_info["id"] = product_id;
            product_info["spec"] = JSON.stringify(spec_obj);
            product_info["count"] = num;

            order_product.push(product_info);
        }

    })
    zongjia = zongjia.toFixed(2);
    // console.log(zongjia);
    $('#total_price').text(zongjia);
    var json_order_product = order_product;
    return JSON.stringify(json_order_product);
}
//购物车 数量加
function cart_add_num(obj){
    var biaoshi = $(obj).attr('biaoshi');
    var num = $('[name="num_'+biaoshi+'"]').val();
    var num_now = parseInt(num)+1;
    $('[name="num_'+biaoshi+'"]').val(num_now);
    var current_price = $('[name="current_price_'+biaoshi+'"]').html();
    var xiaoji = parseFloat(current_price) * num_now;
    $('[name="xiaoji_'+biaoshi+'"]').val(xiaoji);
    // console.log(xiaoji);
    get_select_cart();
}
//购物车 数量减
function cart_min_num(obj){
    var biaoshi = $(obj).attr('biaoshi');
    var num = $('[name="num_'+biaoshi+'"]').val();
    if(num<=1)
    {
        layer.msg("已经是最小值了");
        return;
    }
    var num_now = parseInt(num)-1;
    $('[name="num_'+biaoshi+'"]').val(num_now);
    var current_price = $('[name="current_price_'+biaoshi+'"]').html();
    var xiaoji = parseFloat(current_price) * num_now;
    $('[name="xiaoji_'+biaoshi+'"]').val(xiaoji);
    // console.log(xiaoji);
    get_select_cart();
}
//购物车 购买
function cart_buy(){
    var order_product = get_select_cart();
    $('[name="order_product"]').val(order_product);
    // $('[name="order_product"]').val(order_product);
    $('#form_productInfo').submit();
}
//添加收藏
function add_collection(obj,id){
    var scbtn = $(obj).children('.am-icon-fw');
    if($(scbtn).hasClass('am-icon-heart')){
       $.ajax({
            url:'/phone.php/MyCollection/delete',
            data:{id:id},
            type:'post',
            success:function(msg){
                if(msg=="ok")
                {
                    $(scbtn).removeClass('am-icon-heart');
                    $(scbtn).text(' 收藏');
                    layer.msg("取消收藏成功");
                }
                if(msg=="error")
                {
                    layer.msg("抱歉，操作失败，请重新操作");
                }
                if(msg=="login_null")
                {
                    layer.msg("您尚未登陆或登陆已过期，请重新登陆",{time:1000},function(){
                        window.location.href = "/phone.php/Login.html";
                    });
                }
                if(msg=="id_null")
                {
                    layer.msg("请选择要操作的商品");
                }
            }
        })
    }
    else{
        $.ajax({
            url:'/phone.php/MyCollection/add',
            data:{id:id},
            type:'post',
            success:function(msg){
                if(msg=="ok")
                {
                    $(scbtn).addClass('am-icon-heart');
                    $(scbtn).text(' 已收藏');
                    layer.msg("恭喜，成功收藏");
                }
                if(msg=="error")
                {
                    layer.msg("抱歉，收藏失败，请重新收藏");
                }
                if(msg=="login_null")
                {
                    layer.msg("您尚未登陆或登陆已过期，请重新登陆",{time:1000},function(){
                        window.location.href = "/phone.php/Login.html";
                    });
                }
                if(msg=="id_null")
                {
                    layer.msg("请选择要收藏的商品");
                }
            }
        })
    }
}
//订单 数量加
function order_add_num(obj){
    var biaoshi = $(obj).attr('biaoshi');
    var num = $('[name="num'+biaoshi+'"]').val();
    var num_now = parseInt(num)+1;
    var reserve = $('[name="reserve'+biaoshi+'"]').val();
    // console.log("reserve"+reserve);
    if(num_now>reserve)
    {
        layer.msg("库存不足");
        return
    }
    $('[name="num'+biaoshi+'"]').val(num_now);
    var current_price = $('[name="current_price'+biaoshi+'"]').text();
    var xiaoji = parseFloat(current_price) * num_now;
    console.log(current_price);
    console.log(xiaoji);
    $('[name="subtotal'+biaoshi+'"]').text(xiaoji);
    var total = get_order_total();
    $('#total_price').html(total);
    $('#zongjia').html(total);
}
//订单 数量减
function order_min_num(obj){
    var biaoshi = $(obj).attr('biaoshi');
    var num = $('[name="num'+biaoshi+'"]').val();
    if(num<=1)
    {
        layer.msg("已经是最小值了");
        return;
    }
    var num_now = parseInt(num)-1;
    console.log(num_now);
    $('[name="num'+biaoshi+'"]').val(num_now);
    var current_price = $('[name="current_price'+biaoshi+'"]').text();
    console.log(current_price);
    var xiaoji = parseFloat(current_price) * num_now;
    console.log(xiaoji);
    $('[name="subtotal'+biaoshi+'"]').text(xiaoji);
    var total = get_order_total();
    $('#total_price').html(total);
    $('#zongjia').html(total);
}
//订单 总价
function get_order_total(){
    var total = 0;
    $('#buy_product').find(".item-content").each(function(){
        // var biaoshi = $(this).find('[name="order_product"]').val();
        // console.log(biaoshi);
        var subtotal = $(this).find('.pay-sum').html();
        // console.log("subtotal："+subtotal);
        total += parseFloat(subtotal);
        // console.log("total："+total);
    })
    return total;
}
//订单 收货地址 选择
function order_address_select(obj){
    var address_id = $(obj).attr('myid');
    var name = $(obj).find('.new-txt').text();
    var phone = $(obj).find('.new-txt-rd2').text();
    var address = $(obj).find('[name="address"]').text();
    $('.buy-user').text(name);
    $('.buy-phone').text(phone);
    $('.buy--address-detail').text(address);
    $('#sure_address_id').val(address_id);
    $(".address_mk").css("display","none");
}
//订单 收货地址 添加
function order_address_save(){
    var id = $('#address_id').val();
    var name = $('#name').val();
    var phone = $('#phone').val();
    var province = $('#province').val();
    var city = $('#city').val();
    var district = $('#district').val();
    var address = $('#address').val();
    Manage.url = "/phone.php/Address/edit";
    Manage.parameter = {id:id,name:name,phone:phone,province:province,city:city,district:district,address:address};
    Manage.edit(function(msg){
        if(msg=="ok")
        {
            $("#doc-modal-1").css("display", "none");
            $('#address_id').val("");
            $('#name').val("");
            $('#phone').val("");
            $('#address').val("");
            _init_area();
        }
    });
}
//产品三级 提交 产品信息
function get_show_order_product(){
    var select_spec = 0;
    var spec_obj = {};
    var spec_length = $('[biaoshi="spec"]').length;  //规格的数量
    // console.log("spec_length:"+spec_length);
    if(spec_length>0)
    {
        $('[biaoshi="spec"]').each(function(index){
            console.log($(this).find('.selected').length);
            if($(this).find('.selected').length>0)
            {
                // console.log("选中了");
                select_spec = select_spec + 1;
                var select_index = $(this).find('.selected').index();
                // console.log(index +"："+select_index);
                if(select_index==-1)
                {
                    return false;
                }
                var spec_name = $(this).find('.cart-title').text();
                // console.log(spec_name);
                var spec_valeue = $(this).find("li").eq(select_index).text();
                // console.log(spec_valeue);
                spec_obj[spec_name] = $(this).find("li").eq(select_index).text();
            }
        })
        if(spec_length!=select_spec)
        {
            return;
        }
    }
    
    var product_id = $('#product_id').val();
    var product_spec = spec_obj;
    var count = $('#count').val();
    
    var product_info = {};
    product_info["id"] = product_id;
    product_info["spec"] = JSON.stringify(product_spec);
    product_info["count"] = count;

    var order_product = new Array();
    order_product.push(product_info);
    // console.log(order_product);
    var json_order_product = JSON.stringify(order_product);
    return json_order_product; 
}
//产品三级 购买
function show_buy(){
    var order_product = get_show_order_product();
    if(order_product==undefined)
    {
        layer.msg("请选择规格后进行该操作");
        return;
    }
    console.log(order_product);
    $('[name="order_product"]').val(order_product);
    // return;
    // $('[name="order_product"]').val(order_product);
    $('#form_productInfo').submit();
}
//产品三级 数量减
function show_min(){
    var count = $('#count').val();
    if(parseInt(count)<=1)
    {
        layer.msg("已经是最小值了");
        $('#count').val("1");
    }
    else{
        $('#count').val(parseInt(count)-1);
    }
}
//产品三级 数量加
function show_add(){
    var count = $('#count').val();
    var reserve = $('#reserve').html();
    if(parseInt(count)>=parseInt(reserve))
    {
        layer.msg("库存不足，请核对购买数量",{time:1500,icon:5},function(){
            $('#count').val(reserve).focus().select();
        });
    }
    else
    {
        $('#count').val(parseInt(count)+1);
    }
}
function select_spec(obj){
    //加减选中样式
    if ($(obj).hasClass("selected")) {
        $(obj).removeClass("selected");
    } else {
        $(obj).addClass("selected").siblings("li").removeClass("selected");
    }
    //name：点击的规格。  value：点击的规格值
    name = $(obj).parents('[biaoshi="spec"]').find('.cart-title').text();
    value = $(obj).text();
    var spec_obj = {};
    //如果选中
    if($(obj).attr('class').indexOf('selected')>0)
    {
        var product_id = $('#product_id').val();
        var spec = new Array();
        var spec_length = $('[biaoshi="spec"]').length;  //规格的数量
        // console.log("spec_length:"+spec_length);
        $('[biaoshi="spec"]').each(function(index){
            if($(this).find('.selected'))
            {
                var select_index = $(this).find('.selected').index();
                console.log(index +"："+select_index);
                if(select_index==-1)
                {
                    return false;
                }
                var spec_name = $(this).find('.cart-title').text();
                console.log(spec_name);
                var spec_valeue = $(this).find("li").eq(select_index).text();
                console.log(spec_valeue);
                spec_obj[spec_name] = $(this).find("li").eq(select_index).text();
            }
        })
        // console.log(spec_array.length);
        // return;
        // console.log(spec_obj);
        $.ajax({
            url:'/Product/getPrice',
            data:{id:product_id,spec:spec_obj},
            type:'post',
            dataType:'json',
            success:function(data){
                if(data.status=="ok")
                {
                    $('#original_price').html(data.original_price);
                    $('#current_price').html(data.current_price);
                    $('#reserve').html(data.reserve);
                }
                // if(data.Picture.length>0)
                // {
                //     $('.jqzoom img').attr('src',"__ROOT__/"+data.Picture).attr('jqimg',"__ROOT__/"+data.Picture);
                // }
            }
        })
        // if(spec_obj.length == spec_length)
        // {
            
        // }
    }
}
//收货地址 删除
function address_del(id,obj){
    layer.confirm("确认要删除吗，删除后不能恢复", { title: "删除确认" },function(){
        $.ajax({
            url:'/phone.php/Address/delete',
            data:{id:id},
            type:'post',
            success:function(msg){
                if(msg=="ok")
                {
                    layer.msg("删除收货地址成功",{icon:1,time:2000},function(){
                        $(obj).parents('li').remove();
                    });
                }
                if(msg=="error")
                {
                    layer.msg("抱歉，请重新删除收货地址");
                }
                if(msg=="id_null")
                {
                    layer.msg("请选择要删除的收货地址");
                }
            }
        })
    })  
}
