<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/head', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/head', TEMPLATE_INCLUDEPATH));?>
<body>
<div class="z_main">
    <div class="head">
        <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <a href="<?php  echo $this->createMobileUrl('record',array('op'=>$row['class_id']));?>" <?php  if($class_id==$row['class_id']) { ?>class="pp"<?php  } ?>  ><p> <?php  echo $row['class_name'];?></p></a>
        <?php  } } ?>
    </div>
    <div class="MD">
          <?php  if(is_array($jilv_list)) { foreach($jilv_list as $row) { ?>
                <li class="dpl">
                    <div class="WX"> <a href="<?php  echo $this->createMobileUrl('record_article',array('wid'=>$row['work_id']));?>"><img style="width:120px;border-radius:50%" src="<?php  echo D('teacher')->teacherImg($row['teacher_id']);?>"></a></div>
                    <div class="WZ" >
                        <a href="<?php  echo $this->createMobileUrl('record_article',array('wid'=>$row['work_id']));?>" >
                            <p><span class="W-1"><?php  if($row['teacher_realname']) { ?><?php  echo $row['teacher_realname'];?><?php  } else { ?>管理员<?php  } ?></span>
                            <!--<span class="W-2">(语文老师)</span>-->
                        </p>
                            <p class="W-3"><?php  echo $this->clear_html_short($row['content']);?>......</p>
                        </a>
                    </div>
                </li>
            <?php  } } ?> 
    </div>
</div>
<?php  $footer_type = 'center';?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/footer', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/footer', TEMPLATE_INCLUDEPATH));?>
</body>
</html>