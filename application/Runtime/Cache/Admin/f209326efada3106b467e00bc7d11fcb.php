<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
</head>
<body>
    <table id='MallBanner'></table>
    <div id='toolbar_MallBanner' style=" padding:5px 0px 5px 5px">
        <div style=" height:5px"></div>
        <a class="easyui-linkbutton" data-options="iconCls:'icon-add'" id="add_MallBanner">新增</a>
        <a class="easyui-linkbutton" data-options="iconCls:'icon-add'" id="edit_MallBanner">修改</a>
        <a class="easyui-linkbutton" data-options="iconCls:'icon-no'" id="delete_MallBanner">删除</a>
    </div>

    <script type="text/javascript">
        $('#MallBanner').datagrid({
            url: '/admin.php/MallBanner/getData',
            columns: [[
                { field: 'cbo_Banner', checkbox: true },
                { field: 'id', title: 'ID', hidden: true },
                {
                    field: 'title', title: '标题', width: 200, align: 'center',
                    editor: 'textbox'
                },
                {
                    field: 'picture', title: 'Banner图', width: 200, align: 'center',
                    formatter: function (value, row, index) {
                        var str = "";
                        if (value == "" || value == undefined) {
                            str = '暂无图片';
                        }
                        else {
                            str = '<a><img style="height: 50px;width: 150px;" src="/' + value + '"/></a>';
                        }
                        return str;
                    }
                }//,
                //{
                //    field: 'caozuo', title: '操作', width: 100, align: 'center',
                //    formatter: function (value, row, index) {
                //        var Url = "../ashx/ManageBanner.ashx";
                //        var ID = row.ID;
                //        var a = '<a href="javascript:void(0)" onclick=yidong("' + Url + '","' + ID + '","UpMove","Table_Banner")>上移</a>';
                //        var b = '<a href="javascript:void(0)" onclick=yidong("' + Url + '","' + ID + '","DownMove","Table_Banner")>下移</a>';
                //        return a + " | " + b;
                //    }
                //}
            ]],
            toolbar: '#toolbar_MallBanner',
            pagination: true,
            singleSelect: true,
            selectOnCheck: false,
            rownumbers: true,
            idField: 'id',
            checkOnSelect: false

        });
    </script>
    <script type="text/javascript">
        $(function () {

            $('#add_MallBanner').click(function () {
                var titleMsg = '添加_商城Banner';
                var IsHave = $('#right').tabs('exists', titleMsg);
                if (IsHave) {
                    $('#right').tabs('select', titleMsg);
                    var tab = $('#right').tabs('getSelected');
                    tab.panel('refresh', "/admin.php/MallBanner/info");
                }
                else {
                    $('#right').tabs('close', "修改_商城Banner");
                    $('#right').tabs('add', {
                        title: titleMsg,
                        content: '<div class="easyui-panel" href="/admin.php/MallBanner/info" fit="true" border="false" ></div>',
                        closable: true
                    });
                }

            })


            $('#edit_MallBanner').click(function () {
                var titleMsg = '修改_商城Banner';
                var selected = $('#MallBanner').datagrid('getSelected');
                if (selected) {
                    var IsHave = $('#right').tabs('exists', titleMsg);
                    if (IsHave) {
                        $('#right').tabs('select', titleMsg);
                        var tab = $('#right').tabs('getSelected');
                        tab.panel('refresh', "/admin.php/MallBanner/info?id=" + selected.id);
                    }
                    else {
                        $('#right').tabs('close', "添加_商城Banner");
                        $('#right').tabs('add', {
                            title: titleMsg,
                            content: '<div class="easyui-panel" href="/admin.php/MallBanner/info/?id=' + selected.id + '" fit="true" border="false" ></div>',
                            closable: true
                        });
                    }
                }
                else {
                    alert("请选择要进行修改的一条数据");
                }
            })


            $('#delete_MallBanner').click(function () {
                var checked = $('#MallBanner').datagrid('getChecked');
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
                                url: '/admin.php/MallBanner/delete',
                                data: { "id": delID },
                                type: 'post',
                                success: function (msg) {
                                    if (msg == "ok") {
                                        alert("删除成功");
                                        $('#MallBanner').datagrid('reload');
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

        })
    </script>
</body>
</html>