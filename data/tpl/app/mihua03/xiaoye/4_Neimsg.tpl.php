<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/head', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/head', TEMPLATE_INCLUDEPATH));?>
<script src="<?php echo MODULE_URL;?>/style/js/jquery.min.js"></script>
<script src="<?php echo MODULE_URL;?>/template/xiaoye/js/load.js"></script>

<body>
<div class="z_main">
 <!--<div class="headtz">
    <a href=""><p>全部</p></a>
    <a href="" class="pp"><p>通知公告</p></a>
    <a href=""><p>失物招领</p></a>
 </div>-->
    <?php  if(is_array($list)) { foreach($list as $row) { ?>
        <div class="tzz">
                <div class="top">
                    <div class="t-rq">
                        <p><?php  echo date("m-d",$row['addtime'])?></p>
                    </div>
                        <div class="t-fb">
                            <p1>发布者：<?php  echo $row['admin_name'];?></p1>
                        </div>
                </div>
                    <div class="tz-nr">
                        <a href="<?php  echo $this->createMobileUrl("msg_content",array('id'=>$row['msg_id']));?>">
                            <p class="p"><?php  echo $row['msg_title'];?></p>
                        </a>
                    </div>
                    <div class="tz-nn">
                        <p class="p"><?php  echo S('fun','formatLimitContent',array($row['msg_content'],50));?>...</p>
                    </div>
                         <?php  if($row['img']) { ?>
                        <div class="tz-tp"  id='img_list_<?php  echo $row['msg_id'];?>'>
                             <img src="<?php  echo $_W['attachurl'];?><?php  echo $row['img'];?>" onclick="displayImage('img_list_<?php  echo $row['msg_id'];?>','<?php  echo $_W['attachurl'];?><?php  echo $row['img'];?>')" >
                        </div>                   
                         <?php  } ?>
                    <div class="tz-mm"></div>
           </div>
    <?php  } } ?>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('jsweixin', TEMPLATE_INCLUDEPATH)) : (include template('jsweixin', TEMPLATE_INCLUDEPATH));?>
    <?php  $footer_type = 'center';?>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/footer', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/footer', TEMPLATE_INCLUDEPATH));?>
  </div>
</body>
</html>
