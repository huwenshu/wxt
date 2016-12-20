<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/head', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/head', TEMPLATE_INCLUDEPATH));?>
<script src="<?php echo MODULE_URL;?>/style/js/jquery.min.js"></script>
<script src="<?php echo MODULE_URL;?>/template/xiaoye/js/load.js"></script>
<body style="background: #fafafa;">
<div class="z_main">
  <div class="z_riqi">
    <div class="z_riqil"> <a href="/"><?php  echo $get_year;?>年<br />
      <span><?php  echo $get_month;?>月</span></a> </div>
    <div class="z_leftl">
      <ul>
            <?php  if(is_array($data_list)) { foreach($data_list as $key => $row) { ?>
                <li <?php  if($key==0) { ?> class="z_ri" <?php  } ?>>
                <p  <?php  if($key!=0) { ?> class="p2" <?php  } ?> ><?php  echo $row['week'];?></p>
                <p  class="<?php  echo $row['class_n'];?>"><a href="<?php  echo $this->createMobileUrl('card_record',array('week'=>$row['week']) )?>" ><?php  echo $row['date_d'];?></a></p>
                </li>
            <?php  } } ?>
      </ul>
    </div>
  </div>
  <div class="z_center">
   <?php  if($in_result) { ?> 
       <?php  if(is_array($in_result)) { foreach($in_result as $row) { ?>
            <div class="z_jin">
            <div class="z_jin1" id='img_list_<?php  echo $row['record_id'];?>' > 
                <img src="<?php  echo $row['img_url'];?>"  onclick="displayImage('img_list_<?php  echo $row['record_id'];?>','<?php  echo $row['img_url'];?>')">
                <?php  if($row['img_url2'] ) { ?>
                <img src="<?php  echo $row['img_url2'];?> " onclick="displayImage('img_list_<?php  echo $row['record_id'];?>','<?php  echo $row['img_url2'];?>')">
                <?php  } ?>
            </div>
            <div class="z_jin2"> <span>打卡时间： <?php  if(!$row['play_card_time']) { ?><?php  echo date("H:i:s",$row['add_time'])?> <?php  } else { ?><?php  echo date("H:i:s",$row['play_card_time'])?><?php  } ?></span> 
            <?php  if($row['signTemp']) { ?>
            <span>体温：<span class="p6"><?php  echo $row['signTemp'];?></span></span> </div>
            <?php  } ?>
            <div class="z_jin3 p4">进</div>
            </div>
    <?php  } } ?>
   <?php  } ?>
   <?php  if($out_result) { ?> 
       <?php  if(is_array($out_result)) { foreach($out_result as $row) { ?>
            <div class="z_jin">
            <div class="z_jin1"> <a href="/"><img src="<?php  echo $row['img_url'];?>"></a> </div>
            <div class="z_jin2"> <span>打卡时间： <?php  if(!$row['play_card_time']) { ?><?php  echo date("H:i:s",$row['add_time'])?> <?php  } else { ?><?php  echo date("H:i:s",$row['play_card_time'])?><?php  } ?></span> 
            <?php  if($row['signTemp']) { ?>
            <span>体温：<span class="p6"><?php  echo $row['signTemp'];?></span></span> </div>
            <?php  } ?>
            <div class="z_jin3 p4">出</div>
            </div>
    <?php  } } ?>
   <?php  } ?>
    <?php  if($other_result) { ?> 
       <?php  if(is_array($other_result)) { foreach($other_result as $row) { ?>
            <div class="z_jin">
            <div class="z_jin1"> <a href="/"><img src="<?php  echo $row['img_url'];?>"></a> </div>
            <div class="z_jin2"> <span>打卡时间： <?php  if(!$row['play_card_time']) { ?><?php  echo date("H:i:s",$row['add_time'])?> <?php  } else { ?><?php  echo date("H:i:s",$row['play_card_time'])?><?php  } ?></span> 
            <?php  if($row['signTemp']) { ?>
            <span>体温：<span class="p6"><?php  echo $row['signTemp'];?></span></span> </div>
            <?php  } ?>
            <div class="z_jin3 card_not" >异</div>
            </div>
    <?php  } } ?>
  <?php  } ?> 
  <?php  if(!$in_result && !$out_result && !other_result) { ?>
         <div class="z_jin">
            <div class="z_jin1">  </div>
            <div class="z_jin2"> </span> 
            <div class="z_jin3 card_not" >无</div>
          </div> 
  <?php  } ?>
    <div class="jie"><img src="<?php echo MODULE_URL;?>/template/xiaoye/img/2.png"><span>异常</span><img src="<?php echo MODULE_URL;?>/template/xiaoye/img/1.png"><span>正常</span></div>
  </div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('jsweixin', TEMPLATE_INCLUDEPATH)) : (include template('jsweixin', TEMPLATE_INCLUDEPATH));?>
<?php  $footer_type = 'center';?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/footer', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/footer', TEMPLATE_INCLUDEPATH));?>
</div>
</body>
</html>
