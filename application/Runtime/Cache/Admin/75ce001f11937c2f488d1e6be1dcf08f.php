<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>会员管理</title>
</head>
<body>
    <table id='MallProductSort'></table>
    <input type="hidden" id="select_MallProductSort" style="display:none" />
    <input type="hidden" id="caozuo_MallProductSort" value="<?php echo ($caozuo); ?>" style="display:none"  />
    <div id='toolbar_MallProductSort' style=" padding:5px 0px 5px 5px">
        <div style=" height:5px"></div>
        <a class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="add_MallProductSort()">新增</a>
        <a class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="edit_MallProductSort()">修改</a>
        <a class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="del_MallProductSort()">删除</a>
    </div>
    <div id="caozuo_sequence_sort" class="easyui-menu" data-options="onClick:caozuo_sequence_sort" style="width:120px;">
        <div>置顶</div>
        <div>上移</div>
        <div>下移</div>
        <div>底部</div>
    </div>
    <div id="caozuo_recommend_sort" class="easyui-menu" data-options="onClick:caozuo_recommend_sort" style="width:120px;">
        <div>是</div>
        <div>否</div>
    </div>
    <div id="caozuo_sale_sort" class="easyui-menu" data-options="onClick:caozuo_sale_sort" style="width:120px;">
        <div>上架</div>
        <div>下架</div>
    </div>
    <input type="hidden" id="caozuo_field_productsort" name="">
    <input type="hidden" id="caozuo_id_productsort" name="">
    <div id="div_add_MallProductSort" style="display:none;">
        <div style=" padding:10px 10px;">
            <p style="height:20px; line-height:10px; font-size:14px;">
                类型名称：
                <input id="MallProductSortName" type="text" style="width:200px;height: 30px;line-height: 30px;">
            </p>
            <p style="height:20px; line-height:30px; font-size:14px;">
                所属分类：
                <input id="ParentSort" style="width:200px;height: 30px;line-height: 30px;">
            </p>
            <p style="width:70px; float:left;height:30px; line-height:30px; font-size:14px;">
                图片：</p>
                <form id="form_ProductSort" method="post" enctype="multipart/form-data" style="display: inline-block;float: left;margin: 16px 0;">
                    <input type="file" id="MallProductSortImage" name="MallProductSortImage" style="width:200px"/>
                    <a href="javascript:void(0)" class="easyui-linkbutton" onClick="upload('/admin.php/Upload/upload', 'MallProductSortImage', 'form_ProductSort', 'ProductSort');">上传</a>
                </form>
            <div style="clear: both;"></div>
            <p style="margin-top:0;">
                <img id="img_MallProductSortImage" src="http://www.jythjc.com/<?php echo ($ProdyctType["picture"]); ?>" style=" width:100px; height:100px;border: 1px solid #ccc; margin-left: 70px" />
                <input type="hidden" id="hidden_MallProductSortImage" value="<?php echo ($ProdyctType["picture"]); ?>" />
            </p>
            <p style="height:60px; line-height:10px; font-size:14px;display: none;">类型描述：<input id="MallProductSortDescription" type="text" style="width:200px;height: 30px;line-height: 30px;">
            </p>
            <div style="text-align: center;">
                <a id="btn_save_MallProductSort" href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add'">保存</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a id="btn_cancel_MallProductSort" href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-clear'">取消</a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $('#MallProductSort').treegrid({
                url: '/admin.php/MallProductSort/getData',
                idField: 'id',
                treeField: 'sort_name',
                columns: [[
                    { field: 'cbo_MallProductSort', checkbox: true },
                    { field: 'id', title: 'ID', hidden: true },
                    { field: 'parent_id', title: 'ParentID', hidden: true },
                    { field: 'sort_name', title: '类别名称', width: 160, hieght: 30, align: 'left' },
                    //{ field: 'description', title: '描述', width: 250,  align: 'center' },
                    // {
                    //     field: 'sort_characteristic', title: '属性', width: 80, hieght: 30, align: 'center',
                    //     formatter: function (value, row, index) {
                    //         var a = '<span onclick="open_sort_characteristic(' + row.id + ')">查看</span>';
                    //         return a;
                    //     }
                    // },
                    { field: 'sequence_id', title: '排序', width: 100, hieght: 30, align: 'center',
                        formatter: function (value, row, index) {
                            var a = "移动";
                            return a;
                        }
                    },
                    { field: 'index_recommend', title: '首页推荐', width: 100, hieght: 30, align: 'center',
                        formatter: function (value, row, index) {
                            var a = "";
                            if(value=="1")
                            {
                                a = "是";
                            }
                            else
                            {
                                a = "否";
                            }
                            return a;
                        }
                    },
                    {
                        field: 'is_sale', title: '上/下架', width: 100, align: 'center',
                        formatter: function (value, row, index) {
                            var a = "";
                            if(value=="1")
                            {
                                a = "上架";
                            }
                            else
                            {
                                a = "下架";
                            }
                            return a;
                        }
                    }
                ]],
                toolbar: '#toolbar_MallProductSort',
                checkOnSelect: false,
                singleSelect: true,
                selectOnCheck: false,
                //是否显示行脚
                showFooter: true,
                onContextMenu:function(e, row){
                    e.preventDefault();
                    e.stopPropagation();
                    var pageX = e.pageX;
                    var pageY = e.pageY;
                    var td = $(e.target).closest("td");
                    var field = td.attr('field');
                    if(field=="sequence_id")
                    {
                        $('#caozuo_field_productsort').val(field);
                        $('#caozuo_id_productsort').val(row.id);
                        $('#caozuo_sequence_sort').menu('show', {left: pageX,top: pageY});
                    }
                    if(field=="index_recommend")
                    {
                        $('#caozuo_field_productsort').val(field);
                        $('#caozuo_id_productsort').val(row.id);
                        $('#caozuo_recommend_sort').menu('show', {left: pageX,top: pageY});
                    }
                    if(field=="is_sale")
                    {
                        $('#caozuo_field_productsort').val(field);
                        $('#caozuo_id_productsort').val(row.id);
                        $('#caozuo_sale_sort').menu('show', {left: pageX,top: pageY});
                    }
                }
            });
            $('#MallProductSortName').textbox({

            })
            $('#MallProductSortDescription').textbox({
                width: 200,
                height: 50,
                multiline: true
            })
            $('#ParentSort').combotree({
                url: '/admin.php/MallProductSort/getProductSortList',
                method: 'post',
                valueField: 'id',
                textField: 'text',
                required: true,
                queryParams:{id:0,is_root:1}
            })
        })
    </script>
    <script type="text/javascript">
        function add_MallProductSort() {
            //alert("ok");
            $('#caozuo_MallProductSort').val("add");
            $('#div_add_MallProductSort').show();
            $('#div_add_MallProductSort').window({
                title: '类型添加',
                width: 400,
                height: 420,
                modal: true,
                collapsible: false,
                minimizable: false,
                maximizable: false,
                //closed: true,
                onClose: function () {
                    $("#MallProductSortName").textbox('setValue', "");
                    $("#MallProductSortDescription").textbox('setValue', "");
                    $("#ParentSort").combotree('reload');
                }
            });
        }

        function edit_MallProductSort() {
            var selected = $('#MallProductSort').datagrid('getSelected');
            $('#select_MallProductSort').val(selected.id);
            $('#caozuo_MallProductSort').val("edit");
            $.ajax({
                url: '/admin.php/MallProductSort/info',
                data: { id: selected.id },
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    if (data.status == "idNull") {
                        alert("请选择要修改的数据");
                        return;
                    }
                    else if (data.status == "DataNull") {
                        alert("要修改的数据不存在，请确认");
                        return;
                    }
                    else
                    {
                        $("#MallProductSortName").textbox('setValue', data.sort_name);
                        $("#MallProductSortDescription").textbox('setValue', data.description);
                        $("#ParentSort").combotree('setValue', data.parent_id);
                        $("#img_MallProductSortImage").attr("src", "/" + data.picture);
                    }
                }
            })

            $('#div_add_MallProductSort').show();
            $('#div_add_MallProductSort').window({
                title: '类型修改',
                width: 400,
                height: 420,
                modal: true,
                collapsible: false,
                minimizable: false,
                maximizable: false,
                //closed: true,
                onClose: function () {
                    $("#MallProductSortName").textbox('setValue', "");
                    $("#MallProductSortDescription").textbox('setValue', "");
                    $('#MallProductSortImage').val("");
                    $("#ParentSort").combotree('setValue', "");
                    $("#img_MallProductSortImage").attr("src", "");
                }
            });
        }

        function del_MallProductSort() {
            var checked = $('#MallProductSort').treegrid('getChecked');
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
                            url: '/admin.php/MallProductSort/delete',
                            data: { id: delID },
                            type: 'post',
                            success: function (msg) {
                                if (msg == "ok") {
                                    alert("删除成功");
                                    $('#MallProductSort').treegrid('reload');
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
        function tuijian_product_sort(id,index_recommend){
            $.messager.confirm("确认","您确认要删除这些数据吗？",function(){
                if(r){
                    $.ajax({
                        url:'/admin.php/MallProductSort/tuijian',
                        data:{"id":id,"index_recommend":index_recommend},
                        type:'post',
                        success:function(msg){
                            if(msg=="ok")
                            {
                                alert("恭喜，执行成功");
                                $('#MallProductSort').treegrid('reload');
                                return;
                            }
                            if(msg=="error")
                            {
                                alert("抱歉，执行失败，请重新操作");
                                return;
                            }
                            if(msg=="id_null")
                            {
                                alert("请选择要操作的数据");
                                return;
                            }
                        }
                    })
                }
            })
        }
        function open_sort_characteristic(id) {
            var titleMsg = '属性管理';
            var IsHave = $('#right').tabs('exists', titleMsg);
            if (IsHave) {
                $('#right').tabs('select', titleMsg);
                var tab = $('#right').tabs('getSelected');
                tab.panel('refresh', "/admin.php/MallCharacteristic.html?sort_id=" + id);
            }
            else {
                $('#right').tabs('add', {
                    title: titleMsg,
                    content: '<div class="easyui-panel" href="/admin.php/MallCharacteristic.html?sort_id=' + id + '" fit="true" border="false" ></div>',
                    closable: true
                });
            }
        }
        function caozuo_recommend_sort(item){
            var name = $('#caozuo_field_productsort').val();
            var id = $('#caozuo_id_productsort').val();
            var value = "";
            if(item.text=="是")
            {
                value = "1";
            }
            else if(item.text=="否")
            {
                value = "0";
            }
            $.ajax({
                url:'/admin.php/MallProductSort/recommend',
                data:{"id":id,"name":name,"value":value},
                type:'post',
                success:function(msg){
                    if(msg=="ok")
                    {
                        layer.msg("操作成功");
                        $('#MallProductSort').treegrid('reload');
                        return;
                    }
                    if(msg=="error")
                    {
                        layer.msg("操作失败，请重新操作");
                        return;
                    }
                    if(msg=="id_null")
                    {
                        layer.msg("请选择要操作的数据");
                        return;
                    }
                }
            })
        }
        function caozuo_sequence_sort(item){
            var name = $('#caozuo_field_productsort').val();
            var id = $('#caozuo_id_productsort').val();
            var value = "";
            if(item.text=="置顶")
            {
                value = "0";
            }
            else if(item.text=="上移")
            {
                value = "1";
            }
            else if(item.text=="下移")
            {
                value = "2";
            }
            else if(item.text=="底部")
            {
                value = "3";
            }
            $.ajax({
                url:'/admin.php/MallProductSort/sequence',
                data:{"id":id,"name":name,"value":value},
                type:'post',
                success:function(msg){
                    if(msg=="ok")
                    {
                        layer.msg("操作成功");
                        $('#MallProductSort').treegrid('reload');
                        return;
                    }
                    if(msg=="error")
                    {
                        layer.msg("操作失败，请重新操作");
                        return;
                    }
                    if(msg=="id_null")
                    {
                        layer.msg("请选择要操作的数据");
                        return;
                    }
                }
            })
        }
        function caozuo_sale_sort(item){
            var id = $('#caozuo_id_productsort').val();
            var name = $('#caozuo_field_productsort').val();
            var value = "";
            if(item.text=="上架")
            {
                value = "1";
            }
            else if(item.text=="上架")
            {
                value = "0";
            }
            $.ajax({
                url:'/admin.php/MallProductSort/sale',
                data:{"id":id,"name":name,"value":value},
                type:'post',
                success:function(msg){
                    if(msg=="ok")
                    {
                        layer.msg("操作成功");
                        $('#MallProductSort').treegrid('reload');
                        return;
                    }
                    if(msg=="error")
                    {
                        layer.msg("操作失败，请重新操作");
                        return;
                    }
                    if(msg=="id_null")
                    {
                        layer.msg("请选择要操作的数据");
                        return;
                    }
                }
            })
        }
    </script>
    <script type="text/javascript">
        $(function () {
            $('#btn_save_MallProductSort').click(function () {
                var caozuo = $('#caozuo_MallProductSort').val();
                var Type = $("#MallProductSortName").textbox('getValue');
                var Description = $("#MallProductSortDescription").textbox('getValue');
                var ParentSort = $("#ParentSort").combotree('getValue');
                var Picture = $('#hidden_MallProductSortImage').val()
                $.ajax({
                    url: '/admin.php/MallProductSort/' + caozuo,
                    data: { id: $('#select_MallProductSort').val(), sort_name: Type, parent_id: ParentSort, picture: Picture, Description: Description },
                    type: 'post',
                    success: function (msg) {
                        if (msg == "ok") {
                            alert("保存成功");
                            $('#div_add_MallProductSort').window('close');
                            $('#MallProductSort').treegrid('reload');
                        }
                        else if(msg=="id_null")
                        {
                            alert("请选择要修改的分类");
                        }
                        else if (msg == "sort_name_null")
                        {
                            alert("请输入分类名称");
                        }
                        else if (msg == "parent_id_null")
                        {
                            alert("请选择上级分类");
                        }
                    }
                })
            })

            $('#btn_cancel_MallProductSort').click(function () {
                $('#div_add_MallProductSort').window('close');
            })
        })
    </script>
</body>
</html>