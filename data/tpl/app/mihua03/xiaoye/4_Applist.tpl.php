<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/head', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/head', TEMPLATE_INCLUDEPATH));?>
<body>
<div class="z_main">
     <div class="head-yy">
        <a href="<?php  echo $this->createMobileUrl('applist')?>" class="pp"><p>预约活动</p></a>
        <a href="<?php  echo $this->createMobileUrl('applist_result')?>"><p>预约结果</p></a>
    </div>
    <?php  if(is_array($list)) { foreach($list as $row) { ?>
            <div class="yy">
                <div class="yy-top">
                <div class="yy-t-l">
                <?php  if($row['status']==1 && $row['appointment_end']>time()  && time()>$row['appointment_start']) { ?>
                    <img src="<?php echo MODULE_URL;?>/template/xiaoye/img/jxz.png">
                <?php  } else if($row['status']==1 && $row['appointment_end']< time() ) { ?>
                    <img src="<?php echo MODULE_URL;?>/template/xiaoye/img/yjs.png">
                <?php  } else if($row['status']==1 && $row['appointment_start']>time() ) { ?>
                    未开始
                <?php  } ?> 
                    <p><?php  echo $row['appointment_name'];?></p>
                    </div>
                <div class="yy-t-r">
                    <p1>申请数</p1>
                    <p2><?php  echo $row['appointment_join_num'];?></p2>
                </div>
                    
                </div>
                <div class="yy-m">
                    <a href="<?php  echo $this->createMobileUrl('appointment_article',array('op'=>$row['appointment_id']));?>"><p>
                        <?php  echo $this->clear_html_short($row['appointment_intro']);?>
                    </p></a>
                </div>
                <div class="yy-b">
                    <p1><?php  if($row['appointment_type_limit']==0) { ?>全校<?php  } else if($row['appointment_type_limit']==1) { ?>年级<?php  } else if($row['appointment_type_limit']==2) { ?>班级<?php  } ?>&nbsp;&nbsp;</p1>
                    <p2><?php  echo date("m-d H:i",$row['appointment_start']);?>--<?php  echo date("m-d H:i",$row['appointment_end']);?></p2>
                </div>
                <div class="y-t"></div>
            </div>
    <?php  } } ?>    
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/footer', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/footer', TEMPLATE_INCLUDEPATH));?>
</body>
</html>