<?php defined('IN_IA') or exit('Access Denied');?>  <script src="<?php echo MODULE_URL;?>/template/xiaoye/js/audioplayer.js"></script>
  <script>
        $(function(){
            $('.voice_<?php  echo $page;?>' ).audioPlayer();
            home_width_con = $(".homework_img_list_control<?php  echo $page;?>");
            $.each(home_width_con,function(i,e){
                img_num = $(this).find('.homework_img_list').length;
                if(img_num){
                    if(img_num==2){
                        this_width  = '350px';
                        this_height = '350px';
                    }else if(img_num==1){
                        this_width  = '600px';
                        this_height = '500px';
                    }
                    if(img_num<3){
                        $(this).find('.homework_img_list').css('height',this_height); 
                        $(this).find('.homework_img_list').css('width',this_width); 
                    }
                }
            });
        });
 </script>
    <?php  if(is_array($list)) { foreach($list as $row) { ?>
        <div class="zy">
        <div class="zy-tp">
            <img style="width:120px;border-radius:50%" src="<?php  echo D('teacher')->teacherImg($row['teacher_id']);?>" style="width:120px;">
        </div>
        <div class="zy-t">
            <p><?php  if($row['teacher_realname']) { ?><?php  echo $row['teacher_realname'];?><?php  } else { ?>管理员<?php  } ?></p>
            <p><span>(<?php  echo $this->courseName($row['course_id']);?>)</span></p>
        </div>
        <div class="zy-tt">
             <a href="<?php  echo $this->createMobileUrl('homeWork_info',array('id'=>$row['homework_id']));?>">
                <p><?php  echo $this->clear_html_short($row['content']);?>......</p>
            </a>
        </div>
        <div class="zy-t-t homework_img_list_control<?php  echo $page;?>">
            <a href="<?php  echo $this->createMobileUrl('homeWork_info',array('id'=>$row['homework_id']));?>" >
                <?php  $urls =  $this->decodeLineImgsToArr($row['img']);?>
                <?php  if($urls) { ?>
                    <?php  if(is_array($urls)) { foreach($urls as $val) { ?>
                     <div class="homework_img_list" style='background-image:url(<?php  echo $val;?>)'></div>
                    <?php  } } ?>
                <?php  } ?>
            </a>
        </div>

            <div class="zy-yyy">
                <?php  if($row['voice']) { ?>
                    <div id="">
                        <audio preload="auto" controls class='voice_<?php  echo $page;?>'>
                            <source src="<?php  echo $this->imgFrom($row['voice'])?>" />
                        </audio>
                    </div>                
                <?php  } ?>
            </div>
            <div class="zy-b">
                    <p><?php  echo date("Y-m-d",$row['add_time']);?>&nbsp;</p>
                    <p><?php  echo date("H:i:s",$row['add_time']);?></p>
            </div>
            <div class="b-tt">
                <img src="<?php echo MODULE_URL;?>/template/xiaoye/img/bo-x.png">
            </div>
        </div>
    <?php  } } ?>