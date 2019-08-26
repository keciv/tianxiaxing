function shangchuan(url,fileID, form, filePath,callback) {
    var options = {
        url: url,
        data: { "filePath": filePath,fileID:fileID },
        type:'post',
        dataType:'json',
        success: function (data) {
            if (data.status=="ok") {
                // layer.msg("上传成功",{icon:6});
                callback(true,data.filename);
            }
            else if (data.status=="null") {
                layer.msg("文件格式有误",{icon:0});
            }
            else if (data.status=="size") {
                layer.msg("文件太大了，请重新上传",{icon:0});
            }
            else if (data.status=="error"){
            	layer.msg("上传失败，请重新上传",{icon:2});
            }
        }
    };
    $('#'+form).ajaxSubmit(options);
}
function shangchuanFile(url, fileID, form, filePath) {
    var options = {
        url: url,
        data: { "filePath": filePath, fileID: fileID },
        type: 'post',
        dataType: 'json',
        success: function (data) {
            $('#hidden_' + fileID).val(data.filename);
            if (data.status == "ok") {
                layer.msg("上传成功",{icon:6});
            }
            else if (data.status == "null") {
                layer.msg("文件格式有误",{icon:0});
            }
            else if (data.status == "error") {
                layer.msg("上传失败，请重新上传",{icon:2});
            }
        }
    };
    $('#' + form).ajaxSubmit(options);
}
function video(url, form, filePath) {
	
    var options = {
        url: url,
        data: { "filePath": filePath },
        dataType:'json',
        
        success: function (msg) {
        	
        	$('#hidden_video').val(msg.b);
            if (msg.a=1) {
                layer.msg("上传成功",{icon:6});
            }
            else if (msg.a=0) {
                layer.msg("文件格式有误",{icon:0});
            }else if (msg.a=-1){
            	layer.msg("上传失败，请重新上传",{icon:2});
            }
        }
    };
    
    $(form).ajaxSubmit(options);
    
}