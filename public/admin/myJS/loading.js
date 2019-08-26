$(function () {
    $(window).resize(function () {
        $('#Div_xiadan').window('center');
    });
    //提示框：正在搜索
    $('#loading').window({
        noheader: true,
        modal: true,
        width: 200,
        height: 100,
        closed: true,
        modal: true
    })
})