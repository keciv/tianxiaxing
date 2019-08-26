function shangchuan(url,fileID, form, filePath) {
	//console.log(form);
    var options = {
        url: url,
        data: { "filePath": filePath,fileID:fileID ,'file':$("#file1").val()},
        type:'post',
        dataType:'json',
        success: function (data) {
        	//console.log(data);
            if (data.status=="ok") {
            	layer.msg("图片添加完成");
             $('#img').attr('src','/'+data.filename);
             $('#bigimg').attr('src','/'+data.filename);
            }
            else if (data.status=="null") {
                alert("文件格式有误");
            }
            else if (data.status=="error"){
            	 alert("上传失败，请重新上传");
            }
        }
    };
  $('#'+form).ajaxSubmit(options);

}	
//视频上传
function aviedo(url,fileID, form, filePath) {
	//console.log(form);
    var options = {
        url: url,
        data: { "filePath": filePath,fileID:fileID ,'file':$("#file2").val()},
        type:'post',
        dataType:'json',
        success: function (data) {
        	//console.log(data);
        	if (data.status=="ok") {
            	layer.msg("视频添加完成");
             $('#dataUrl2').text(data.filename);
             $('#hiddenViedo').css('display','none');
             $('#viedotext').text('视频文件上传成功');
             $('#viedotext1').text(' ');
            }
            else if (data.status=="null") {
                alert("视频文件格式有误");
            }
            else if (data.status=="error"){
            	 alert("上传失败，请重新上传");
            }
        }
    };
  $('#'+form).ajaxSubmit(options);

}	