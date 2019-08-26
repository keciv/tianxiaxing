function upload(url,fileID,formID,filePath) {
    var fileName = $('#'+fileID).val();
    fileName = fileName.split("\\"); //这里要将 \ 转义一下
    fileName = fileName[fileName.length - 1];
    shangchuan(url, fileID, formID, 'public/upload/'+filePath+"/");
}
function uploadFile(url, fileID, formID, filePath) {
    var fileName = $('#' + fileID).val();
    fileName = fileName.split("\\"); //这里要将 \ 转义一下
    fileName = fileName[fileName.length - 1];
    shangchuanFile(url, fileID, formID, 'public/upload/' + filePath + "/");
}

function Reset(formID) {
    $(formID).form('reset');
}

function del(tableID, Url) {
    //alert("ok");
    var checked = $(tableID).datagrid('getChecked');
    //alert(checked);
    var delID = "";
    //alert(checked.length);
    if (checked.length > 0) {
        $.messager.confirm('确认', '您确认要删除这些数据吗？', function (r) {
            if (r) {
                //alert("ok");
                for (var i = 0; i < checked.length; i++) {
                    //alert(selected[i].ID);
                    delID += checked[i].ID;
                    delID += ",";
                }

                delID = delID.substr(0, delID.length - 1);
                //alert(delID);

                $.ajax({
                    url: Url,
                    data: { "caozuo": "del", "ID": delID },
                    type: 'post',
                    success: function (msg) {
                        if (msg == "ok") {
                            alert("删除成功");
                            $(tableID).datagrid('reload');
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
function open_newtab(url, title, table) {
    //alert(selected.length);
    var selected = $("#"+title).datagrid('getSelected');
    if (selected) {
        alert(selectID);
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
    else {
        alert("请选择要操作的数据");
    }
}
function picture_more_operation(yulan_id,index){
    $(yulan_id).find('.shangyi').unbind('click');
    $(yulan_id).find('.delete').unbind('click');
    $(yulan_id).find('.xiayi').unbind('click');

    $(yulan_id).find('.img-pra').on("mouseenter",function(){
        $(this).find(".img-hidden").css("display","block");
        $(this).find("i").css("display","block");
    }).on("mouseleave",function(){
        $(this).find(".img-hidden").css("display","none");
        $(this).find("i").css("display","none");
    });
    $(yulan_id).find(".delete").click(function(){
        $(this).parents(".img-pra").remove();
    });
    $(yulan_id).find('.shangyi').click(function(){
        var myIndex = $(this).parents(".img-pra").index();
        if(myIndex>0){
            var my_img = $(this).parents(".img-pra").find('.layui-upload-img');
            var my_src = $(my_img).attr('src');
            var last_img = $(yulan_id).find(".img-pra").eq(myIndex-1).find('.layui-upload-img');
            var last_src = $(last_img).attr('src');
            $(my_img).attr('src',last_src);
            $(last_img).attr('src',my_src);
        }
    });
    $(yulan_id).find('.xiayi').click(function(){
        var myIndex = $(this).parents(".img-pra").index();
        var allNum = $(yulan_id).find('.img-pra').length - 1;
        if(myIndex<allNum){
            var my_img = $(this).parents(".img-pra").find('.layui-upload-img');
            var my_src = $(my_img).attr('src');

            var next_img = $(yulan_id).find(".img-pra").eq(myIndex+1).find('.layui-upload-img')
            var next_src = $(next_img).attr('src');
            
            $(my_img).attr('src',next_src);
            $(next_img).attr('src',my_src);
        }
    })
}