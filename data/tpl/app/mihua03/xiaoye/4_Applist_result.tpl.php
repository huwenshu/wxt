<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/head', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/head', TEMPLATE_INCLUDEPATH));?>
<body>
<div class="z_main">
     <div class="head-yy">
        <a href="<?php  echo $this->createMobileUrl('applist')?>"><p>预约活动</p></a>
        <a href="<?php  echo $this->createMobileUrl('applist_result')?>"  class="pp"><p>预约结果</p></a>
    </div>
    <?php  if(is_array($list)) { foreach($list as $row) { ?>
            <div class="yy">
                <div class="yy-top">
                    <div class="yy-t-l">
                        <?php  if($row['status']==0) { ?>
                        <img src="<?php echo MODULE_URL;?>/template/xiaoye/img/jxz.png">
                        <?php  } else if($row['status']==2) { ?>
                        <img src="<?php echo MODULE_URL;?>/template/xiaoye/img/jxz.png">
                        <?php  } ?>
                        <p><?php  echo $row['my_course'];?></p>
                        </div>
                        <div class="yy-t-r">
                            <p2></p2>
                        </div>
                </div>
                <?php  if($row['reason']) { ?>
                    <div class="yy-m">
                        <a href=""><p>
                            <?php  echo $row['reason'];?>
                        </p></a>
                    </div>
                <?php  } ?>
                <div class="yy-b">
                    <p2><?php  echo date("Y-m-d H:i:s",$row['addtime']);?></p2>
                </div>
                <div class="y-t"></div>
            </div>
    <?php  } } ?>    
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/footer', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/footer', TEMPLATE_INCLUDEPATH));?>
</body>
</html>