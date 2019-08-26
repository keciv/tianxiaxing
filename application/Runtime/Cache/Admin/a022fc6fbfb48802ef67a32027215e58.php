<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>会员管理</title>
</head>
<body>
    
    <div id='Store_toolber' style=" padding:5px 0px 5px 5px">
        <div style=" height:5px"></div>
        <a class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="add_Store()">新增</a>
        <a class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onclick="edit_Store()">修改</a>
        <a class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="del_Store()">删除</a>
    </div>
    <table id="Store"></table>

    <input type="hidden" id="select_Store" style="display:none" />
    <div id="div_add_Store" style="display:none;">
        <input type="hidden" id="caozuo_Store" value="<?php echo ($caozuo); ?>" style="display:none"  />
        <div style=" padding:10px 10px;">
            <div style="text-align: center;">
                <p>
                    店铺名称：
                    <input id="Store_name" class="easyui-textbox" data-options="required: true" style="width:200px;height: 30px;line-height: 30px;">
                </p>
                <br />
                <p>
                    运费：
                    <input id="Store_yunfei" class="easyui-textbox" data-options="required: true" style="width:200px;height: 30px;line-height: 30px;">
                </p>
                <br />
                <p>
                    包邮：
                    <input id="Store_mianyou" class="easyui-textbox" data-options="required: true" style="width:200px;height: 30px;line-height: 30px;">
                </p>
                <br />
                <a id="btn_save_Store" href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add'">保存</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a id="btn_cancel_Store" href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-clear'">取消</a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function () {
            $('#Store').datagrid({
                url: '/admin.php/Store/getData',
                columns: [[
                    { field: 'cbo_Store', checkbox: true },
                    { field: 'id', title: 'ID', hidden: true },
                    { field: 'name', title: '门店名称', width: 200 , align: 'center'},
                    { field: 'yunfei', title: '运费：', width: 100 , align: 'center'},
                    { field: 'mianyou', title: '包邮', width: 100 , align: 'center'}
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
                toolbar: '#Store_toolber',
                //是否显示行脚
                showFooter: true,
                idField: 'id'
            });
        })
    </script>

    <script type="text/javascript">
        function add_Store() {
            //alert("ok");
            $('#caozuo_Store').val("add");
            $('#div_add_Store').show();
            // $('#div_add_Store').dialog('open');
            $('#div_add_Store').window({
                title: '门店添加',
                width: 400,
                height: 250,
                modal: true,
                collapsible: false,
                minimizable: false,
                maximizable: false,
                // closed: true,
                onClose: function () {
                    $("#Store_name").textbox('setValue', "");
                    $("#Store_yunfei").textbox('setValue', "");
                    $("#Store_mianyou").textbox('setValue', "");
                }
            });
        }

        function edit_Store() {
            var selected = $('#Store').datagrid('getSelected');
            $('#select_Store').val(selected.id);
            $('#caozuo_Store').val("edit");

            $("#Store_name").textbox('setValue', selected.name);
            $("#Store_yunfei").textbox('setValue', selected.yunfei);
            $("#Store_mianyou").textbox('setValue', selected.mianyou);

            $('#div_add_Store').show();
            $('#div_add_Store').window({
                title: '门店修改',
                width: 400,
                height: 250,
                modal: true,
                collapsible: false,
                minimizable: false,
                maximizable: false,
                // closed: true,
                onClose: function () {
                    $("#Store_name").textbox('setValue', "");
                    $("#Store_yunfei").textbox('setValue', "");
                    $("#Store_mianyou").textbox('setValue', "");
                }
            });
        }

        function del_Store() {
            var checked = $('#Store').datagrid('getChecked');
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
                            url: '/admin.php/Store/delete',
                            data: { id: delID },
                            type: 'post',
                            success: function (msg) {
                                if (msg == "ok") {
                                    alert("删除成功");
                                    $('#Store').datagrid('reload');
                                }
                                if (msg == "error") {
                                    alert("删除失败，请重新尝试");
                                }
                                if (msg == "no") {
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
        }
    </script>
    <script type="text/javascript">
        $(function () {
            $('#btn_save_Store').click(function () {
                var caozuo = $('#caozuo_Store').val();
                var name = $("#Store_name").textbox('getValue');
                var yunfei = $("#Store_yunfei").textbox('getValue');
                var mianyou = $("#Store_mianyou").textbox('getValue');
                
                $.ajax({
                    url: '/admin.php/Store/' + caozuo,
                    data: { id: $('#select_Store').val(), name: name, yunfei: yunfei, mianyou: mianyou},
                    type: 'post',
                    success: function (msg) {
                        if (msg == "ok") {
                            layer.msg("保存成功",{time:2000},function(){
                                $('#div_add_Store').window('close');
                                $('#Store').datagrid('reload');
                            });
                        }
                        else if(msg=="id_null")
                        {
                            layer.msg("请选择要修改的规格");
                        }
                        else if (msg == "name_null")
                        {
                            layer.msg("请输入门店名称");
                        }
                    }
                })
            })

            $('#btn_cancel_Store').click(function () {
                $('#div_add_Store').window('close');
            })
        })
    </script>
</body>
</html>