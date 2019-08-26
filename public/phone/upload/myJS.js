function upload(url,fileID,formID,filePath) {

    var fileName = $('#'+fileID).val();
//  console.log(fileName);
    fileName = fileName.split("\\"); //这里要将 \ 转义一下
    fileName = fileName[fileName.length - 1];
    shangchuan(url, fileID, formID, 'public/upload/'+filePath+"/");
}
//视频上传
function uploadViedo(url,fileID,formID,filePath) {

    var fileName = $('#'+fileID).val();
//  console.log(fileName);
    fileName = fileName.split("\\"); //这里要将 \ 转义一下
    fileName = fileName[fileName.length - 1];
    aviedo(url, fileID, formID, 'public/upload/'+filePath+"/");
}	