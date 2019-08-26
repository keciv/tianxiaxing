function createKindeditor(textareaID) {
    var options = {
        themeType: 'default',   //指定主题风格，可设置”default”、”simple”，指定simple时需要引入simple.css; 默认值: “default”  
        resizeType: 2,           //2或1或0，2时可以拖动改变宽度和高度，1时只能改变高度，0时不能拖动;默认值: 2  
        height:'400px',
        width : '100%',
        minWidth:'100%',
        allowFileManager: false,   //true时显示浏览远程服务器按钮 ;默认值: false  
        allowMediaUpload: false, //true时显示视音频上传按钮。默认值: true  
        allowFlashUpload: false, //true时显示Flash上传按钮;默认值: true  
        uploadJson: '/jiayuan/public/kindeditor/php/upload_json.php',          //指定上传文件的服务器端程序  
        fileManagerJson: '/jiayuan/public/kindEditor/php/file_manager_json.php',     //指定浏览远程图片的服务器端程序  
        afterCreate: function () { //加载完成后改变皮肤  
            var color = $('.panel-header').css('background-color');
            $('.ke-toolbar').css('background-color', color);
        },
        afterBlur: function () {
            this.sync();
        }
    };
    KindEditor.create(textareaID, options);
}
function create_phone_Kindeditor(textareaID) {
    var options = {
        themeType: 'default',   //指定主题风格，可设置”default”、”simple”，指定simple时需要引入simple.css; 默认值: “default”  
        resizeType: 1,           //2或1或0，2时可以拖动改变宽度和高度，1时只能改变高度，0时不能拖动;默认值: 2  
        height:'400px',
        width : '100%',
        minWidth:'100%',
        allowFileManager: false,   //true时显示浏览远程服务器按钮 ;默认值: false  
        allowMediaUpload: false, //true时显示视音频上传按钮。默认值: true  
        allowFlashUpload: false, //true时显示Flash上传按钮;默认值: true  
        uploadJson: '/public/kindeditor/php/upload_json.php',          //指定上传文件的服务器端程序  
        fileManagerJson: '/public/kindEditor/php/file_manager_json.php',     //指定浏览远程图片的服务器端程序  
        items: ['fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'image', 'media', 'emoticons', 'link', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist',],
        afterCreate: function () { //加载完成后改变皮肤  
            var color = $('.panel-header').css('background-color');
            $('.ke-toolbar').css('background-color', color);
        },
        afterBlur: function () {
            this.sync();
        }
    };
    KindEditor.create(textareaID, options);
}