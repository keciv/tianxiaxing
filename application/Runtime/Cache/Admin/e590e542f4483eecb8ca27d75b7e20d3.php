<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>会员管理</title>
</head>
<body>

    <div id='memberInfo_toolber' style=" padding:5px 0px 5px 5px">
        <!-- <input id="memberInfo_search" />
        <div id="search_memberInfo_tiaojian" style="width:120px">
            <div data-options="name:'phone',iconCls:'icon-ok'">手机号</div>
            <div data-options="name:'username',iconCls:'icon-ok'">用户名</div>
            <div data-options="name:'name',iconCls:'icon-ok'">姓名</div>
        </div> -->
        手机号：<input class="easyui-textbox" data-options="" id="memberInfo_phone" style="width:100px"> 
        时间：<input  id="memberInfo_date"  type="text" ></input>
        <a id="btn_memberInfo_search" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-search'">搜索</a> 
        <div style=" height:5px"></div>
        <a class="easyui-linkbutton" data-options="iconCls:'icon-add'" id="add_member">新增</a>
        <a class="easyui-linkbutton" data-options="iconCls:'icon-edit'" id="edit_member">修改</a>
        <a class="easyui-linkbutton" data-options="iconCls:'icon-no'" id="delete_member">删除</a>
    </div>

    <!--充值-->
    <!-- <div id="Div_Recharge_Add" style="display:none" align="center">
        <input type="hidden" name="member_id">
        <input type="hidden" name="proportion" value="<?php echo ($proportion); ?>">
        <table style="margin-top:20px">
            <tr>
                <td align="right">金额：</td>
                <td colspan="3"><input type="text" name="integral" style="width: 169px;" /></td>
            </tr>
            <tr height="5px"></tr>
            <tr>
                <td align="right"></td>
                <td colspan="4" style="font-size: 10px;color: #f05151;">提示：充值奖励为<?php echo ($proportion); ?>%</td>
            </tr>
            <tr height="5px"></tr>
            <tr>
                <td align="right">可用：</td>   
                <td align="right">
                    <input type="text" name="keyong" style="width: 60px">
                </td>
                <td align="right">指定：</td>   
                <td>
                    <input type="text" name="zhiding"  style="width: 60px">
                </td>
            </tr>
            <tr height="5px"></tr>
        </table>
        <br />
        <input type="button" id="recharge_queren" value="确认" />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" id="recharge_quxiao" value="取消" />
    </div> -->
    <!-- 积分修改 -->
    <div id="Div_Integral_Edit" style="display:none" align="center">
        <input type="hidden" name="member_id">
        <input type="hidden" name="edit_type">
        <table style="margin-top:20px">
            <tr>
                <td align="right">金额：</td>
                <td colspan="3"><input type="text" name="integral" style="width: 169px;" /></td>
            </tr>
        </table>
        <br />
        <input type="button" name="add" value="增加" />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" name="reduce" value="减少" />
    </div>

    <table id="Members"></table>
    <!--添加用户-->
    <div id="Div_MembersInfo_Add" style="display:none" align="center">
        <table style="margin-top:20px">
            <tr>
                <td align="right">电话：</td>
                <td><input type="text" name="phone" /></td>
            </tr>
            <tr height="5px"></tr>
            <tr>
                <td align="right">密码：</td>
                <td><input type="password" name="password" /></td>
            </tr>
            <tr height="5px"></tr>
            <tr>
                <td align="right">确认密码：</td>
                <td><input type="password" name="surepassword" /></td>
            </tr>
            <tr height="5px"></tr>
            <tr>
                <td align="right">邀请人：</td>
                <td><input type="text" name="inviter" /></td>
            </tr>
            <tr height="5px"></tr>
        </table>
        <br />
        <input type="button" id="MembersInfo_Add_queren" value="确认" />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" id="MembersInfo_Add_quxiao" value="取消" />

    </div>  

    <div id="caozuo_integral" class="easyui-menu" data-options="onClick:caozuo_integral" style="width:120px;">
        <div>修改</div>
    </div>
    <div id="caozuo_audit" class="easyui-menu" data-options="onClick:caozuo_audit" style="width:120px;">
        <input type="hidden" name="member_id">
        <div>通过</div>
        <div>不通过</div>
    </div>

    <script type="text/javascript">
        $(function () {
            $('#Members').datagrid({
                url: '/admin.php/MemberInfo/getData',
                columns: [[
                    { field: 'cbo_MembersInfo', checkbox: true },
                    { field: 'id', title: 'ID', hidden: true },
                    // { field: 'username', title: '用户名', width: 100 , align: 'center'},
                    { field: 'phone', title: '电话', width: 100 , align: 'center'},
                    { field: 'withdrawal_limit', title: '提现额度', width: 100 , align: 'center'},
                    { field: 'commission', title: '佣金', width: 100 , align: 'center'},
                    { field: 'integral', title: '积分', width: 100 , align: 'center'},
                    { field: 'grade', title: '等级', width: 100 , align: 'center',
                        formatter: function (value, row, index) {
                            var a = "";
                            if(value=="0")
                            {
                                a = "游客";
                            }
                            if(value=="1")
                            {
                                a = "合伙人";
                            }
                            if(value=="2")
                            {
                                a = "经理";
                            }
                            if(value=="3")
                            {
                                a = "总监";
                            }
                            return a;
                        }
                    },
                    { field: 'type', title: '类型', width: 100 , align: 'center',
                        formatter: function (value, row, index) {
                            var a = "";
                            if(value=="0")
                            {
                                a = "游客";
                            }
                            if(value=="1")
                            {
                                a = "会员";
                            }
                            if(value=="2")
                            {
                                a = "店铺";
                            }
                            return a;
                        }
                    },
                    { field: 'create_time', title: '创建时间', width: 150 , align: 'center'},
                    { field: 'inviter_name', title: '推荐人', width: 100 , align: 'center'},
                    // { field: 'audit', title: '状态', width: 80 , align: 'center',
                    //     formatter: function (value, row, index) {
                    //         var a = "";
                    //         if(value=="0")
                    //         {
                    //             a = "待支付";
                    //         }
                    //         if(value=="1")
                    //         {
                    //             a = "待审核";
                    //         }
                    //         if(value=="2")
                    //         {
                    //             a = "已审核";
                    //         }
                    //         if(value=="-1")
                    //         {
                    //             a = "不通过";
                    //         }
                    //         return a;
                    //     }
                    // },
                    { field: 'recommend', title: '我的推荐', width: 100 , align: 'center',
                        formatter: function (value, row, index) {
                            var a = '<span onclick=open_newtab("/admin.php/Team/index?id='+row.id+'","团队信息")>查看</span>';
                            return a;
                        }
                    }
                ]],
                //斑马线
                striped: true,
                //底部分页
                pagination: true,
                //行号
                rownumbers: true,
                //只能选中一行
                singleSelect: true,
                //如果为true，单击复选框将永远选择行。如果为false，选择行将不选中复选框。
                selectOnCheck: false,
                //如果为true，当用户点击行的时候该复选框就会被选中或取消选中。如果为false，当用户仅在点击该复选框的时候才会呗选中或取消。
                checkOnSelect: false,
                //工具栏
                toolbar: '#memberInfo_toolber',
                //是否显示行脚
                showFooter: true,
                idField: 'id',
                onRowContextMenu:function(e, index, row){
                    e.preventDefault();
                    e.stopPropagation();
                    var pageX = e.pageX;
                    var pageY = e.pageY;
                    var td = $(e.target).closest("td");
                    var field = td.attr('field');

                    if(field=="keyong")
                    {
                        $('#Div_Integral_Edit [name="edit_type"]').val(field);
                        $('#Div_Integral_Edit [name="member_id"]').val(row.id);
                        $('#caozuo_integral').menu('show', {left: pageX,top: pageY});
                    }
                    if(field=="audit")
                    {
                        $('#caozuo_audit [name="member_id"]').val(row.id);
                        $('#caozuo_audit').menu('show', {left: pageX,top: pageY});
                    }
                }
            });
        })

        $('#memberInfo_date').datebox({    
            required:true   
        });   

        $('#memberInfo_search').searchbox({
            searcher: function (value, name) {
                //alert(value + "," + name)
                $('#Members').datagrid('load', {
                    parameterType: name,
                    parameter: value
                });
            },
            menu: '#search_memberInfo_tiaojian',
            prompt: '请输入值',
            width: 200
        });

        $('#Div_MembersInfo_Add').dialog({
            title: '添加会员',
            width: 400,
            height: 280,
            closable: true,
            closed: true,
            cache: false,
            onClose: function () {
                $('#Div_MembersInfo_Add :password').val('');
                $('#Div_MembersInfo_Add [name="phone"]').val('');
                $('#Div_MembersInfo_Add [name="inviter"]').val('');
            },
            modal: true
        });

        $('#Div_Recharge_Add').dialog({
            title: '充值',
            width: 400,
            height: 200,
            closable: true,
            closed: true,
            cache: false,
            onClose: function () {
                $('#Div_Recharge_Add [name="integral"]').val("");
                $('#Div_Recharge_Add [name="keyong"]').val("");
                $('#Div_Recharge_Add [name="zhiding"]').val("");
            },
            modal: true
        });

        $('#Div_Integral_Edit').dialog({
            title: '积分修改',
            width: 400,
            height: 200,
            closable: true,
            closed: true,
            cache: false,
            onClose: function () {
                $('#Div_Integral_Edit [name="integral"]').val("");
            },
            modal: true
        });
    </script>

    <script type="text/javascript">
        $(function () {
            $('#edit_member').click(function () {
                var titleMsg = '修改_会员';
                var selected = $('#Members').datagrid('getSelected');
                if (selected) {
                    var IsHave = $('#right').tabs('exists', titleMsg);
                    if (IsHave) {
                        $('#right').tabs('select', titleMsg);
                        var tab = $('#right').tabs('getSelected');
                        tab.panel('refresh', "/admin.php/MemberInfo/info?id=" + selected.id);
                    }
                    else {
                        $('#right').tabs('close', "添加_会员");
                        $('#right').tabs('add', {
                            title: titleMsg,
                            content: '<div class="easyui-panel" href="/admin.php/MemberInfo/info/?id=' + selected.id + '" fit="true" border="false" ></div>',
                            closable: true
                        });
                    }
                }
                else {
                    alert("请选择要进行修改的一条数据");
                }
            })

            $('#delete_member').click(function () {
                var checked = $('#Members').datagrid('getChecked');
                var delID = "";
                if (checked.length > 0) {
                    $.messager.confirm('确认', '您确认要删除这些数据吗？', function (r) {
                        if (r) {
                            for (var i = 0; i < checked.length; i++) {
                                delID += checked[i].id;
                                delID += ",";
                            }
                            delID = delID.substr(0, delID.length - 1);
                            $.ajax({
                                url: '/admin.php/MemberInfo/delete',
                                data: { "id": delID },
                                type: 'post',
                                success: function (msg) {
                                    if (msg == "ok") {
                                        alert("删除成功");
                                        $('#Members').datagrid('reload');
                                    }
                                    if (msg == "error") {
                                        alert("删除失败，请重新尝试");
                                    }
                                    if (msg == "id_null") {
                                        alert("数据不存在，刷新后请重新操作");
                                    }
                                }
                            })
                        }
                    })
                }
                else {
                    alert("请选择要删除的数据");
                }
            })
            $('#btn_memberInfo_search').click(function(){
                var phone = $('#memberInfo_phone').textbox('getValue');
                var time = $('#memberInfo_date').datebox('getValue');
                console.log(time);
                $('#Members').datagrid('reload',{
                    time: time,
                    phone:phone
                })
            })
        })
    </script>

    <script type="text/javascript">
        function recharge(index) {
            $('#Members').datagrid('selectRow', index);
            var selected = $('#Members').datagrid('getSelected');
            var id = selected.id;
            $('#Div_Recharge_Add [name="member_id"]').val(id);
            $('#Div_Recharge_Add').show();
            $('#Div_Recharge_Add').dialog('open');
        }
        function caozuo_integral(item){
            $('#Div_Integral_Edit').show();
            $('#Div_Integral_Edit').dialog('open');
        }
        function caozuo_audit(item){

            var id = $('#caozuo_audit [name="member_id"]').val();
            var audit = item.text;
            if(audit=="通过")
            {
                audit = 2;
            }
            else if(audit=="不通过")
            {
                audit = -1;
            }
            $.ajax({
                url:'/admin.php/MemberInfo/audit',
                data:{id:id,audit:audit},
                type:'post',
                success:function(msg){
                    if(msg=="ok")
                    {
                        layer.msg("审核成功",{time:2000},function(){
                            $('#Members').datagrid('reload');
                        });
                    }
                    if(msg=="error")
                    {
                        layer.msg("审核失败，请重新审核");
                    }
                    if(msg=="member_null")
                    {
                        layer.msg("会员不存在，请确认");
                    }
                    if(msg=="inviter_null")
                    {
                        layer.msg("邀请人不存在，请确认");
                    }
                    if(msg=="id_null")
                    {
                        layer.msg("请选择要审核的会员");
                    }
                }
            })
        }
        function edit_integral(type){
            var integral_type = $('#Div_Integral_Edit [name="edit_type"]').val();
            var integral = $('#Div_Integral_Edit [name="integral"]').val();
            var member_id = $('#Div_Integral_Edit [name="member_id"]').val();
            if(integral_type.length<0)
            {
                layer.msg("请选择要修改的积分类型");
                return;
            }
            if(integral.length<0)
            {
                layer.msg("请输入要修改的积分额度");
                return;
            }
            if(type.length<0)
            {
                layer.msg("请选择要修改的操作");
                return;
            }
            if(member_id.length<0)
            {
                layer.msg("请选择要修改的会员");
                return;
            }

            $.ajax({
                url:'/admin.php/MemberInfo/edit_integral',
                data:{integral_type:integral_type,integral:integral,type:type,member_id:member_id},
                type:'post',
                success:function(msg){
                    if(msg=="ok")
                    {
                        layer.msg("恭喜，修改成功",{time:1500},function(){
                            $('#Div_Integral_Edit').dialog('close');
                            $('#Members').datagrid('reload');
                        });
                    }
                    else
                    {
                        layer.msg("抱歉，修改失败");
                    }
                }
            })
        }
        function open_newtab(url, title) {
            var IsHave = $('#right').tabs('exists', title);
            if (IsHave) {
                $('#right').tabs('select', title);
                var tab = $('#right').tabs('getSelected');  // 获取选择的面板
                //刷新面板
                tab.panel('refresh', url);
            }
            else {
                $('#right').tabs('add', {
                    title: title,
                    content: '<div class="easyui-panel" href="' + url + '" fit="true" border="false" ></div>',
                    closable: true

                });
            }
        }
    </script>

    <script type="text/javascript">
        $(function () {
            var reg = /^1[3|4|5|7|8]\d{9}$/;
            //打开添加窗口
            $('#MembersInfo_Add_queren').unbind();
            $('#add_member').click(function () {
                //alert("点击了添加");
                $('#Div_MembersInfo_Add').show();
                $('#Div_MembersInfo_Add').dialog('open');
            })

            //确认添加
            $('#MembersInfo_Add_queren').click(function () {
                // console.log("哈哈");
                var password = $('#Div_MembersInfo_Add [name="password"]').val();
                var surepassword = $('#Div_MembersInfo_Add [name="surepassword"]').val();
                var phone = $('#Div_MembersInfo_Add [name="phone"]').val();
                var inviter = $('#Div_MembersInfo_Add [name="inviter"]').val();
                if (phone.length <= 0 || !reg.test(phone)) {
                    alert("请输入手机号");
                    $('#Div_MembersInfo_Add [name="phone"]').focus();
                    return;
                }
                if (password.length <= 0) {
                    alert("请输入密码");
                    $('#Div_MembersInfo_Add [name="password"]').focus();
                    return;
                }
                if (surepassword.length <= 0) {
                    alert("请输入确认密码");
                    $('#Div_MembersInfo_Add [name="surepassword"]').focus();
                    return;
                }
                if (password != surepassword) {
                    alert("两次密码输入不一致，请重新输入");
                    $('#Div_MembersInfo_Add [name="password"]').val('');
                    $('#Div_MembersInfo_Add [name="surepassword"]').val('');
                    $('#Div_MembersInfo_Add [name="password"]').focus();
                    return;
                }

                $.ajax({
                    url: '/admin.php/MemberInfo/add',
                    data: { password: password, surepassword: surepassword, phone: phone, inviter:inviter},
                    type: 'post',
                    success: function (msg) {
                        if (msg == "ok") {
                            alert("恭喜，添加成功");
                            $('#Div_MembersInfo_Add').dialog('close');
                            $('#Members').datagrid('reload');
                            return;
                        }
                        if (msg == "error") {
                            alert("抱歉，添加时出错，请重新添加");
                            return;
                        }
                        if (msg == "havePhone") {
                            alert("手机号已存在，请换一个手机号重新添加");
                            return;
                        }
                        if (msg == "buyizhi") {
                            alert("两次密码输入不一致，请重新输入");
                            return;
                        }
                        if (msg == "buwanzheng") {
                            alert("请输入完整信息后再添加");
                            return;
                        }
                        if (msg == "inviter_null") {
                            alert("邀请人不存在，请重新输入邀请人");
                            return;
                        }
                    }
                })
            })
            
            $('#MembersInfo_Add_quxiao').click(function () {
                $('#Div_MembersInfo_Add').dialog('close');
            })

            $('#Div_Integral_Edit [name="add"]').unbind();
            $('#Div_Integral_Edit [name="reduce"]').unbind();

            $('#Div_Integral_Edit [name="add"]').click(function(){
                var type = "add";
                edit_integral(type);
            })
            $('#Div_Integral_Edit [name="reduce"]').click(function(){
                var type = "reduce";
                edit_integral(type);
            })
        })
        
    </script>
    <script type="text/javascript">
        $(function(){
            $('#recharge_queren').unbind();
            $('#Div_Recharge_Add [name="integral"]').blur(function(){
                var integral = $('#Div_Recharge_Add [name="integral"]').val();
                var proportion = $('#Div_Recharge_Add [name="proportion"]').val();
                console.log("integral:"+integral);
                console.log("proportion:"+proportion);
                var keyong = integral;
                var zhiding = integral * (proportion/100);
                $('#Div_Recharge_Add [name="keyong"]').val(keyong);
                $('#Div_Recharge_Add [name="zhiding"]').val(zhiding);
            })
            $('#recharge_queren').click(function(){
                var member_id = $('#Div_Recharge_Add [name="member_id"]').val();
                // var integral = $('#Div_Recharge_Add [name="integral"]').val();
                
                var keyong = $('#Div_Recharge_Add [name="keyong"]').val();
                var zhiding = $('#Div_Recharge_Add [name="zhiding"]').val();
                var fenpei = 1;
                
                $.ajax({
                    url:'/admin.php/MemberInfo/recharge',
                    data:{id:member_id,keyong:keyong,zhiding:zhiding},
                    type:'post',
                    success:function(msg){
                        if(msg=="ok")
                        {
                            layer.msg("恭喜，充值成功",{time:1500},function(){
                                $('#Div_Recharge_Add').dialog('close');
                                $('#Members').datagrid('reload');
                            });
                        }
                        if(msg=="error")
                        {
                            ayer.msg("充值失败，请重新充值");
                        }
                        if(msg=="id_null")
                        {
                            ayer.msg("请选择要充值的会员");
                        }
                        if(msg=="integral_null")
                        {
                            ayer.msg("请输入要充值的额度");
                        }
                        if(msg=="fenpei_null")
                        {
                            ayer.msg("请选择要分配的模式");
                        }
                    }
                })
                // console.log(member_id);
                // console.log(integral);
                // console.log(type);
            })
        })
    </script>
</body>
</html>