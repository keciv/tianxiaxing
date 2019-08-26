function yidong(Url, ID, Type,TableID) {
    //alert("ok");
    $.ajax({
        url: Url,
        data: { ID: ID, caozuo: Type },
        type:'post',
        success: function (msg) {
            if (msg == "ok") {
                alert("移动成功");
                $('#' + TableID).datagrid('reload');
                return;
            }
            if(msg=="error") {
                alert("移动失败，请重新移动");
                return;
            }
            if (msg == "noID")
            {
                alert("请选择要移动的数据");
                return;
            }
            if (msg == "dingduan")
            {
                alert("已经是最顶端了");
                return;
            }
            if (msg == "dibu") {
                alert("已经是最底部了");
                return;
            }
        }
    })
}