<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/head', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/head', TEMPLATE_INCLUDEPATH));?>
<link rel="canonical" href="/examples/audio-player-responsive-and-touch-friendly">
<body>
<div class="z_main" id='list'>
   <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/HomeWork_ajax', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/HomeWork_ajax', TEMPLATE_INCLUDEPATH));?>
</div>
    <h1 id='add_msg' style="text-align:center;color:#333;font-size:1.5em;margin-top:10px;">...</h1>  
<script>
    var pager=1;
    $(function(){
        $(window).scroll(function(){
            if ($(document).height() - $(this).scrollTop() - $(this).height() < 100){
                pager++;                     
                $.ajax({
                url:'<?php  echo $this->createMobileUrl('homeWork')?>',
                type:'post',
                data:{page:pager,ac:'ajax'},
                dataType:'html',
                success:function(html){
                        if(html=='yes'){
                            $("#add_msg").html('没有啦');
                        }else{
                            $('#list').append(html);   
                        }
                }
                });
            }
        });
    });
</script>
<?php  $footer_type = 'center';?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/footer', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/footer', TEMPLATE_INCLUDEPATH));?>
</body>
</html>
