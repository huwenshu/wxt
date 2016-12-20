<?php defined('IN_IA') or exit('Access Denied');?><script src="<?php echo MODULE_URL;?>/style/js/jquery.min.js"></script>
  <script>
        $(function(){
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
    <li class="z_bj" id="list_id_<?php  echo $row['send_id'];?>">
        <div class="z_bj1">
            <img src="<?php  echo $row['member_img'];?>">
        </div>
        <div class="z_bj11">
            <div class="z_bjt12"><?php  echo $row['member_name'];?><span>(<?php  echo $row['member_name_other'];?>)</span>
            <div class="z_bjt121">
               <?php  if($uid==$row['send_uid']  || $in_type['type']=='teacher' ) { ?>
                <?php  if($in_type['type']=='teacher' && $row['send_status']==2) { ?>
                    <div  class="pass " data-send='<?php  echo $row['send_id'];?>' id="pass<?php  echo $row['send_id'];?>" >
                        <i class="fa fa-check" aria-hidden="true" style="color:#00ff00"></i>
                    </div>                            
                <?php  } ?>
                    <div  data-send='<?php  echo $row['send_id'];?>' class="delete"  >
                        <img src="<?php echo MODULE_URL;?>/template/xiaoye/upimg/delete.png">
                    </div>
                <?php  } ?>
            </div></div>
            <div class="z_bjt13"><?php  echo $row['send_content'];?>
                <?php  if($in_type['type']!='teacher') { ?>
                    <span class='no_pass'><?php  if($row['send_status']==2) { ?>审核中<?php  } ?></span>
                <?php  } ?>
            </div>
            <?php  $urls =  $this->decodeLineImgsToArr($row['send_image']);?>
            <?php  if($urls) { ?>
                <div class="z_bjt14 homework_img_list_control<?php  echo $page;?> " id="img_list_<?php  echo $row['send_id'];?>">
                <?php  if(is_array($urls)) { foreach($urls as $val) { ?>
                        <div class="homework_img_list wx_img_list" data-src="<?php  echo $val;?>" style='background-image:url(<?php  echo $val;?>)' onclick="displayImage('img_list_<?php  echo $row['send_id'];?>','<?php  echo $val;?>')"></div>
                <?php  } } ?>
                </div>
            <?php  } ?> 
            <?php  if($row['sendvideo']) { ?>
            <div class="z_bjt13" style="height:300px;">
            <video src="<?php  echo tomedia($row['sendvideo'])?>" preload="none" controls="controls" style="width: 100%; heigth:300px;" height="300"poster="../addons/lianhu_school/images/jiaxiaotong.png" webkit-playsinline></video>
            </div>
            <?php  } ?>
            <div class="z_bjt15">
                    <p><?php  echo date("m-d H:i",$row['add_time']);?></p>
                    <?php  $zan_have = $this->zanLine($row['send_id']);?>
                    <p class="z_bbt"><a href="javascript:;" class="zan" id="zan_<?php  echo $row['send_id'];?>" data-send='<?php  echo $row['send_id'];?>'> <img src="<?php  if($zan_have==1) { ?><?php echo MODULE_URL;?>/template/xiaoye/img/dz.png<?php  } else { ?><?php echo MODULE_URL;?>/template/xiaoye/img/dz-h.png<?php  } ?>"></a>
                    <a href="javascript:;" class="huifu" data-id='<?php  echo $row['send_id'];?>' ><img src="<?php echo MODULE_URL;?>/template/xiaoye/img/pl.png"></a></p>
            </div>
            <div class="z_bjt16">
                <div class="z_bjt161"></div>
                <div class="z_bjt164">
                <div class="z_bjt162 like_name" id="like_num_<?php  echo $row['send_id'];?>"  style="color:#33cbd5" >
                    <?php  echo D('line')->getLineZanName($row['send_id']);?>
                </div>
                <div class="z_bjt163 comment_list_line"  id="comment_list_line<?php  echo $row['send_id'];?>"  style="color:#33cbd5" >
                    <?php  $comment_list = D('line')->getLineComment($row['send_id']);?>
                    <?php  if($comment_list ) { ?>
                            <?php  if(is_array($comment_list)) { foreach($comment_list as $val) { ?>
                                <p><a href=""><?php  echo $val['nickname'];?></a>：<?php  echo $val['comment_text'];?></p>
                            <?php  } } ?>
                    <?php  } ?>                   
                </div>
                </div>
            </div>
        </div>
    </li>
<?php  } } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/line_js', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/line_js', TEMPLATE_INCLUDEPATH));?>


