<?php defined('IN_IA') or exit('Access Denied');?><script>
    var images = {
        localId: [],
        serverId: []
    };    
    document.querySelector('#chooseImage').onclick = function () {
        images.localId='';
        wx.chooseImage({
        count: 1, 
        success: function (res) {
            images.localId = res.localIds;
            $.each(images.localId,function(i,e){
                insertImg(e);
            });
            uploadImg();
        }
        });
    };    
    function uploadImg(){
        if (images.localId.length == 0) {
            alert('请先选择图片');
            return;
        }
        var i = 0, length = images.localId.length;
        images.serverId = [];
        function upload() {
        wx.uploadImage({
            localId: images.localId[i],
            success: function (res) {
            i++;
            images.serverId.push(res.serverId);
            insertValue(res.serverId);
            if (i < length) {
                upload();
            }else{
                $("#uploadImg").html("上传成功");
            }
            },
            fail: function (res) {
            alert(JSON.stringify(res));
            }
        });
        }
        upload();     
    }
    //文件外定义
    // function insertImg(img_src){
    //     $('#img_list').html("<div style='background-size:cover; background-image:url("+img_src+");width:150px;; height:150px;float:left;margin-left:2%;overflow: hidden; margin-bottom:5px;'></div>");
    // }
    function insertValue(value){
        $("#img_value").html("<input type='hidden' name='img_value' value='"+value+"' >");
    }
</script>   